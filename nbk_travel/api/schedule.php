<?php
/**
 * API: Schedule Assignment & Conflict Detection
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

// Conflict Detection Function
function detectConflict($driverId, $vehicleId, $start, $end, $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) as conflicts FROM schedules WHERE ((driverId = ? OR vehicleId = ?) AND scheduledStart < ? AND scheduledEnd > ?)");
    $stmt->bind_param("iiss", $driverId, $vehicleId, $end, $start);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['conflicts'] > 0;
}

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'assign') {
        $data = json_decode(file_get_contents('php://input'), true);
        $bookingId = $data['bookingId'] ?? null;
        $driverId = $data['driverId'] ?? null;
        $vehicleId = $data['vehicleId'] ?? null;
        $startTime = $data['startTime'] ?? '';
        $endTime = $data['endTime'] ?? '';

        if (!$bookingId || !$driverId || !$vehicleId || !$startTime || !$endTime) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        // Check for conflicts
        if (detectConflict($driverId, $vehicleId, $startTime, $endTime, $conn)) {
            echo json_encode(['success' => false, 'message' => 'CONFLICT_DETECTED', 'data' => ['conflict' => true]]);
            exit;
        }

        // Create schedule entry
        $stmt = $conn->prepare("INSERT INTO schedules (bookingId, driverId, vehicleId, scheduledStart, scheduledEnd, conflictFlag) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("iiiss", $bookingId, $driverId, $vehicleId, $startTime, $endTime);

        if ($stmt->execute()) {
            // Update booking status and assignment
            $updateBooking = $conn->prepare("UPDATE bookings SET driverId = ?, vehicleId = ?, status = 'confirmed' WHERE bookingId = ?");
            $updateBooking->bind_param("iii", $driverId, $vehicleId, $bookingId);
            $updateBooking->execute();
            $updateBooking->close();

            // Update driver status
            $updateDriver = $conn->prepare("UPDATE drivers SET status = 'on-trip' WHERE driverId = ?");
            $updateDriver->bind_param("i", $driverId);
            $updateDriver->execute();
            $updateDriver->close();

            // Update vehicle status
            $updateVehicle = $conn->prepare("UPDATE vehicles SET status = 'in-use' WHERE vehicleId = ?");
            $updateVehicle->bind_param("i", $vehicleId);
            $updateVehicle->execute();
            $updateVehicle->close();

            echo json_encode(['success' => true, 'message' => 'Schedule assigned successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    }

    if ($action === 'complete') {
        $data = json_decode(file_get_contents('php://input'), true);
        $bookingId = $data['bookingId'] ?? null;

        if (!$bookingId) {
            echo json_encode(['success' => false, 'message' => 'Booking ID required']);
            exit;
        }

        // Get booking details
        $getBooking = $conn->prepare("SELECT driverId, vehicleId FROM bookings WHERE bookingId = ?");
        $getBooking->bind_param("i", $bookingId);
        $getBooking->execute();
        $result = $getBooking->get_result();
        $booking = $result->fetch_assoc();
        $getBooking->close();

        // Update booking status
        $updateBooking = $conn->prepare("UPDATE bookings SET status = 'completed' WHERE bookingId = ?");
        $updateBooking->bind_param("i", $bookingId);
        $updateBooking->execute();
        $updateBooking->close();

        // Set driver to available
        $updateDriver = $conn->prepare("UPDATE drivers SET status = 'available' WHERE driverId = ?");
        $updateDriver->bind_param("i", $booking['driverId']);
        $updateDriver->execute();
        $updateDriver->close();

        // Set vehicle to available
        $updateVehicle = $conn->prepare("UPDATE vehicles SET status = 'available' WHERE vehicleId = ?");
        $updateVehicle->bind_param("i", $booking['vehicleId']);
        $updateVehicle->execute();
        $updateVehicle->close();

        echo json_encode(['success' => true, 'message' => 'Trip marked as completed']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'list') {
        $startDate = $_GET['start'] ?? date('Y-m-d');
        $endDate = $_GET['end'] ?? date('Y-m-d', strtotime('+7 days'));

        $stmt = $conn->prepare("SELECT s.*, b.bookingId, b.pickupLocation, b.dropoffLocation, d.fullName as driverName, v.registrationNumber FROM schedules s JOIN bookings b ON s.bookingId = b.bookingId JOIN drivers d ON s.driverId = d.driverId JOIN vehicles v ON s.vehicleId = v.vehicleId WHERE s.scheduledStart BETWEEN ? AND ? ORDER BY s.scheduledStart ASC");
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $schedules = [];
        while ($row = $result->fetch_assoc()) {
            $schedules[] = $row;
        }

        echo json_encode(['success' => true, 'data' => $schedules]);
        $stmt->close();
    }
}

?>
