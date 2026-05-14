<?php
/**
 * API: Notifications Log
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
    if ($action === 'list') {
        $stmt = $conn->prepare("SELECT notificationId, recipientType, recipientId, channel, messageBody, sentAt, status FROM notifications ORDER BY sentAt DESC LIMIT 100");
        $stmt->execute();
        $result = $stmt->get_result();

        $notifications = [];
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $notifications]);
        $stmt->close();
    }
}

?>
