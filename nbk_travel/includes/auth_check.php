<?php
/**
 * AUTH CHECK – OVERRIDDEN
 * If no session exists, automatically create a default admin session.
 */
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['userId']) || !isset($_SESSION['role'])) {
    // Auto-login as admin
    $_SESSION['userId'] = 1;
    $_SESSION['username'] = 'admin';
    $_SESSION['role'] = 'admin';
}
// Always allow access – no redirect.
?>