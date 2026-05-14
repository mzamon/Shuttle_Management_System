<?php
/**
 * Vehicle Management Class
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

class Vehicle {
    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }
    
    /**
     * Get all vehicles
     */
    public function getAll(): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM vehicles WHERE status != ? ORDER BY registrationNumber ASC'
        );
        $inactive = 'maintenance';
        $stmt->bind_param('s', $inactive);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $vehicles = [];
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }
        return $vehicles;
    }
    
    /**
     * Get available vehicles
     */
    public function getAvailable(): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM vehicles WHERE status = ? ORDER BY registrationNumber ASC'
        );
        $status = 'available';
        $stmt->bind_param('s', $status);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $vehicles = [];
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }
        return $vehicles;
    }
    
    /**
     * Get vehicle by ID
     */
    public function getById(int $vehicleId): ?array {
        $stmt = $this->db->prepare('SELECT * FROM vehicles WHERE vehicleId = ?');
        $stmt->bind_param('i', $vehicleId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }
    
    /**
     * Update vehicle status
     */
    public function updateStatus(int $vehicleId, string $status): array {
        $valid = ['available', 'in-use', 'maintenance'];
        
        if (!in_array($status, $valid)) {
            return ['success' => false, 'errors' => ['Invalid status']];
        }
        
        try {
            $stmt = $this->db->prepare('UPDATE vehicles SET status = ? WHERE vehicleId = ?');
            $stmt->bind_param('si', $status, $vehicleId);
            
            if ($stmt->execute()) {
                logMessage("Vehicle status updated: ID=$vehicleId, Status=$status", 'INFO');
                return ['success' => true, 'message' => 'Status updated'];
            }
            
            throw new \Exception($this->db->error);
        } catch (\Exception $e) {
            logMessage("Vehicle status update error: " . $e->getMessage(), 'ERROR');
            return ['success' => false, 'errors' => ['Update failed']];
        }
    }
}

?>
