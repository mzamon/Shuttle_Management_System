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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'list') {
        $res = $conn->query("SELECT * FROM notifications ORDER BY sentAt DESC LIMIT 100")->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $res]);
    }
}
?>