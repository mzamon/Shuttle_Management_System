<?php
/**
 * API: Vehicles Management
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
        $registrationNumber = $data['registrationNumber'] ?? '';
        $make = $data['make'] ?? '';
        $model = $data['model'] ?? '';
        $capacity = $data['capacity'] ?? 5;

        if (empty($registrationNumber) || empty($make) || empty($model)) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO vehicles (registrationNumber, make, model, capacity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $registrationNumber, $make, $model, $capacity);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Vehicle created', 'data' => ['vehicleId' => $conn->insert_id]]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }

    if ($action === 'toggle_status') {
        $data = json_decode(file_get_contents('php://input'), true);
        $vehicleId = $data['vehicleId'] ?? null;
        $status = $data['status'] ?? '';

        if (!$vehicleId || empty($status)) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE vehicles SET status = ? WHERE vehicleId = ?");
        $stmt->bind_param("si", $status, $vehicleId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Vehicle status updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'list') {
        $stmt = $conn->prepare("SELECT vehicleId, registrationNumber, make, model, capacity, status FROM vehicles ORDER BY registrationNumber ASC");
        $stmt->execute();
        $result = $stmt->get_result();

        $vehicles = [];
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $vehicles]);
        $stmt->close();
    }

    if ($action === 'available') {
        $stmt = $conn->prepare("SELECT vehicleId, registrationNumber, make, model, capacity FROM vehicles WHERE status = 'available' ORDER BY registrationNumber ASC");
        $stmt->execute();
        $result = $stmt->get_result();

        $vehicles = [];
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $vehicles]);
        $stmt->close();
    }
}

?>
