<?php
session_start();
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth_check.php';

if ($_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'trips') {
        $start = $_GET['start'] ?? date('Y-m-d', strtotime('-30 days'));
        $end = $_GET['end'] ?? date('Y-m-d');
        $stmt = $conn->prepare("SELECT DATE(bookingDate) as date, COUNT(*) as count FROM bookings WHERE bookingDate BETWEEN ? AND ? GROUP BY DATE(bookingDate) ORDER BY date ASC");
        $stmt->bind_param("ss", $start, $end);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $res]);
    } elseif ($action === 'revenue') {
        $start = $_GET['start'] ?? date('Y-m-d', strtotime('-30 days'));
        $end = $_GET['end'] ?? date('Y-m-d');
        $stmt = $conn->prepare("SELECT DATE(bookingDate) as date, SUM(fareAmount) as revenue FROM bookings WHERE bookingDate BETWEEN ? AND ? AND status = 'completed' GROUP BY DATE(bookingDate) ORDER BY date ASC");
        $stmt->bind_param("ss", $start, $end);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $res]);
    } elseif ($action === 'topcustomers') {
        $limit = (int)($_GET['limit'] ?? 10);
        $res = $conn->query("SELECT c.fullName, COUNT(b.bookingId) as bookingCount FROM customers c LEFT JOIN bookings b ON c.customerId = b.customerId GROUP BY c.customerId ORDER BY bookingCount DESC LIMIT $limit")->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $res]);
    } elseif ($action === 'status') {
        $res = $conn->query("SELECT status, COUNT(*) as count FROM bookings GROUP BY status")->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $res]);
    }
}
?>