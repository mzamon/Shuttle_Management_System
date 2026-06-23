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
        $phoneNumber = $data['phoneNumber'] ?? '';
        $emailAddress = $data['emailAddress'] ?? '';
        $preferences = $data['preferences'] ?? '';

        if (empty($fullName) || empty($phoneNumber)) {
            echo json_encode(['success' => false, 'message' => 'Name and phone required']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO customers (fullName, phoneNumber, emailAddress, preferences) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullName, $phoneNumber, $emailAddress, $preferences);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'search') {
        $q = $_GET['query'] ?? '';
        $searchTerm = "%$q%";
        $stmt = $conn->prepare("SELECT customerId, fullName, phoneNumber FROM customers WHERE fullName LIKE ? OR phoneNumber LIKE ? LIMIT 8");
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $res]);
    }
}
?>