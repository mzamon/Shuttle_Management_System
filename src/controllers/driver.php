<?php
/**
 * Driver Controller
 */

declare(strict_types=1);

session_name('NBK_SHUTTLE_SESSION');
session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../models/Driver.php';

Auth::requireAuth();
Auth::checkTimeout();

header('Content-Type: application/json');

$driver = new Driver();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? 'list';
    
    if ($action === 'list') {
        $result = $driver->getAll();
        successResponse('Drivers retrieved', $result);
    } else if ($action === 'available') {
        $result = $driver->getAvailable();
        successResponse('Available drivers', $result);
    } else if ($action === 'trips') {
        $driverId = intval($_GET['id'] ?? 0);
        $result = $driver->getAssignedTrips($driverId);
        successResponse('Assigned trips', $result);
    } else if ($action === 'stats') {
        $driverId = intval($_GET['id'] ?? 0);
        $startDate = $_GET['startDate'] ?? date(DATE_FORMAT, strtotime('-30 days'));
        $endDate = $_GET['endDate'] ?? getCurrentDate();
        $result = $driver->getStats($driverId, $startDate, $endDate);
        successResponse('Driver statistics', $result);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? 'updateStatus';
    
    if ($action === 'updateStatus') {
        $result = $driver->updateStatus(
            intval($data['driverId']),
            sanitizeString($data['status'])
        );
        
        if ($result['success']) {
            successResponse($result['message']);
        } else {
            errorResponse($result['message'], $result['errors']);
        }
    }
}

?>
