<?php
session_start();
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth_check.php';

// In Full Access Override, we still check role for data protection
if ($_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($action === 'create') {
        $customerId = $data['customerId'] ?? 0;
        $pickup = $data['pickupLocation'] ?? '';
        $dropoff = $data['dropoffLocation'] ?? '';
        $date = $data['bookingDate'] ?? '';
        $passengers = $data['passengers'] ?? 1;
        $fare = $data['fareAmount'] ?? 0;

        if (!$customerId || empty($pickup) || empty($dropoff) || empty($date)) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO bookings (customerId, pickupLocation, dropoffLocation, bookingDate, passengers, fareAmount, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("isssid", $customerId, $pickup, $dropoff, $date, $passengers, $fare);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Booking created']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    } elseif ($action === 'cancel') {
        $bookingId = $data['bookingId'] ?? 0;
        $reason = $data['reason'] ?? '';

        if (!$bookingId) {
            echo json_encode(['success' => false, 'message' => 'Booking ID required']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE bookings SET status = 'cancelled', cancellationReason = ? WHERE bookingId = ?");
        $stmt->bind_param("si", $reason, $bookingId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Booking cancelled']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }
}
?>