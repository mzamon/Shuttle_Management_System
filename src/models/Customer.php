<?php
/**
 * Customer Management Class
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

class Customer {
    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }
    
    /**
     * Create customer
     */
    public function create(string $fullName, string $phone, string $email = '', string $preferences = ''): array {
        $errors = [];
        
        if (empty($fullName)) $errors[] = 'Customer name required';
        if (validatePhone($phone)) $errors[] = validatePhone($phone);
        if (!empty($email) && validateEmail($email)) $errors[] = validateEmail($email);
        
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        try {
            $phone = sanitizePhone($phone);
            $email = sanitizeEmail($email);
            $now = getCurrentDateTime();
            
            $stmt = $this->db->prepare(
                'INSERT INTO customers (fullName, phoneNumber, emailAddress, preferences, createdAt) 
                 VALUES (?, ?, ?, ?, ?)'
            );
            $stmt->bind_param('sssss', $fullName, $phone, $email, $preferences, $now);
            
            if ($stmt->execute()) {
                $customerId = $this->db->insert_id;
                logMessage("Customer created: ID=$customerId, Name=$fullName", 'INFO');
                return ['success' => true, 'message' => 'Customer created', 'data' => ['customerId' => $customerId]];
            }
            
            throw new \Exception($this->db->error);
        } catch (\Exception $e) {
            logMessage("Customer creation error: " . $e->getMessage(), 'ERROR');
            return ['success' => false, 'errors' => ['Creation failed']];
        }
    }
    
    /**
     * Get customer by ID
     */
    public function getById(int $customerId): ?array {
        $stmt = $this->db->prepare(
            'SELECT * FROM customers WHERE customerId = ?'
        );
        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }
    
    /**
     * Search customers
     */
    public function search(string $query): array {
        $search = '%' . $query . '%';
        $stmt = $this->db->prepare(
            'SELECT * FROM customers 
             WHERE fullName LIKE ? OR phoneNumber LIKE ? OR emailAddress LIKE ?
             LIMIT 20'
        );
        $stmt->bind_param('sss', $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
        return $customers;
    }
    
    /**
     * Get booking history
     */
    public function getBookingHistory(int $customerId): array {
        $stmt = $this->db->prepare(
            'SELECT b.*, d.fullName as driverName, v.registrationNumber 
             FROM bookings b
             LEFT JOIN drivers d ON b.driverId = d.driverId
             LEFT JOIN vehicles v ON b.vehicleId = v.vehicleId
             WHERE b.customerId = ?
             ORDER BY b.bookingDate DESC'
        );
        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $bookings = [];
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
        return $bookings;
    }
    
    /**
     * Update customer
     */
    public function update(int $customerId, array $fields): array {
        $allowed = ['fullName', 'phoneNumber', 'emailAddress', 'preferences'];
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
                $types .= 's';
            }
            
            $params[] = $customerId;
            $types .= 'i';
            
            $sql = 'UPDATE customers SET ' . implode(', ', $set) . ' WHERE customerId = ?';
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param($types, ...$params);
            
            if ($stmt->execute()) {
                logMessage("Customer updated: ID=$customerId", 'INFO');
                return ['success' => true, 'message' => 'Customer updated'];
            }
            
            throw new \Exception($this->db->error);
        } catch (\Exception $e) {
            logMessage("Customer update error: " . $e->getMessage(), 'ERROR');
            return ['success' => false, 'errors' => ['Update failed']];
        }
    }
    
    /**
     * Get top customers
     */
    public function getTopCustomers(int $limit = 10): array {
        $stmt = $this->db->prepare(
            'SELECT c.*, COUNT(b.bookingId) as totalTrips, SUM(b.fareAmount) as totalSpent
             FROM customers c
             LEFT JOIN bookings b ON c.customerId = b.customerId
             GROUP BY c.customerId
             ORDER BY totalSpent DESC
             LIMIT ?'
        );
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
        return $customers;
    }
    
    /**
     * Get or create customer by phone
     */
    public function getOrCreateByPhone(string $fullName, string $phone): int {
        $phone = sanitizePhone($phone);
        
        $stmt = $this->db->prepare('SELECT customerId FROM customers WHERE phoneNumber = ?');
        $stmt->bind_param('s', $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['customerId'];
        }
        
        // Create new customer
        $result = $this->create($fullName, $phone);
        if ($result['success']) {
            return $result['data']['customerId'];
        }
        
        return 0;
    }
}

?>
