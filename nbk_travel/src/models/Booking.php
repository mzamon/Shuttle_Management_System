<?php
/**
 * Booking Management Class
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

class Booking {
    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }
    
    /**
     * Create new booking
     */
    public function create(int $customerId, string $pickup, string $dropoff, string $bookingDate, int $passengers, float $fare, ?string $notes = null): array {
        $errors = [];
        
        // Validation
        if (empty($pickup)) $errors[] = 'Pickup location required';
        if (empty($dropoff)) $errors[] = 'Drop-off location required';
        if ($passengers < 1) $errors[] = 'Passengers must be at least 1';
        if ($fare < 100) $errors[] = 'Fare must be at least R100';
        if (!isFutureDateTime($bookingDate)) $errors[] = 'Booking date must be in future';
        
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        try {
            $reference = generateBookingReference();
            $status = 'pending';
            $now = getCurrentDateTime();
            
            $stmt = $this->db->prepare(
                'INSERT INTO bookings (bookingReference, customerId, pickupLocation, dropoffLocation, bookingDate, passengers, fareAmount, status, notes, createdAt) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            
            $stmt->bind_param('iisssidsss', $customerId, $customerId, $pickup, $dropoff, $bookingDate, $passengers, $fare, $status, $notes, $now);
            
            if (!$stmt->execute()) {
                throw new \Exception($this->db->error);
            }
            
            $bookingId = $this->db->insert_id;
            
            // Log notification
            $this->logNotification('customer', $customerId, 'email', "Booking $reference confirmed. Pickup: $pickup", $reference);
            
            logMessage("Booking created: ID=$bookingId, Reference=$reference", 'INFO');
            
            return [
                'success' => true,
                'message' => "Booking $reference created successfully",
                'data' => [
                    'bookingId' => $bookingId,
                    'reference' => $reference
                ]
            ];
        } catch (\Exception $e) {
            logMessage("Booking creation error: " . $e->getMessage(), 'ERROR');
            return ['success' => false, 'errors' => ['Booking creation failed']];
        }
    }
    
    /**
     * Get booking by ID
     */
    public function getById(int $bookingId): ?array {
        $stmt = $this->db->prepare(
            'SELECT b.*, c.fullName, c.phoneNumber, d.fullName as driverName, v.registrationNumber
             FROM bookings b 
             LEFT JOIN customers c ON b.customerId = c.customerId
             LEFT JOIN drivers d ON b.driverId = d.driverId
             LEFT JOIN vehicles v ON b.vehicleId = v.vehicleId
             WHERE b.bookingId = ?'
        );
        $stmt->bind_param('i', $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }
    
    /**
     * Get all bookings with pagination
     */
    public function getAll(int $page = 1, int $limit = RECORDS_PER_PAGE, ?string $status = null): array {
        $offset = ($page - 1) * $limit;
        $sql = 'SELECT b.*, c.fullName, c.phoneNumber, d.fullName as driverName 
                FROM bookings b 
                LEFT JOIN customers c ON b.customerId = c.customerId
                LEFT JOIN drivers d ON b.driverId = d.driverId';
        
        $params = [];
        $types = '';
        
        if ($status) {
            $sql .= ' WHERE b.status = ?';
            $params[] = $status;
            $types .= 's';
        }
        
        $sql .= ' ORDER BY b.bookingDate DESC LIMIT ? OFFSET ?';
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';
        
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        $bookings = [];
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
        
        // Get total count
        $countSql = 'SELECT COUNT(*) as total FROM bookings';
        if ($status) {
            $countSql .= ' WHERE status = ?';
        }
        
        $stmtCount = $this->db->prepare($countSql);
        if ($status) {
            $stmtCount->bind_param('s', $status);
        }
        $stmtCount->execute();
        $countResult = $stmtCount->get_result();
        $countRow = $countResult->fetch_assoc();
        
        return [
            'data' => $bookings,
            'total' => $countRow['total'],
            'page' => $page,
            'limit' => $limit,
            'pages' => ceil($countRow['total'] / $limit)
        ];
    }
    
    /**
     * Update booking
     */
    public function update(int $bookingId, array $fields): array {
        $allowed = ['pickupLocation', 'dropoffLocation', 'bookingDate', 'passengers', 'fareAmount', 'notes'];
        $fields = array_filter($fields, function ($key) use ($allowed) {
            return in_array($key, $allowed);
        }, ARRAY_FILTER_USE_KEY);
        
        if (empty($fields)) {
            return ['success' => false, 'errors' => ['No fields to update']];
        }
        
        try {
            $set = [];
            $params = [];
            $types = '';
            
            foreach ($fields as $key => $value) {
                $set[] = "$key = ?";
                $params[] = $value;
                $types .= ($key === 'passengers' || $key === 'fareAmount') ? 'd' : 's';
            }
            
            $params[] = $bookingId;
            $types .= 'i';
            
            $sql = 'UPDATE bookings SET ' . implode(', ', $set) . ' WHERE bookingId = ?';
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param($types, ...$params);
            
            if ($stmt->execute()) {
                logMessage("Booking updated: ID=$bookingId", 'INFO');
                return ['success' => true, 'message' => 'Booking updated successfully'];
            }
            
            throw new \Exception($this->db->error);
        } catch (\Exception $e) {
            logMessage("Booking update error: " . $e->getMessage(), 'ERROR');
            return ['success' => false, 'errors' => ['Update failed']];
        }
    }
    
    /**
     * Cancel booking
     */
    public function cancel(int $bookingId, string $reason): array {
        try {
            $stmt = $this->db->prepare(
                'UPDATE bookings SET status = ?, cancellationReason = ? WHERE bookingId = ?'
            );
            $status = 'cancelled';
            $stmt->bind_param('ssi', $status, $reason, $bookingId);
            
            if ($stmt->execute()) {
                // Get booking to notify customer
                $booking = $this->getById($bookingId);
                if ($booking) {
                    $this->logNotification('customer', $booking['customerId'], 'email', 
                        "Booking {$booking['bookingReference']} has been cancelled. Reason: $reason", 
                        $booking['bookingReference']);
                }
                
                logMessage("Booking cancelled: ID=$bookingId, Reason=$reason", 'INFO');
                return ['success' => true, 'message' => 'Booking cancelled successfully'];
            }
            
            throw new \Exception($this->db->error);
        } catch (\Exception $e) {
            logMessage("Booking cancellation error: " . $e->getMessage(), 'ERROR');
            return ['success' => false, 'errors' => ['Cancellation failed']];
        }
    }
    
    /**
     * Assign driver and vehicle to booking
     */
    public function assign(int $bookingId, int $driverId, int $vehicleId): array {
        try {
            // Get booking details
            $booking = $this->getById($bookingId);
            if (!$booking) {
                return ['success' => false, 'errors' => ['Booking not found']];
            }
            
            // Check for conflicts
            $conflict = $this->detectConflict($driverId, $vehicleId, $booking['bookingDate'], 2);
            if ($conflict) {
                return ['success' => false, 'message' => 'Schedule conflict detected', 'conflict' => true];
            }
            
            // Update booking
            $stmt = $this->db->prepare('UPDATE bookings SET driverId = ?, vehicleId = ?, status = ? WHERE bookingId = ?');
            $status = 'confirmed';
            $stmt->bind_param('iisi', $driverId, $vehicleId, $status, $bookingId);
            
            if (!$stmt->execute()) {
                throw new \Exception($this->db->error);
            }
            
            // Create schedule entry
            $startTime = $booking['bookingDate'];
            $endTime = date(DATETIME_FORMAT, strtotime($startTime) + 3600); // Add 1 hour
            
            $stmtSchedule = $this->db->prepare(
                'INSERT INTO schedules (bookingId, driverId, vehicleId, scheduledStart, scheduledEnd) VALUES (?, ?, ?, ?, ?)'
            );
            $stmtSchedule->bind_param('iisss', $bookingId, $driverId, $vehicleId, $startTime, $endTime);
            $stmtSchedule->execute();
            
            // Notify driver
            $this->logNotification('driver', $driverId, 'sms',
                "Trip assigned: {$booking['pickupLocation']} to {$booking['dropoffLocation']} at {$booking['bookingDate']}", 
                $booking['bookingReference']);
            
            logMessage("Assignment: Booking=$bookingId, Driver=$driverId, Vehicle=$vehicleId", 'INFO');
            return ['success' => true, 'message' => 'Assignment successful'];
            
        } catch (\Exception $e) {
            logMessage("Assignment error: " . $e->getMessage(), 'ERROR');
            return ['success' => false, 'errors' => ['Assignment failed']];
        }
    }
    
    /**
     * Detect schedule conflicts
     */
    public function detectConflict(int $driverId, int $vehicleId, string $bookingDateTime, int $durationHours = 2): bool {
        $startTime = $bookingDateTime;
        $endTime = date(DATETIME_FORMAT, strtotime($startTime) + ($durationHours * 3600));
        
        $sql = 'SELECT COUNT(*) as conflicts FROM schedules 
                WHERE (driverId = ? OR vehicleId = ?)
                AND ((scheduledStart < ? AND scheduledEnd > ?)
                     OR (scheduledStart >= ? AND scheduledStart < ?))';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('iissss', $driverId, $vehicleId, $endTime, $startTime, $startTime, $endTime);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['conflicts'] > 0;
    }
    
    /**
     * Mark trip as completed
     */
    public function completeTrip(int $bookingId, int $driverId): array {
        try {
            $now = getCurrentDateTime();
            
            // Update booking
            $stmt = $this->db->prepare('UPDATE bookings SET status = ? WHERE bookingId = ? AND driverId = ?');
            $status = 'completed';
            $stmt->bind_param('sii', $status, $bookingId, $driverId);
            
            if (!$stmt->execute()) {
                throw new \Exception($this->db->error);
            }
            
            // Update schedule
            $stmtSchedule = $this->db->prepare('UPDATE schedules SET actualEnd = ? WHERE bookingId = ?');
            $stmtSchedule->bind_param('si', $now, $bookingId);
            $stmtSchedule->execute();
            
            // Get booking to notify customer
            $booking = $this->getById($bookingId);
            if ($booking) {
                $this->logNotification('customer', $booking['customerId'], 'email',
                    "Your trip {$booking['bookingReference']} has been completed. Invoice available.",
                    $booking['bookingReference']);
            }
            
            logMessage("Trip completed: Booking=$bookingId, Driver=$driverId", 'INFO');
            return ['success' => true, 'message' => 'Trip marked as completed'];
            
        } catch (\Exception $e) {
            logMessage("Trip completion error: " . $e->getMessage(), 'ERROR');
            return ['success' => false, 'errors' => ['Completion failed']];
        }
    }
    
    /**
     * Log notification
     */
    private function logNotification(string $type, int $recipientId, string $channel, string $message, string $reference): void {
        try {
            $now = getCurrentDateTime();
            $stmt = $this->db->prepare(
                'INSERT INTO notifications (recipientType, recipientId, channel, messageBody, bookingReference, sentAt, status) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)'
            );
            $status = 'logged';
            $stmt->bind_param('ssissss', $type, $recipientId, $channel, $message, $reference, $now, $status);
            $stmt->execute();
        } catch (\Exception $e) {
            logMessage("Notification logging error: " . $e->getMessage(), 'WARN');
        }
    }
}

?>
