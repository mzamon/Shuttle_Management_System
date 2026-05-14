<?php
/**
 * Dashboard Page
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

// Get dashboard metrics
$totalBookings = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
$totalCustomers = $conn->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'];
$todayTrips = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE DATE(bookingDate) = CURDATE()")->fetch_assoc()['count'];
$totalRevenue = $conn->query("SELECT COALESCE(SUM(fareAmount), 0) as total FROM bookings WHERE status = 'completed'")->fetch_assoc()['total'];

// Get recent bookings
$recentStmt = $conn->prepare("SELECT b.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation, b.bookingDate, b.status, b.fareAmount FROM bookings b JOIN customers c ON b.customerId = c.customerId ORDER BY b.createdAt DESC LIMIT 10");
$recentStmt->execute();
$recentResult = $recentStmt->get_result();
$recentBookings = [];
while ($row = $recentResult->fetch_assoc()) {
    $recentBookings[] = $row;
}
$recentStmt->close();

require_once 'includes/header.php';
?>

<div class="page-header">
    <h1>Dashboard</h1>
    <p>Welcome back! Here's your operational overview.</p>
</div>

<!-- Metric Cards -->
<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon">📅</div>
        <div class="metric-label">Total Bookings</div>
        <div class="metric-value"><?php echo $totalBookings; ?></div>
    </div>

    <div class="metric-card">
        <div class="metric-icon">👥</div>
        <div class="metric-label">Active Customers</div>
        <div class="metric-value"><?php echo $totalCustomers; ?></div>
    </div>

    <div class="metric-card">
        <div class="metric-icon">🚗</div>
        <div class="metric-label">Today's Trips</div>
        <div class="metric-value"><?php echo $todayTrips; ?></div>
    </div>

    <div class="metric-card success">
        <div class="metric-icon">💰</div>
        <div class="metric-label">Total Revenue</div>
        <div class="metric-value">$<?php echo number_format($totalRevenue, 2); ?></div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h2>Quick Actions</h2>
    </div>
    <div class="card-body">
        <div class="action-buttons" style="gap: 16px;">
            <a href="/bookings.php" class="btn btn-primary">
                <span>📅</span> New Booking
            </a>
            <a href="/schedule.php" class="btn btn-primary">
                <span>📍</span> Assign Driver
            </a>
            <a href="/reports.php" class="btn btn-primary">
                <span>📈</span> Generate Report
            </a>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="card">
    <div class="card-header">
        <h2>Recent Bookings</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Route</th>
                    <th>Date</th>
                    <th>Fare</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentBookings as $booking): ?>
                <tr>
                    <td>#<?php echo $booking['bookingId']; ?></td>
                    <td><?php echo htmlspecialchars($booking['fullName']); ?></td>
                    <td><?php echo htmlspecialchars($booking['pickupLocation']); ?> → <?php echo htmlspecialchars($booking['dropoffLocation']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($booking['bookingDate'])); ?></td>
                    <td>$<?php echo number_format($booking['fareAmount'], 2); ?></td>
                    <td>
                        <span class="badge <?php echo 'badge-' . $booking['status']; ?>">
                            <?php echo ucfirst($booking['status']); ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
