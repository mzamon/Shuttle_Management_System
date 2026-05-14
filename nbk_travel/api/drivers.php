<?php
/**
 * API: Drivers Management
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
    if ($action === 'create') {
        $data = json_decode(file_get_contents('php://input'), true);
        $fullName = $data['fullName'] ?? '';
        $licenceNumber = $data['licenceNumber'] ?? '';
        $phoneNumber = $data['phoneNumber'] ?? '';

        if (empty($fullName) || empty($licenceNumber) || empty($phoneNumber)) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        // Create driver
        $stmt = $conn->prepare("INSERT INTO drivers (fullName, licenceNumber, phoneNumber) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullName, $licenceNumber, $phoneNumber);

        if ($stmt->execute()) {
            $driverId = $conn->insert_id;

            // Create user account for driver
            $username = strtolower(explode(' ', $fullName)[0] . '.' . explode(' ', $fullName)[1] ?? '');
            $password = password_hash('password', PASSWORD_BCRYPT);
            $role = 'driver';

            $userStmt = $conn->prepare("INSERT INTO users (username, passwordHash, role, driverId) VALUES (?, ?, ?, ?)");
            $userStmt->bind_param("sssi", $username, $password, $role, $driverId);
            $userStmt->execute();
            $userStmt->close();

            echo json_encode(['success' => true, 'message' => 'Driver created', 'data' => ['driverId' => $driverId]]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }

    if ($action === 'toggle_status') {
        $data = json_decode(file_get_contents('php://input'), true);
        $driverId = $data['driverId'] ?? null;
        $status = $data['status'] ?? '';

        if (!$driverId || empty($status)) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE drivers SET status = ? WHERE driverId = ?");
        $stmt->bind_param("si", $status, $driverId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Driver status updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'list') {
        $stmt = $conn->prepare("SELECT driverId, fullName, licenceNumber, phoneNumber, status FROM drivers ORDER BY fullName ASC");
        $stmt->execute();
        $result = $stmt->get_result();

        $drivers = [];
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $drivers]);
        $stmt->close();
    }

    if ($action === 'available') {
        $stmt = $conn->prepare("SELECT driverId, fullName FROM drivers WHERE status = 'available' ORDER BY fullName ASC");
        $stmt->execute();
        $result = $stmt->get_result();

        $drivers = [];
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $drivers]);
        $stmt->close();
    }
}

?>
