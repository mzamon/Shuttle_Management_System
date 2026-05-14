<?php
/**
 * API: Bookings
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

// Helper: Log Notification
function logNotification($recipientType, $recipientId, $bookingId, $channel, $message, $conn) {
    $stmt = $conn->prepare("INSERT INTO notifications (recipientType, recipientId, bookingId, channel, messageBody) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siiss", $recipientType, $recipientId, $bookingId, $channel, $message);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        $data = json_decode(file_get_contents('php://input'), true);
        $customerId = $data['customerId'] ?? null;
        $pickupLocation = $data['pickupLocation'] ?? '';
        $dropoffLocation = $data['dropoffLocation'] ?? '';
        $bookingDate = $data['bookingDate'] ?? '';
        $passengers = $data['passengers'] ?? 1;
        $fareAmount = $data['fareAmount'] ?? 0;

        if (!$customerId || empty($pickupLocation) || empty($dropoffLocation) || empty($bookingDate)) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO bookings (customerId, pickupLocation, dropoffLocation, bookingDate, passengers, fareAmount, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("issidi", $customerId, $pickupLocation, $dropoffLocation, $bookingDate, $passengers, $fareAmount);

        if ($stmt->execute()) {
            $bookingId = $conn->insert_id;
            
            // Log notification
            $message = "Booking confirmed for $pickupLocation to $dropoffLocation";
            logNotification('customer', $customerId, $bookingId, 'email', $message, $conn);

            echo json_encode(['success' => true, 'message' => 'Booking created', 'data' => ['bookingId' => $bookingId]]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }

    if ($action === 'cancel') {
        $data = json_decode(file_get_contents('php://input'), true);
        $bookingId = $data['bookingId'] ?? null;
        $reason = $data['reason'] ?? '';

        if (!$bookingId) {
            echo json_encode(['success' => false, 'message' => 'Booking ID required']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE bookings SET status = 'cancelled', cancellationReason = ? WHERE bookingId = ?");
        $stmt->bind_param("si", $reason, $bookingId);

        if ($stmt->execute()) {
            // Get customer ID for notification
            $getCustomer = $conn->prepare("SELECT customerId FROM bookings WHERE bookingId = ?");
            $getCustomer->bind_param("i", $bookingId);
            $getCustomer->execute();
            $result = $getCustomer->get_result();
            $row = $result->fetch_assoc();
            
            logNotification('customer', $row['customerId'], $bookingId, 'sms', "Booking cancelled. Reason: $reason", $conn);
            
            echo json_encode(['success' => true, 'message' => 'Booking cancelled']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'list') {
        $stmt = $conn->prepare("SELECT b.*, c.fullName, d.fullName as driverName, v.registrationNumber FROM bookings b LEFT JOIN customers c ON b.customerId = c.customerId LEFT JOIN drivers d ON b.driverId = d.driverId LEFT JOIN vehicles v ON b.vehicleId = v.vehicleId ORDER BY b.bookingDate DESC LIMIT 100");
        $stmt->execute();
        $result = $stmt->get_result();

        $bookings = [];
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $bookings]);
        $stmt->close();
    }
}

?>
