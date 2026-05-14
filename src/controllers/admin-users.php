<?php
/**
 * Admin Users API Controller
 * Handles user management (create, read, update, delete)
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../includes/helpers.php';

header('Content-Type: application/json');

Auth::requireAuth();

// Only admins can access this
if (!Auth::hasRole('admin')) {
    http_response_code(403);
    echo json_encode(errorResponse('Access denied', 'FORBIDDEN'));
    exit;
}

try {
    $action = isset($_GET['action']) ? $_GET['action'] : 'list';
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($action) {
        case 'list':
            // Get all users with pagination
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = RECORDS_PER_PAGE;
            $offset = ($page - 1) * $limit;
            
            $db = Database::getInstance();
            
            $stmt = $db->connect()->prepare("
                SELECT userId, username, firstName, lastName, email, phoneNumber, role, status, lastLoginAt, createdAt
                FROM users
                ORDER BY createdAt DESC
                LIMIT ? OFFSET ?
            ");
            
            $stmt->bind_param('ii', $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            
            // Get total count
            $countStmt = $db->connect()->prepare("SELECT COUNT(*) as total FROM users");
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $total = $countResult->fetch_assoc()['total'];
            
            echo json_encode(successResponse([
                'data' => $users,
                'pagination' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'pages' => ceil($total / $limit)
                ]
            ]));
            break;
            
        case 'view':
            // Get single user
            $userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if ($userId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid user ID', 'INVALID_ID'));
                break;
            }
            
            $db = Database::getInstance();
            $stmt = $db->connect()->prepare("
                SELECT userId, username, firstName, lastName, email, phoneNumber, role, status, lastLoginAt, createdAt, updatedAt
                FROM users
                WHERE userId = ?
            ");
            
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                http_response_code(404);
                echo json_encode(errorResponse('User not found', 'NOT_FOUND'));
                break;
            }
            
            $user = $result->fetch_assoc();
            echo json_encode(successResponse($user));
            break;
            
        case 'create':
            // Create new user
            if ($method !== 'POST') {
                http_response_code(405);
                echo json_encode(errorResponse('Method not allowed', 'METHOD_NOT_ALLOWED'));
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validation
            $errors = [];
            if (empty($data['firstName'])) $errors[] = 'First name is required';
            if (empty($data['lastName'])) $errors[] = 'Last name is required';
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
            if (empty($data['role'])) $errors[] = 'Role is required';
            
            if (!empty($errors)) {
                http_response_code(400);
                echo json_encode(validationError('Validation failed', $errors));
                break;
            }
            
            $db = Database::getInstance();
            
            // Generate username from first and last name
            $username = strtolower($data['firstName'] . '.' . $data['lastName']);
            
            // Check if username exists
            $checkStmt = $db->connect()->prepare("SELECT userId FROM users WHERE username = ?");
            $checkStmt->bind_param('s', $username);
            $checkStmt->execute();
            
            if ($checkStmt->get_result()->num_rows > 0) {
                http_response_code(409);
                echo json_encode(errorResponse('Username already exists', 'DUPLICATE_USER'));
                break;
            }
            
            // Generate temporary password
            $tempPassword = generateToken(12);
            $passwordHash = hashPassword($tempPassword);
            
            // Insert user
            $stmt = $db->connect()->prepare("
                INSERT INTO users (username, passwordHash, firstName, lastName, email, phoneNumber, role, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'ACTIVE')
            ");
            
            $phone = isset($data['phoneNumber']) ? $data['phoneNumber'] : '';
            $stmt->bind_param('sssssss', 
                $username,
                $passwordHash,
                $data['firstName'],
                $data['lastName'],
                $data['email'],
                $phone,
                $data['role']
            );
            
            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(errorResponse('Failed to create user', 'INSERT_ERROR'));
                logDatabaseError($stmt->error);
                break;
            }
            
            logMessage('New user created: ' . $username . ' with role: ' . $data['role']);
            
            echo json_encode(successResponse([
                'userId' => $stmt->insert_id,
                'username' => $username,
                'tempPassword' => $tempPassword
            ], 'User created successfully'));
            break;
            
        case 'update':
            // Update user
            if ($method !== 'POST') {
                http_response_code(405);
                echo json_encode(errorResponse('Method not allowed', 'METHOD_NOT_ALLOWED'));
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            $userId = isset($data['userId']) ? (int)$data['userId'] : 0;
            
            if ($userId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid user ID', 'INVALID_ID'));
                break;
            }
            
            $db = Database::getInstance();
            
            $updates = [];
            $params = [];
            $paramTypes = '';
            
            if (isset($data['firstName'])) {
                $updates[] = 'firstName = ?';
                $params[] = $data['firstName'];
                $paramTypes .= 's';
            }
            
            if (isset($data['lastName'])) {
                $updates[] = 'lastName = ?';
                $params[] = $data['lastName'];
                $paramTypes .= 's';
            }
            
            if (isset($data['email'])) {
                $updates[] = 'email = ?';
                $params[] = $data['email'];
                $paramTypes .= 's';
            }
            
            if (isset($data['phoneNumber'])) {
                $updates[] = 'phoneNumber = ?';
                $params[] = $data['phoneNumber'];
                $paramTypes .= 's';
            }
            
            if (isset($data['status'])) {
                $updates[] = 'status = ?';
                $params[] = $data['status'];
                $paramTypes .= 's';
            }
            
            if (isset($data['role'])) {
                $updates[] = 'role = ?';
                $params[] = $data['role'];
                $paramTypes .= 's';
            }
            
            if (empty($updates)) {
                http_response_code(400);
                echo json_encode(errorResponse('No fields to update', 'NO_UPDATES'));
                break;
            }
            
            $params[] = $userId;
            $paramTypes .= 'i';
            
            $updateStr = implode(', ', $updates);
            $stmt = $db->connect()->prepare("
                UPDATE users SET $updateStr WHERE userId = ?
            ");
            
            $stmt->bind_param($paramTypes, ...$params);
            
            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(errorResponse('Failed to update user', 'UPDATE_ERROR'));
                logDatabaseError($stmt->error);
                break;
            }
            
            logMessage('User updated: ID ' . $userId);
            
            echo json_encode(successResponse([], 'User updated successfully'));
            break;
            
        case 'delete':
            // Delete user
            if ($method !== 'POST') {
                http_response_code(405);
                echo json_encode(errorResponse('Method not allowed', 'METHOD_NOT_ALLOWED'));
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            $userId = isset($data['userId']) ? (int)$data['userId'] : 0;
            
            if ($userId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid user ID', 'INVALID_ID'));
                break;
            }
            
            // Prevent deletion of own account
            $currentUser = Auth::getCurrentUser();
            if ($currentUser['userId'] === $userId) {
                http_response_code(400);
                echo json_encode(errorResponse('Cannot delete your own account', 'CANNOT_DELETE_SELF'));
                break;
            }
            
            $db = Database::getInstance();
            $stmt = $db->connect()->prepare("DELETE FROM users WHERE userId = ?");
            
            $stmt->bind_param('i', $userId);
            
            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(errorResponse('Failed to delete user', 'DELETE_ERROR'));
                logDatabaseError($stmt->error);
                break;
            }
            
            logMessage('User deleted: ID ' . $userId);
            
            echo json_encode(successResponse([], 'User deleted successfully'));
            break;
            
        case 'reset-password':
            // Reset user password
            if ($method !== 'POST') {
                http_response_code(405);
                echo json_encode(errorResponse('Method not allowed', 'METHOD_NOT_ALLOWED'));
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            $userId = isset($data['userId']) ? (int)$data['userId'] : 0;
            
            if ($userId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid user ID', 'INVALID_ID'));
                break;
            }
            
            $tempPassword = generateToken(12);
            $passwordHash = hashPassword($tempPassword);
            
            $db = Database::getInstance();
            $stmt = $db->connect()->prepare("
                UPDATE users SET passwordHash = ? WHERE userId = ?
            ");
            
            $stmt->bind_param('si', $passwordHash, $userId);
            
            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(errorResponse('Failed to reset password', 'UPDATE_ERROR'));
                logDatabaseError($stmt->error);
                break;
            }
            
            logMessage('Password reset for user ID: ' . $userId);
            
            echo json_encode(successResponse([
                'tempPassword' => $tempPassword
            ], 'Password reset successfully'));
            break;
            
        default:
            http_response_code(400);
            echo json_encode(errorResponse('Invalid action', 'INVALID_ACTION'));
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(errorResponse($e->getMessage(), 'SERVER_ERROR'));
    logMessage('Admin users controller error: ' . $e->getMessage());
}
?>
