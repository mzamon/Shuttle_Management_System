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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($action === 'generate') {
        $bookingId = $data['bookingId'] ?? 0;

        // Get booking and customer details
        $stmt = $conn->prepare("SELECT b.fareAmount, b.customerId FROM bookings b WHERE b.bookingId = ?");
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if ($res) {
            $fare = $res['fareAmount'];
            $customerId = $res['customerId'];
            $tax = $fare * 0.15; // 15% VAT
            $total = $fare + $tax;

            // Insert into invoices
            $stmt = $conn->prepare("INSERT INTO invoices (bookingId, customerId, subtotal, taxAmount, totalAmount) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiddd", $bookingId, $customerId, $fare, $tax, $total);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invoice already exists or DB error']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Booking not found']);
        }
    }
}
?>