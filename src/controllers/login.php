<?php
/**
 * Login Controller
 */

declare(strict_types=1);

session_name('NBK_SHUTTLE_SESSION');
session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../models/Auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $username = sanitizeString($data['username'] ?? '');
        $password = $data['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            errorResponse('Username and password required', ['username' => 'Required', 'password' => 'Required']);
        }
        
        $auth = new Auth();
        $result = $auth->login($username, $password);
        
        if ($result['success']) {
            successResponse($result['message'], $result);
        } else {
            errorResponse($result['message'], [], 401);
        }
    } catch (\Exception $e) {
        logMessage("Login error: " . $e->getMessage(), 'ERROR');
        errorResponse('Login failed', [], 500);
    }
} else {
    errorResponse('Method not allowed', [], 405);
}

?>
