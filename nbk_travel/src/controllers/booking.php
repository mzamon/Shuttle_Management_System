<?php
/**
 * Booking Controller
 */

declare(strict_types=1);

session_name('NBK_SHUTTLE_SESSION');
session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../models/Booking.php';

Auth::requireAuth();
Auth::checkTimeout();

header('Content-Type: application/json');

$booking = new Booking();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? 'list';
    
    if ($action === 'list') {
        $page = intval($_GET['page'] ?? 1);
        $status = $_GET['status'] ?? null;
        $result = $booking->getAll($page, RECORDS_PER_PAGE, $status);
        successResponse('Bookings retrieved', $result);
    } else if ($action === 'view') {
        $bookingId = intval($_GET['id'] ?? 0);
        $result = $booking->getById($bookingId);
        if ($result) {
            successResponse('Booking retrieved', $result);
        } else {
            errorResponse('Booking not found', [], 404);
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? 'create';
    
    if ($action === 'create') {
        $result = $booking->create(
            intval($data['customerId']),
            sanitizeString($data['pickup']),
            sanitizeString($data['dropoff']),
            $data['bookingDate'],
            intval($data['passengers']),
            floatval($data['fare']),
            $data['notes'] ?? null
        );
        
        if ($result['success']) {
            successResponse($result['message'], $result['data'], 201);
        } else {
            validationError($result['errors']);
        }
    } else if ($action === 'update') {
        $result = $booking->update(
            intval($data['bookingId']),
            $data
        );
        
        if ($result['success']) {
            successResponse($result['message']);
        } else {
            errorResponse($result['message'], $result['errors']);
        }
    } else if ($action === 'cancel') {
        $result = $booking->cancel(
            intval($data['bookingId']),
            sanitizeString($data['reason'])
        );
        
        if ($result['success']) {
            successResponse($result['message']);
        } else {
            errorResponse($result['message'], $result['errors']);
        }
    } else if ($action === 'assign') {
        $result = $booking->assign(
            intval($data['bookingId']),
            intval($data['driverId']),
            intval($data['vehicleId'])
        );
        
        if ($result['success']) {
            successResponse($result['message']);
        } else {
            $code = isset($result['conflict']) && $result['conflict'] ? 409 : 400;
            errorResponse($result['message'], [], $code);
        }
    } else if ($action === 'complete') {
        $result = $booking->completeTrip(
            intval($data['bookingId']),
            intval($_SESSION['userId'])
        );
        
        if ($result['success']) {
            successResponse($result['message']);
        } else {
            errorResponse($result['message'], $result['errors']);
        }
    }
}

?>
