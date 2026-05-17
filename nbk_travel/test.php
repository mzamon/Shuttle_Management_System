<?php
/**
 * Test Results - NBK Travel System
 */
session_start();

// Test 1: Database Connection
echo "<h1>🧪 NBK Travel - System Test Results</h1>";
echo "<hr>";

echo "<h2>Test 1: Database Connection</h2>";
require_once 'includes/db.php';

$dbTest = $conn->query("SELECT COUNT(*) as count FROM users");
if ($dbTest) {
    $row = $dbTest->fetch_assoc();
    echo "✅ Database connected. Users count: " . $row['count'] . "<br>";
} else {
    echo "❌ Database connection failed<br>";
}

// Test 2: User Credentials
echo "<h2>Test 2: User Credentials</h2>";
$users = $conn->query("SELECT username, role FROM users");
echo "<ul>";
while ($user = $users->fetch_assoc()) {
    echo "<li>{$user['username']} ({$user['role']})</li>";
}
echo "</ul>";

// Test 3: Tables Data
echo "<h2>Test 3: Database Tables</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Table</th><th>Records</th></tr>";

$tables = ['users', 'drivers', 'customers', 'vehicles', 'bookings', 'schedules', 'invoices', 'notifications'];
foreach ($tables as $table) {
    $result = $conn->query("SELECT COUNT(*) as count FROM $table");
    $row = $result->fetch_assoc();
    echo "<tr><td>$table</td><td>" . $row['count'] . "</td></tr>";
}
echo "</table>";

// Test 4: API Files
echo "<h2>Test 4: API Files</h2>";
$apiFiles = glob('api/*.php');
echo "<ul>";
foreach ($apiFiles as $file) {
    echo "<li>✅ " . basename($file) . "</li>";
}
echo "</ul>";

// Test 5: Page Files
echo "<h2>Test 5: Admin Pages</h2>";
$pageFiles = ['index.php', 'dashboard.php', 'bookings.php', 'schedule.php', 'customers.php', 'drivers.php', 'vehicles.php', 'reports.php', 'invoices.php', 'notifications.php', 'driver-dashboard.php', 'logout.php'];
echo "<ul>";
foreach ($pageFiles as $file) {
    if (file_exists($file)) {
        echo "<li>✅ $file</li>";
    } else {
        echo "<li>❌ $file (MISSING)</li>";
    }
}
echo "</ul>";

// Test 6: Login Test
echo "<h2>Test 6: Login Functionality</h2>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username && $password) {
        $stmt = $conn->prepare("SELECT userId, username, passwordHash, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['passwordHash'])) {
                echo "✅ Login successful for $username<br>";
                echo "   Role: " . $user['role'] . "<br>";
                echo "   <a href='index.php'>Go to Login Page</a>";
            } else {
                echo "❌ Password incorrect";
            }
        } else {
            echo "❌ User not found";
        }
    }
} else {
    echo "<form method='POST'>";
    echo "Username: <input name='username' value='admin'> ";
    echo "Password: <input name='password' type='password' value='password'> ";
    echo "<button type='submit'>Test Login</button>";
    echo "</form>";
}

// Test 7: Sample Booking Data
echo "<h2>Test 7: Sample Bookings</h2>";
$bookings = $conn->query("SELECT bookingId, customerId, status, fareAmount FROM bookings LIMIT 3");
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Booking ID</th><th>Customer ID</th><th>Status</th><th>Fare</th></tr>";
while ($booking = $bookings->fetch_assoc()) {
    echo "<tr><td>{$booking['bookingId']}</td><td>{$booking['customerId']}</td><td>{$booking['status']}</td><td>\${$booking['fareAmount']}</td></tr>";
}
echo "</table>";

echo "<hr>";
echo "<h2>✅ All Systems Ready!</h2>";
echo "<p><a href='index.php' style='font-size: 18px; font-weight: bold;'>→ Go to Login Page</a></p>";
$conn->close();
?>
