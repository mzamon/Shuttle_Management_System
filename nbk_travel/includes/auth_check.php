<?php
/**
 * Authentication Check - Session Guard
 * NBK Travel Shuttle Booking Management System
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['userId']) || !isset($_SESSION['role'])) {
    header('Location: index.php');
    exit;
}

// If not an API request, you can add more specific checks here
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] !== '/api/auth.php') {
    if ($_SESSION['role'] === 'driver') {
        // Drivers can only complete trips
        if (!isset($_GET['action']) || $_GET['action'] !== 'complete') {
            http_response_code(403);
            exit;
        }
    }
}

?>
