<?php
/**
 * Database Connection - MySQLi
 * NBK Travel Shuttle Booking Management System
 */

$servername = "localhost";
$username = "root";
$password = "";
$database = "nbk_travel";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

?>
