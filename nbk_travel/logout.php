<?php
/**
 * Logout Page
 * NBK Travel Shuttle Booking Management System
 */

session_start();
session_destroy();
header('Location: /index.php');
exit;
?>
