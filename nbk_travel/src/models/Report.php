<?php
/**
 * Reporting Class
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

class Report {
    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }
    
    /**
     * Trip count report
     */
    public function getTripReport(string $startDate, string $endDate): array {
        $stmt = $this->db->prepare(
            'SELECT DATE(bookingDate) as date, COUNT(*) as tripCount, status
             FROM bookings
             WHERE bookingDate BETWEEN ? AND ?
             GROUP BY DATE(bookingDate), status
             ORDER BY date DESC'
        );
        $stmt->bind_param('ss', $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    
    /**
     * Revenue report
     */
    public function getRevenueReport(string $startDate, string $endDate): array {
        $stmt = $this->db->prepare(
            'SELECT DATE(bookingDate) as date, 
                    COUNT(*) as tripCount,
                    SUM(fareAmount) as totalRevenue,
                    AVG(fareAmount) as avgFare
             FROM bookings
             WHERE bookingDate BETWEEN ? AND ? AND status IN (?, ?)
             GROUP BY DATE(bookingDate)
             ORDER BY date DESC'
        );
        $completed = 'completed';
        $confirmed = 'confirmed';
        $stmt->bind_param('ssss', $startDate, $endDate, $completed, $confirmed);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        $total = 0;
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
            $total += $row['totalRevenue'] ?? 0;
        }
        
        return [
            'daily' => $data,
            'total' => $total
        ];
    }
    
    /**
     * Top customers report
     */
    public function getTopCustomersReport(int $limit = 10): array {
        $stmt = $this->db->prepare(
            'SELECT c.customerId, c.fullName, c.phoneNumber, c.emailAddress,
                    COUNT(b.bookingId) as totalBookings,
                    SUM(b.fareAmount) as totalSpent
             FROM customers c
             LEFT JOIN bookings b ON c.customerId = b.customerId
             GROUP BY c.customerId
             ORDER BY totalSpent DESC
             LIMIT ?'
        );
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    
    /**
     * Driver utilisation report
     */
    public function getDriverUtilisationReport(string $startDate, string $endDate): array {
        $stmt = $this->db->prepare(
            'SELECT d.driverId, d.fullName, d.phoneNumber,
                    COUNT(DISTINCT b.bookingId) as totalTrips,
                    SUM(TIMESTAMPDIFF(HOUR, s.scheduledStart, s.scheduledEnd)) as totalHours,
                    SUM(b.fareAmount) as totalEarnings
             FROM drivers d
             LEFT JOIN schedules s ON d.driverId = s.driverId
             LEFT JOIN bookings b ON s.bookingId = b.bookingId AND b.bookingDate BETWEEN ? AND ?
             GROUP BY d.driverId
             ORDER BY totalTrips DESC'
        );
        $stmt->bind_param('ss', $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    
    /**
     * Dashboard statistics
     */
    public function getDashboardStats(): array {
        $today = getCurrentDate();
        
        // Total bookings today
        $stmt1 = $this->db->prepare(
            'SELECT COUNT(*) as total FROM bookings WHERE DATE(bookingDate) = ?'
        );
        $stmt1->bind_param('s', $today);
        $stmt1->execute();
        $result1 = $stmt1->get_result()->fetch_assoc();
        
        // Completed trips today
        $stmt2 = $this->db->prepare(
            'SELECT COUNT(*) as total FROM bookings WHERE DATE(bookingDate) = ? AND status = ?'
        );
        $completed = 'completed';
        $stmt2->bind_param('ss', $today, $completed);
        $stmt2->execute();
        $result2 = $stmt2->get_result()->fetch_assoc();
        
        // Revenue today
        $stmt3 = $this->db->prepare(
            'SELECT SUM(fareAmount) as total FROM bookings WHERE DATE(bookingDate) = ? AND status IN (?, ?)'
        );
        $stmt3->bind_param('sss', $today, $completed, 'confirmed');
        $stmt3->execute();
        $result3 = $stmt3->get_result()->fetch_assoc();
        
        // Active drivers
        $stmt4 = $this->db->prepare(
            'SELECT COUNT(*) as total FROM drivers WHERE status IN (?, ?)'
        );
        $ontrip = 'on-trip';
        $available = 'available';
        $stmt4->bind_param('ss', $ontrip, $available);
        $stmt4->execute();
        $result4 = $stmt4->get_result()->fetch_assoc();
        
        return [
            'totalBookingsToday' => $result1['total'] ?? 0,
            'completedTripsToday' => $result2['total'] ?? 0,
            'revenueToday' => $result3['total'] ?? 0,
            'activeDrivers' => $result4['total'] ?? 0
        ];
    }
}

?>
