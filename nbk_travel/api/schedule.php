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

function detectConflict($driverId, $vehicleId, $start, $end, $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) as conflicts FROM schedules WHERE ((driverId = ? OR vehicleId = ?) AND scheduledStart < ? AND scheduledEnd > ?)");
    $stmt->bind_param("iiss", $driverId, $vehicleId, $end, $start);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $res['conflicts'] > 0;
}

$action = $_GET['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($action === 'assign') {
        $bookingId = $data['bookingId'] ?? 0;
        $driverId = $data['driverId'] ?? 0;
        $vehicleId = $data['vehicleId'] ?? 0;
        $start = $data['startTime'] ?? '';
        $end = $data['endTime'] ?? '';

        if (!$bookingId || !$driverId || !$vehicleId || !$start || !$end) {
            echo json_encode(['success' => false, 'message' => 'Missing fields']);
            exit;
        }

        if (detectConflict($driverId, $vehicleId, $start, $end, $conn)) {
            echo json_encode(['success' => false, 'message' => 'Conflict detected', 'data' => ['conflict' => true]]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO schedules (bookingId, driverId, vehicleId, scheduledStart, scheduledEnd) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $bookingId, $driverId, $vehicleId, $start, $end);
        if ($stmt->execute()) {
            $conn->query("UPDATE bookings SET driverId = $driverId, vehicleId = $vehicleId, status = 'confirmed' WHERE bookingId = $bookingId");
            $conn->query("UPDATE drivers SET status = 'on-trip' WHERE driverId = $driverId");
            $conn->query("UPDATE vehicles SET status = 'in-use' WHERE vehicleId = $vehicleId");
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'DB error']);
        }
    } elseif ($action === 'complete') {
        $bookingId = $data['bookingId'] ?? 0;
        $b = $conn->query("SELECT driverId, vehicleId FROM bookings WHERE bookingId = $bookingId")->fetch_assoc();
        if ($b) {
            $conn->query("UPDATE bookings SET status = 'completed' WHERE bookingId = $bookingId");
            $conn->query("UPDATE drivers SET status = 'available' WHERE driverId = " . $b['driverId']);
            $conn->query("UPDATE vehicles SET status = 'available' WHERE vehicleId = " . $b['vehicleId']);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Booking not found']);
        }
    }
}
?>