<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "nbk_travel";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die('<div style="background:#0b1a30;color:#ff4560;font-family:monospace;padding:40px;min-height:100vh;"><h2 style="color:#00e5ff;margin-bottom:16px;">⚡ NBK Travel – DB Connection Failed</h2><p>Error: ' . htmlspecialchars($conn->connect_error) . '</p><p style="margin-top:16px;color:#7da8c8;">Check credentials in <code>includes/db.php</code> and ensure MySQL is running.</p></div>');
}
$conn->set_charset("utf8mb4");
?>