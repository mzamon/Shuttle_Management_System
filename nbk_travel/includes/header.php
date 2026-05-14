<?php
/**
 * Header & Sidebar Navigation
 * NBK Travel Shuttle Booking Management System
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBK Travel - Shuttle Booking Management</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <span class="logo-icon">🚐</span>
                <h2>NBK Travel</h2>
            </div>
        </div>

        <nav class="sidebar-nav">
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="/dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="/bookings.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'bookings.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">📅</span>
                    <span>Bookings</span>
                </a>
                <a href="/schedule.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'schedule.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">📍</span>
                    <span>Schedule</span>
                </a>
                <a href="/customers.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'customers.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">👥</span>
                    <span>Customers</span>
                </a>
                <a href="/drivers.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'drivers.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">🚗</span>
                    <span>Drivers</span>
                </a>
                <a href="/vehicles.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'vehicles.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">🚌</span>
                    <span>Vehicles</span>
                </a>
                <a href="/reports.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'reports.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">📈</span>
                    <span>Reports</span>
                </a>
                <a href="/invoices.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'invoices.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">🧾</span>
                    <span>Invoices</span>
                </a>
                <a href="/notifications.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'notifications.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">🔔</span>
                    <span>Notifications</span>
                </a>
            <?php elseif ($_SESSION['role'] === 'driver'): ?>
                <a href="/driver-dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'driver-dashboard.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">🏠</span>
                    <span>My Trips</span>
                </a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <p><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></p>
                <small><?php echo ucfirst($_SESSION['role']); ?></small>
            </div>
            <a href="/logout.php" class="logout-btn">Logout</a>
        </div>
    </aside>

    <!-- Main Content Container -->
    <main class="main-content">
