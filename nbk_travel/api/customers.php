<?php
/**
 * API: Customers
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
        $phoneNumber = $data['phoneNumber'] ?? '';
        $emailAddress = $data['emailAddress'] ?? '';
        $preferences = $data['preferences'] ?? '';

        if (empty($fullName) || empty($phoneNumber)) {
            echo json_encode(['success' => false, 'message' => 'Name and phone required']);
            exit;
        }

        // Check for duplicate phone
        $check = $conn->prepare("SELECT customerId FROM customers WHERE phoneNumber = ?");
        $check->bind_param("s", $phoneNumber);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Customer with this phone already exists']);
            exit;
        }
        $check->close();

        $stmt = $conn->prepare("INSERT INTO customers (fullName, phoneNumber, emailAddress, preferences) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullName, $phoneNumber, $emailAddress, $preferences);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Customer created', 'data' => ['customerId' => $conn->insert_id]]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'search') {
        $query = $_GET['query'] ?? '';

        $query = "%$query%";
        $stmt = $conn->prepare("SELECT customerId, fullName, phoneNumber, emailAddress FROM customers WHERE fullName LIKE ? OR phoneNumber LIKE ? LIMIT 10");
        $stmt->bind_param("ss", $query, $query);
        $stmt->execute();
        $result = $stmt->get_result();

        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $customers]);
        $stmt->close();
    }

    if ($action === 'list') {
        $stmt = $conn->prepare("SELECT customerId, fullName, phoneNumber, emailAddress, preferences FROM customers ORDER BY createdAt DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $customers]);
        $stmt->close();
    }
}

?>
