<?php
/**
 * Vehicle Management API Controller
 * Handles vehicle CRUD operations and fleet management
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../includes/helpers.php';

header('Content-Type: application/json');

Auth::requireAuth();

// Only admins can modify vehicles
if (!Auth::hasRole('admin') && $_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(403);
    echo json_encode(errorResponse('Access denied', 'FORBIDDEN'));
    exit;
}

try {
    $action = isset($_GET['action']) ? $_GET['action'] : 'list';
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($action) {
        case 'list':
            // Get all vehicles with pagination
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $status = isset($_GET['status']) ? $_GET['status'] : '';
            $limit = RECORDS_PER_PAGE;
            $offset = ($page - 1) * $limit;
            
            $db = Database::getInstance();
            
            $query = "SELECT * FROM vehicles WHERE 1=1";
            $params = [];
            $paramTypes = '';
            
            if ($status) {
                $query .= " AND status = ?";
                $params[] = $status;
                $paramTypes .= 's';
            }
            
            $query .= " ORDER BY createdAt DESC LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            $paramTypes .= 'ii';
            
            $stmt = $db->connect()->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($paramTypes, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            
            $vehicles = [];
            while ($row = $result->fetch_assoc()) {
                $vehicles[] = $row;
            }
            
            // Get total count
            $countQuery = "SELECT COUNT(*) as total FROM vehicles WHERE 1=1";
            if ($status) $countQuery .= " AND status = ?";
            
            $countStmt = $db->connect()->prepare($countQuery);
            if ($status) {
                $countStmt->bind_param('s', $status);
            }
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $total = $countResult->fetch_assoc()['total'];
            
            echo json_encode(successResponse([
                'data' => $vehicles,
                'pagination' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'pages' => ceil($total / $limit)
                ]
            ]));
            break;
            
        case 'available':
            // Get available vehicles
            $db = Database::getInstance();
            $stmt = $db->connect()->prepare("
                SELECT vehicleId, registrationNumber, make, model, capacity
                FROM vehicles
                WHERE status = 'ACTIVE'
                AND vehicleId NOT IN (
                    SELECT vehicleId FROM schedules 
                    WHERE scheduledEnd > NOW() AND conflictFlag = FALSE
                )
            ");
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            $vehicles = [];
            while ($row = $result->fetch_assoc()) {
                $vehicles[] = $row;
            }
            
            echo json_encode(successResponse($vehicles));
            break;
            
        case 'view':
            // Get single vehicle
            $vehicleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if ($vehicleId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid vehicle ID', 'INVALID_ID'));
                break;
            }
            
            $db = Database::getInstance();
            $stmt = $db->connect()->prepare("SELECT * FROM vehicles WHERE vehicleId = ?");
            
            $stmt->bind_param('i', $vehicleId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                http_response_code(404);
                echo json_encode(errorResponse('Vehicle not found', 'NOT_FOUND'));
                break;
            }
            
            $vehicle = $result->fetch_assoc();
            echo json_encode(successResponse($vehicle));
            break;
            
        case 'create':
            // Create new vehicle
            if ($method !== 'POST') {
                http_response_code(405);
                echo json_encode(errorResponse('Method not allowed', 'METHOD_NOT_ALLOWED'));
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validation
            $errors = [];
            if (empty($data['registrationNumber'])) $errors[] = 'Registration number is required';
            if (empty($data['make'])) $errors[] = 'Make is required';
            if (empty($data['model'])) $errors[] = 'Model is required';
            if (empty($data['capacity']) || !is_numeric($data['capacity'])) $errors[] = 'Valid capacity is required';
            if (empty($data['status'])) $errors[] = 'Status is required';
            
            if (!empty($errors)) {
                http_response_code(400);
                echo json_encode(validationError('Validation failed', $errors));
                break;
            }
            
            $db = Database::getInstance();
            
            // Check if registration already exists
            $checkStmt = $db->connect()->prepare("SELECT vehicleId FROM vehicles WHERE registrationNumber = ?");
            $checkStmt->bind_param('s', $data['registrationNumber']);
            $checkStmt->execute();
            
            if ($checkStmt->get_result()->num_rows > 0) {
                http_response_code(409);
                echo json_encode(errorResponse('Vehicle registration already exists', 'DUPLICATE_VEHICLE'));
                break;
            }
            
            $stmt = $db->connect()->prepare("
                INSERT INTO vehicles (registrationNumber, make, model, capacity, status, lastServiceDate, maintenanceNotes)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            $capacity = (int)$data['capacity'];
            $lastService = isset($data['lastServiceDate']) ? $data['lastServiceDate'] : date('Y-m-d');
            $notes = isset($data['maintenanceNotes']) ? $data['maintenanceNotes'] : '';
            
            $stmt->bind_param('sssisis', 
                $data['registrationNumber'],
                $data['make'],
                $data['model'],
                $capacity,
                $data['status'],
                $lastService,
                $notes
            );
            
            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(errorResponse('Failed to create vehicle', 'INSERT_ERROR'));
                logDatabaseError($stmt->error);
                break;
            }
            
            logMessage('New vehicle added: ' . $data['registrationNumber']);
            
            echo json_encode(successResponse([
                'vehicleId' => $stmt->insert_id
            ], 'Vehicle created successfully'));
            break;
            
        case 'update':
            // Update vehicle
            if ($method !== 'POST') {
                http_response_code(405);
                echo json_encode(errorResponse('Method not allowed', 'METHOD_NOT_ALLOWED'));
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            $vehicleId = isset($data['vehicleId']) ? (int)$data['vehicleId'] : 0;
            
            if ($vehicleId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid vehicle ID', 'INVALID_ID'));
                break;
            }
            
            $db = Database::getInstance();
            
            $updates = [];
            $params = [];
            $paramTypes = '';
            
            if (isset($data['make'])) {
                $updates[] = 'make = ?';
                $params[] = $data['make'];
                $paramTypes .= 's';
            }
            
            if (isset($data['model'])) {
                $updates[] = 'model = ?';
                $params[] = $data['model'];
                $paramTypes .= 's';
            }
            
            if (isset($data['capacity'])) {
                $updates[] = 'capacity = ?';
                $params[] = (int)$data['capacity'];
                $paramTypes .= 'i';
            }
            
            if (isset($data['status'])) {
                $updates[] = 'status = ?';
                $params[] = $data['status'];
                $paramTypes .= 's';
            }
            
            if (isset($data['lastServiceDate'])) {
                $updates[] = 'lastServiceDate = ?';
                $params[] = $data['lastServiceDate'];
                $paramTypes .= 's';
            }
            
            if (isset($data['maintenanceNotes'])) {
                $updates[] = 'maintenanceNotes = ?';
                $params[] = $data['maintenanceNotes'];
                $paramTypes .= 's';
            }
            
            if (empty($updates)) {
                http_response_code(400);
                echo json_encode(errorResponse('No fields to update', 'NO_UPDATES'));
                break;
            }
            
            $params[] = $vehicleId;
            $paramTypes .= 'i';
            
            $updateStr = implode(', ', $updates);
            $stmt = $db->connect()->prepare("
                UPDATE vehicles SET $updateStr WHERE vehicleId = ?
            ");
            
            $stmt->bind_param($paramTypes, ...$params);
            
            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(errorResponse('Failed to update vehicle', 'UPDATE_ERROR'));
                logDatabaseError($stmt->error);
                break;
            }
            
            logMessage('Vehicle updated: ID ' . $vehicleId);
            
            echo json_encode(successResponse([], 'Vehicle updated successfully'));
            break;
            
        case 'delete':
            // Delete vehicle
            if ($method !== 'POST') {
                http_response_code(405);
                echo json_encode(errorResponse('Method not allowed', 'METHOD_NOT_ALLOWED'));
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            $vehicleId = isset($data['vehicleId']) ? (int)$data['vehicleId'] : 0;
            
            if ($vehicleId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid vehicle ID', 'INVALID_ID'));
                break;
            }
            
            $db = Database::getInstance();
            
            // Check if vehicle has active schedules
            $checkStmt = $db->connect()->prepare("
                SELECT COUNT(*) as count FROM schedules 
                WHERE vehicleId = ? AND scheduledEnd > NOW()
            ");
            $checkStmt->bind_param('i', $vehicleId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            $hasSchedules = $checkResult->fetch_assoc()['count'];
            
            if ($hasSchedules > 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Cannot delete vehicle with active schedules', 'ACTIVE_SCHEDULES'));
                break;
            }
            
            $stmt = $db->connect()->prepare("DELETE FROM vehicles WHERE vehicleId = ?");
            
            $stmt->bind_param('i', $vehicleId);
            
            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(errorResponse('Failed to delete vehicle', 'DELETE_ERROR'));
                logDatabaseError($stmt->error);
                break;
            }
            
            logMessage('Vehicle deleted: ID ' . $vehicleId);
            
            echo json_encode(successResponse([], 'Vehicle deleted successfully'));
            break;
            
        default:
            http_response_code(400);
            echo json_encode(errorResponse('Invalid action', 'INVALID_ACTION'));
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(errorResponse($e->getMessage(), 'SERVER_ERROR'));
    logMessage('Vehicle controller error: ' . $e->getMessage());
}
?>
