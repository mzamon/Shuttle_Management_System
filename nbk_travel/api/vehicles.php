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
        $reg = $data['registrationNumber'] ?? '';
        $make = $data['make'] ?? '';
        $model = $data['model'] ?? '';
        $capacity = (int)($data['capacity'] ?? 0);

        if (empty($reg) || empty($make) || empty($model) || $capacity <= 0) {
            echo json_encode(['success' => false, 'message' => 'Missing fields']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO vehicles (registrationNumber, make, model, capacity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $reg, $make, $model, $capacity);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error or duplicate registration']);
        }
        $stmt->close();
    } elseif ($action === 'toggle_status') {
        $vehicleId = $data['vehicleId'] ?? 0;
        $status = $data['status'] ?? 'available';

        $stmt = $conn->prepare("UPDATE vehicles SET status = ? WHERE vehicleId = ?");
        $stmt->bind_param("si", $status, $vehicleId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }
}
?>