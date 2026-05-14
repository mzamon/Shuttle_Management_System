<?php
/**
 * API: Reports & Analytics
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once '../includes/db.php';
require_once '../includes/auth_check.php';

header('Content-Type: application/json');

if ($_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Dashboard Metrics
    if ($action === 'dashboard') {
        $totalBookings = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
        $totalCustomers = $conn->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'];
        $todayTrips = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE DATE(bookingDate) = CURDATE()")->fetch_assoc()['count'];
        $totalRevenue = $conn->query("SELECT SUM(fareAmount) as total FROM bookings WHERE status = 'completed'")->fetch_assoc()['total'] ?? 0;

        echo json_encode([
            'success' => true,
            'data' => [
                'totalBookings' => $totalBookings,
                'totalCustomers' => $totalCustomers,
                'todayTrips' => $todayTrips,
                'totalRevenue' => $totalRevenue
            ]
        ]);
    }

    // Trip Count Report
    if ($action === 'trips') {
        $startDate = $_GET['start'] ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $_GET['end'] ?? date('Y-m-d');

        $stmt = $conn->prepare("SELECT DATE(bookingDate) as date, COUNT(*) as count FROM bookings WHERE bookingDate BETWEEN ? AND ? GROUP BY DATE(bookingDate) ORDER BY date ASC");
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $data]);
        $stmt->close();
    }

    // Revenue Report
    if ($action === 'revenue') {
        $startDate = $_GET['start'] ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $_GET['end'] ?? date('Y-m-d');

        $stmt = $conn->prepare("SELECT DATE(bookingDate) as date, SUM(fareAmount) as revenue FROM bookings WHERE bookingDate BETWEEN ? AND ? AND status = 'completed' GROUP BY DATE(bookingDate) ORDER BY date ASC");
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $data]);
        $stmt->close();
    }

    // Top Customers
    if ($action === 'topcustomers') {
        $limit = $_GET['limit'] ?? 10;
        $stmt = $conn->prepare("SELECT c.fullName, COUNT(b.bookingId) as bookingCount FROM customers c LEFT JOIN bookings b ON c.customerId = b.customerId GROUP BY c.customerId ORDER BY bookingCount DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $data]);
        $stmt->close();
    }

    // Booking Status Summary
    if ($action === 'status') {
        $stmt = $conn->prepare("SELECT status, COUNT(*) as count FROM bookings GROUP BY status");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $data]);
        $stmt->close();
    }
}

?>
