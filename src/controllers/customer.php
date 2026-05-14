<?php
/**
 * Customer Controller
 */

declare(strict_types=1);

session_name('NBK_SHUTTLE_SESSION');
session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../models/Customer.php';

Auth::requireAuth();
Auth::checkTimeout();

header('Content-Type: application/json');

$customer = new Customer();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? 'search';
    
    if ($action === 'search') {
        $q = sanitizeString($_GET['q'] ?? '');
        if (strlen($q) < 2) {
            errorResponse('Search query too short', []);
        }
        $result = $customer->search($q);
        successResponse('Search results', $result);
    } else if ($action === 'view') {
        $customerId = intval($_GET['id'] ?? 0);
        $result = $customer->getById($customerId);
        if ($result) {
            $history = $customer->getBookingHistory($customerId);
            $result['bookingHistory'] = $history;
            successResponse('Customer retrieved', $result);
        } else {
            errorResponse('Customer not found', [], 404);
        }
    } else if ($action === 'top') {
        $limit = intval($_GET['limit'] ?? 10);
        $result = $customer->getTopCustomers($limit);
        successResponse('Top customers', $result);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? 'create';
    
    if ($action === 'create') {
        $result = $customer->create(
            sanitizeString($data['fullName']),
            sanitizePhone($data['phoneNumber']),
            sanitizeEmail($data['emailAddress'] ?? ''),
            sanitizeString($data['preferences'] ?? '')
        );
        
        if ($result['success']) {
            successResponse($result['message'], $result['data'], 201);
        } else {
            validationError($result['errors']);
        }
    } else if ($action === 'update') {
        $result = $customer->update(
            intval($data['customerId']),
            $data
        );
        
        if ($result['success']) {
            successResponse($result['message']);
        } else {
            errorResponse($result['message'], $result['errors']);
        }
    }
}

?>
