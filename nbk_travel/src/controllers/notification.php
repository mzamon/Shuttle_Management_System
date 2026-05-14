<?php
/**
 * Notifications API Controller
 * Handles notification retrieval, filtering, and marking as read
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../includes/helpers.php';

header('Content-Type: application/json');

Auth::requireAuth();

try {
    $action = isset($_GET['action']) ? $_GET['action'] : 'list';
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($action) {
        case 'list':
            // Get all notifications with filtering
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $channel = isset($_GET['channel']) ? $_GET['channel'] : '';
            $status = isset($_GET['status']) ? $_GET['status'] : '';
            $limit = RECORDS_PER_PAGE;
            $offset = ($page - 1) * $limit;
            
            $db = Database::getInstance();
            
            $query = "
                SELECT n.*, b.bookingReference
                FROM notifications n
                LEFT JOIN bookings b ON n.bookingReference = b.bookingReference
                WHERE 1=1
            ";
            
            $params = [];
            $paramTypes = '';
            
            if ($channel) {
                $query .= " AND n.channel = ?";
                $params[] = $channel;
                $paramTypes .= 's';
            }
            
            if ($status) {
                $query .= " AND n.status = ?";
                $params[] = $status;
                $paramTypes .= 's';
            }
            
            $query .= " ORDER BY n.sentAt DESC LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            $paramTypes .= 'ii';
            
            $stmt = $db->connect()->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($paramTypes, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            
            $notifications = [];
            while ($row = $result->fetch_assoc()) {
                $notifications[] = $row;
            }
            
            // Get total count
            $countQuery = "SELECT COUNT(*) as total FROM notifications WHERE 1=1";
            if ($channel) $countQuery .= " AND channel = ?";
            if ($status) $countQuery .= " AND status = ?";
            
            $countStmt = $db->connect()->prepare($countQuery);
            if ($channel || $status) {
                $countParams = [];
                if ($channel) $countParams[] = $channel;
                if ($status) $countParams[] = $status;
                $countType = '';
                if ($channel) $countType .= 's';
                if ($status) $countType .= 's';
                $countStmt->bind_param($countType, ...$countParams);
            }
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $total = $countResult->fetch_assoc()['total'];
            
            echo json_encode(successResponse([
                'data' => $notifications,
                'pagination' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'pages' => ceil($total / $limit)
                ]
            ]));
            break;
            
        case 'view':
            // Get single notification
            $notificationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if ($notificationId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid notification ID', 'INVALID_ID'));
                break;
            }
            
            $db = Database::getInstance();
            $stmt = $db->connect()->prepare("
                SELECT n.*, b.bookingReference
                FROM notifications n
                LEFT JOIN bookings b ON n.bookingReference = b.bookingReference
                WHERE n.notificationId = ?
            ");
            
            $stmt->bind_param('i', $notificationId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                http_response_code(404);
                echo json_encode(errorResponse('Notification not found', 'NOT_FOUND'));
                break;
            }
            
            $notification = $result->fetch_assoc();
            echo json_encode(successResponse($notification));
            break;
            
        case 'mark-read':
            // Mark notification as read
            if ($method !== 'POST') {
                http_response_code(405);
                echo json_encode(errorResponse('Method not allowed', 'METHOD_NOT_ALLOWED'));
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            $notificationId = isset($data['notificationId']) ? (int)$data['notificationId'] : 0;
            
            if ($notificationId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid notification ID', 'INVALID_ID'));
                break;
            }
            
            $db = Database::getInstance();
            $stmt = $db->connect()->prepare("
                UPDATE notifications SET status = 'READ' WHERE notificationId = ?
            ");
            
            $stmt->bind_param('i', $notificationId);
            
            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(errorResponse('Failed to update notification', 'UPDATE_ERROR'));
                logDatabaseError($stmt->error);
                break;
            }
            
            echo json_encode(successResponse([], 'Notification marked as read'));
            break;
            
        case 'send':
            // Send new notification
            if ($method !== 'POST') {
                http_response_code(405);
                echo json_encode(errorResponse('Method not allowed', 'METHOD_NOT_ALLOWED'));
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validation
            $errors = [];
            if (empty($data['recipientType'])) $errors[] = 'Recipient type is required';
            if (empty($data['channel'])) $errors[] = 'Channel is required';
            if (empty($data['messageBody'])) $errors[] = 'Message is required';
            
            if (!empty($errors)) {
                http_response_code(400);
                echo json_encode(validationError('Validation failed', $errors));
                break;
            }
            
            $db = Database::getInstance();
            
            $stmt = $db->connect()->prepare("
                INSERT INTO notifications (recipientType, recipientId, channel, messageBody, bookingReference, status)
                VALUES (?, ?, ?, ?, ?, 'SENT')
            ");
            
            $bookingRef = isset($data['bookingReference']) ? $data['bookingReference'] : NULL;
            $stmt->bind_param('siss', 
                $data['recipientType'],
                $data['recipientId'],
                $data['channel'],
                $data['messageBody']
            );
            
            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(errorResponse('Failed to send notification', 'INSERT_ERROR'));
                logDatabaseError($stmt->error);
                break;
            }
            
            logMessage('Notification sent to ' . $data['recipientType'] . ' via ' . $data['channel']);
            
            echo json_encode(successResponse([
                'notificationId' => $stmt->insert_id
            ], 'Notification sent successfully'));
            break;
            
        default:
            http_response_code(400);
            echo json_encode(errorResponse('Invalid action', 'INVALID_ACTION'));
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(errorResponse($e->getMessage(), 'SERVER_ERROR'));
    logMessage('Notifications controller error: ' . $e->getMessage());
}
?>
