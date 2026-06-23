<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$totalBookings  = $conn->query("SELECT COUNT(*) as c FROM bookings")->fetch_assoc()['c'];
$totalCustomers = $conn->query("SELECT COUNT(*) as c FROM customers")->fetch_assoc()['c'];
$todayTrips     = $conn->query("SELECT COUNT(*) as c FROM bookings WHERE DATE(bookingDate) = CURDATE()")->fetch_assoc()['c'];
$totalRevenue   = $conn->query("SELECT COALESCE(SUM(fareAmount),0) as t FROM bookings WHERE status='completed'")->fetch_assoc()['t'];

$recentStmt = $conn->prepare("SELECT b.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation, b.bookingDate, b.status, b.fareAmount FROM bookings b JOIN customers c ON b.customerId = c.customerId ORDER BY b.createdAt DESC LIMIT 10");
$recentStmt->execute();
$recentBookings = $recentStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$recentStmt->close();

require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="ph-text">
        <h1>Dashboard</h1>
        <p>Welcome back, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>. Here's your operational overview.</p>
    </div>
    <div class="action-btns">
        <a href="bookings.php" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Booking
        </a>
    </div>
</div>

<div class="metrics-grid">
    <div class="metric-card default">
        <div class="metric-icon"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
        <div><div class="metric-label">Total Bookings</div><div class="metric-value"><?= number_format($totalBookings) ?></div></div>
    </div>
    <div class="metric-card info">
        <div class="metric-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        <div><div class="metric-label">Active Customers</div><div class="metric-value"><?= number_format($totalCustomers) ?></div></div>
    </div>
    <div class="metric-card warning">
        <div class="metric-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div><div class="metric-label">Today's Trips</div><div class="metric-value"><?= number_format($todayTrips) ?></div></div>
    </div>
    <div class="metric-card success">
        <div class="metric-icon"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        <div><div class="metric-label">Total Revenue</div><div class="metric-value">R<?= number_format((float)$totalRevenue, 0) ?></div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Quick Actions</h2>
    </div>
    <div class="card-body">
        <div class="quick-grid">
            <a href="bookings.php" class="quick-item"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg><span>New Booking</span></a>
            <a href="schedule.php" class="quick-item"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><span>Assign Driver</span></a>
            <a href="customers.php" class="quick-item"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg><span>Add Customer</span></a>
            <a href="reports.php" class="quick-item"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg><span>View Reports</span></a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Recent Bookings</h2>
        <a href="bookings.php" class="btn btn-ghost btn-sm">View all</a>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Customer</th><th>Route</th><th>Date</th><th>Fare</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($recentBookings as $b): ?>
                    <tr>
                        <td><span style="color:var(--smoke);font-size:12px;">#</span><?= $b['bookingId'] ?></td>
                        <td><strong><?= htmlspecialchars($b['fullName']) ?></strong></td>
                        <td>
                            <div class="route-from"><?= htmlspecialchars($b['pickupLocation']) ?></div>
                            <div class="route-to"><svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg><?= htmlspecialchars($b['dropoffLocation']) ?></div>
                        </td>
                        <td><?= date('d M Y', strtotime($b['bookingDate'])) ?></td>
                        <td>R<?= number_format($b['fareAmount'], 2) ?></td>
                        <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($recentBookings)): ?>
                    <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--smoke);">No bookings yet</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>