<?php
/**
 * Invoice API Controller
 * Handles invoice generation, retrieval, and PDF export
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
            // Get all invoices with pagination
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = RECORDS_PER_PAGE;
            $offset = ($page - 1) * $limit;
            
            $db = Database::getInstance();
            
            $stmt = $db->connect()->prepare("
                SELECT i.invoiceId, i.invoiceNumber, i.invoiceDate, 
                       i.subtotal, i.taxAmount, i.totalAmount, i.status,
                       b.bookingReference, c.fullName, c.phoneNumber
                FROM invoices i
                JOIN bookings b ON i.bookingId = b.bookingId
                JOIN customers c ON i.customerId = c.customerId
                ORDER BY i.invoiceDate DESC
                LIMIT ? OFFSET ?
            ");
            
            $stmt->bind_param('ii', $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $invoices = [];
            while ($row = $result->fetch_assoc()) {
                $invoices[] = $row;
            }
            
            // Get total count
            $countStmt = $db->connect()->prepare("SELECT COUNT(*) as total FROM invoices");
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $total = $countResult->fetch_assoc()['total'];
            
            echo json_encode(successResponse([
                'data' => $invoices,
                'pagination' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'pages' => ceil($total / $limit)
                ]
            ]));
            break;
            
        case 'view':
            // Get single invoice
            $invoiceId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if ($invoiceId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid invoice ID', 'INVALID_ID'));
                break;
            }
            
            $db = Database::getInstance();
            $stmt = $db->connect()->prepare("
                SELECT i.*, b.*, c.*
                FROM invoices i
                JOIN bookings b ON i.bookingId = b.bookingId
                JOIN customers c ON i.customerId = c.customerId
                WHERE i.invoiceId = ?
            ");
            
            $stmt->bind_param('i', $invoiceId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                http_response_code(404);
                echo json_encode(errorResponse('Invoice not found', 'NOT_FOUND'));
                break;
            }
            
            $invoice = $result->fetch_assoc();
            echo json_encode(successResponse($invoice));
            break;
            
        case 'generate':
            // Generate new invoice from booking
            if ($method !== 'POST') {
                http_response_code(405);
                echo json_encode(errorResponse('Method not allowed', 'METHOD_NOT_ALLOWED'));
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            $bookingId = isset($data['bookingId']) ? (int)$data['bookingId'] : 0;
            
            if ($bookingId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid booking ID', 'INVALID_ID'));
                break;
            }
            
            $db = Database::getInstance();
            
            // Check booking exists
            $bookingStmt = $db->connect()->prepare("
                SELECT * FROM bookings WHERE bookingId = ?
            ");
            $bookingStmt->bind_param('i', $bookingId);
            $bookingStmt->execute();
            $bookingResult = $bookingStmt->get_result();
            
            if ($bookingResult->num_rows === 0) {
                http_response_code(404);
                echo json_encode(errorResponse('Booking not found', 'NOT_FOUND'));
                break;
            }
            
            $booking = $bookingResult->fetch_assoc();
            
            // Generate invoice number
            $invoiceNumber = generateInvoiceNumber();
            $subtotal = $booking['fareAmount'];
            $taxAmount = calculateVAT($subtotal);
            $totalAmount = calculateTotal($subtotal, $taxAmount);
            
            // Create invoice
            $insertStmt = $db->connect()->prepare("
                INSERT INTO invoices (invoiceNumber, bookingId, customerId, invoiceDate, subtotal, taxAmount, totalAmount, status)
                VALUES (?, ?, ?, NOW(), ?, ?, ?, 'ISSUED')
            ");
            
            $insertStmt->bind_param('siiddd', $invoiceNumber, $bookingId, $booking['customerId'], $subtotal, $taxAmount, $totalAmount);
            
            if (!$insertStmt->execute()) {
                http_response_code(500);
                echo json_encode(errorResponse('Failed to create invoice', 'INSERT_ERROR'));
                logDatabaseError($insertStmt->error);
                break;
            }
            
            logMessage('Invoice generated: ' . $invoiceNumber . ' for booking: ' . $booking['bookingReference']);
            
            echo json_encode(successResponse([
                'invoiceId' => $insertStmt->insert_id,
                'invoiceNumber' => $invoiceNumber,
                'totalAmount' => $totalAmount
            ], 'Invoice generated successfully'));
            break;
            
        case 'export':
            // Export invoice as PDF reference
            $invoiceId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if ($invoiceId <= 0) {
                http_response_code(400);
                echo json_encode(errorResponse('Invalid invoice ID', 'INVALID_ID'));
                break;
            }
            
            $db = Database::getInstance();
            $stmt = $db->connect()->prepare("
                SELECT i.*, b.bookingReference, c.fullName, c.phoneNumber, c.emailAddress
                FROM invoices i
                JOIN bookings b ON i.bookingId = b.bookingId
                JOIN customers c ON i.customerId = c.customerId
                WHERE i.invoiceId = ?
            ");
            
            $stmt->bind_param('i', $invoiceId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                http_response_code(404);
                echo json_encode(errorResponse('Invoice not found', 'NOT_FOUND'));
                break;
            }
            
            $invoice = $result->fetch_assoc();
            
            echo json_encode(successResponse([
                'invoice' => $invoice,
                'pdfUrl' => '/invoices/pdf/' . $invoice['invoiceNumber'] . '.pdf'
            ], 'Invoice data ready for PDF generation'));
            break;
            
        default:
            http_response_code(400);
            echo json_encode(errorResponse('Invalid action', 'INVALID_ACTION'));
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(errorResponse($e->getMessage(), 'SERVER_ERROR'));
    logMessage('Invoice controller error: ' . $e->getMessage());
}
?>
