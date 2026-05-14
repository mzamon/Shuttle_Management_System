<?php
/**
 * Driver Management Class
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

class Driver {
    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }
    
    /**
     * Get all drivers
     */
    public function getAll(): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM drivers WHERE status != ? ORDER BY fullName ASC'
        );
        $inactive = 'inactive';
        $stmt->bind_param('s', $inactive);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $drivers = [];
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }
        return $drivers;
    }
    
    /**
     * Get driver by ID
     */
    public function getById(int $driverId): ?array {
        $stmt = $this->db->prepare('SELECT * FROM drivers WHERE driverId = ?');
        $stmt->bind_param('i', $driverId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }
    
    /**
     * Get available drivers
     */
    public function getAvailable(): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM drivers WHERE status = ? ORDER BY fullName ASC'
        );
        $status = 'available';
        $stmt->bind_param('s', $status);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $drivers = [];
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }
        return $drivers;
    }
    
    /**
     * Get assigned trips
     */
    public function getAssignedTrips(int $driverId): array {
        $stmt = $this->db->prepare(
            'SELECT b.*, c.fullName, c.phoneNumber, v.registrationNumber
             FROM bookings b
             JOIN schedules s ON b.bookingId = s.bookingId
             JOIN customers c ON b.customerId = c.customerId
             JOIN vehicles v ON b.vehicleId = v.vehicleId
             WHERE s.driverId = ? AND b.status IN (?, ?)
             ORDER BY b.bookingDate ASC'
        );
        $confirmed = 'confirmed';
        $pending = 'pending';
        $stmt->bind_param('iss', $driverId, $confirmed, $pending);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $trips = [];
        while ($row = $result->fetch_assoc()) {
            $trips[] = $row;
        }
        return $trips;
    }
    
    /**
     * Get driver statistics
     */
    public function getStats(int $driverId, string $startDate, string $endDate): array {
        $stmt = $this->db->prepare(
            'SELECT COUNT(DISTINCT b.bookingId) as totalTrips,
                    SUM(TIMESTAMPDIFF(HOUR, s.scheduledStart, s.scheduledEnd)) as totalHours,
                    SUM(b.fareAmount) as totalEarnings
             FROM schedules s
             JOIN bookings b ON s.bookingId = b.bookingId
             WHERE s.driverId = ? AND b.bookingDate BETWEEN ? AND ?'
        );
        $stmt->bind_param('iss', $driverId, $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc() ?: [
            'totalTrips' => 0,
            'totalHours' => 0,
            'totalEarnings' => 0
        ];
    }
    
    /**
     * Update driver status
     */
    public function updateStatus(int $driverId, string $status): array {
        $valid = ['available', 'on-trip', 'off-duty', 'inactive'];
        
        if (!in_array($status, $valid)) {
            return ['success' => false, 'errors' => ['Invalid status']];
        }
        
        try {
            $stmt = $this->db->prepare('UPDATE drivers SET status = ? WHERE driverId = ?');
            $stmt->bind_param('si', $status, $driverId);
            
            if ($stmt->execute()) {
                logMessage("Driver status updated: ID=$driverId, Status=$status", 'INFO');
                return ['success' => true, 'message' => 'Status updated'];
            }
            
            throw new \Exception($this->db->error);
        } catch (\Exception $e) {
            logMessage("Driver status update error: " . $e->getMessage(), 'ERROR');
            return ['success' => false, 'errors' => ['Update failed']];
        }
    }
}

?>
