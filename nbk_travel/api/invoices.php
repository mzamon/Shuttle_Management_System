<?php
/**
 * API: Invoices Generator
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'generate') {
        $data = json_decode(file_get_contents('php://input'), true);
        $bookingId = $data['bookingId'] ?? null;

        if (!$bookingId) {
            echo json_encode(['success' => false, 'message' => 'Booking ID required']);
            exit;
        }

        // Get booking and customer details
        $stmt = $conn->prepare("SELECT b.bookingId, b.customerId, b.fareAmount, c.fullName, c.phoneNumber, c.emailAddress FROM bookings b JOIN customers c ON b.customerId = c.customerId WHERE b.bookingId = ?");
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();
        $stmt->close();

        if (!$booking) {
            echo json_encode(['success' => false, 'message' => 'Booking not found']);
            exit;
        }

        $subtotal = $booking['fareAmount'];
        $taxAmount = $subtotal * 0.15; // 15% tax
        $totalAmount = $subtotal + $taxAmount;

        // Insert invoice
        $invoiceStmt = $conn->prepare("INSERT INTO invoices (bookingId, customerId, invoiceDate, subtotal, taxAmount, totalAmount) VALUES (?, ?, NOW(), ?, ?, ?)");
        $invoiceStmt->bind_param("iiddd", $bookingId, $booking['customerId'], $subtotal, $taxAmount, $totalAmount);

        if ($invoiceStmt->execute()) {
            // Log notification
            $notifyStmt = $conn->prepare("INSERT INTO notifications (recipientType, recipientId, bookingId, channel, messageBody) VALUES (?, ?, ?, ?, ?)");
            $recipientType = 'customer';
            $message = "Invoice generated for booking #$bookingId. Amount: $totalAmount";
            $channel = 'email';
            $notifyStmt->bind_param("siiss", $recipientType, $booking['customerId'], $bookingId, $channel, $message);
            $notifyStmt->execute();
            $notifyStmt->close();

            echo json_encode([
                'success' => true,
                'message' => 'Invoice generated',
                'data' => [
                    'invoiceId' => $conn->insert_id,
                    'subtotal' => $subtotal,
                    'tax' => $taxAmount,
                    'total' => $totalAmount
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $invoiceStmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'pending') {
        // Get completed bookings without invoices
        $stmt = $conn->prepare("SELECT b.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation, b.bookingDate, b.fareAmount FROM bookings b JOIN customers c ON b.customerId = c.customerId WHERE b.status = 'completed' AND b.bookingId NOT IN (SELECT DISTINCT bookingId FROM invoices) ORDER BY b.bookingDate DESC");
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
