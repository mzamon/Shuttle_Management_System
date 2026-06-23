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

    if ($action === 'create') {
        $fullName = $data['fullName'] ?? '';
        $licence = $data['licenceNumber'] ?? '';
        $phone = $data['phoneNumber'] ?? '';

        if (empty($fullName) || empty($licence) || empty($phone)) {
            echo json_encode(['success' => false, 'message' => 'Missing fields']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO drivers (fullName, licenceNumber, phoneNumber) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullName, $licence, $phone);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    } elseif ($action === 'toggle_status') {
        $driverId = $data['driverId'] ?? 0;
        $status = $data['status'] ?? 'available';

        $stmt = $conn->prepare("UPDATE drivers SET status = ? WHERE driverId = ?");
        $stmt->bind_param("si", $status, $driverId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }
}
?>