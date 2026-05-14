<?php
/**
 * Header Include - Navigation & Sidebar
 */

declare(strict_types=1);

session_name('NBK_SHUTTLE_SESSION');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Auth.php';

Auth::requireAuth();
Auth::checkTimeout();

$user = Auth::getCurrentUser();
$isAdmin = Auth::hasRole('admin');
$isDriver = Auth::hasRole('driver');
?>

<div class="sidebar" id="sidebar">
    <div style="padding: 1rem 0;">
        <h2 style="color: #3b82f6; margin-bottom: 1.5rem;">NBK Travel</h2>
    </div>
    
    <nav>
        <a href="dashboard.php" class="nav-item">
            <span>📊</span> Dashboard
        </a>
        
        <?php if ($isAdmin): ?>
            <a href="bookings.php" class="nav-item">
                <span>📝</span> Bookings
            </a>
            
            <a href="customers.php" class="nav-item">
                <span>👥</span> Customers
            </a>
            
            <a href="schedule.php" class="nav-item">
                <span>📅</span> Schedule
            </a>
            
            <a href="drivers.php" class="nav-item">
                <span>🚗</span> Drivers
            </a>
            
            <a href="reports.php" class="nav-item">
                <span>📈</span> Reports
            </a>
            
            <a href="invoices.php" class="nav-item">
                <span>📄</span> Invoices
            </a>
            
            <a href="notifications.php" class="nav-item">
                <span>🔔</span> Notifications
            </a>
            
            <a href="vehicles.php" class="nav-item">
                <span>🚙</span> Vehicles
            </a>
            
            <a href="admin-users.php" class="nav-item">
                <span>👨‍💼</span> Admin Users
            </a>
        <?php endif; ?>
        
        <?php if ($isDriver): ?>
            <a href="driver-trips.php" class="nav-item">
                <span>🛣️</span> My Trips
            </a>
        <?php endif; ?>
        
        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--glass-border);">
            <a href="#" class="nav-item" onclick="logout()">
                <span>🚪</span> Logout
            </a>
        </div>
    </nav>
</div>

<style>
    .header {
        position: fixed;
        top: 0;
        right: 0;
        left: 280px;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--glass-border);
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 100;
        transition: left 0.3s ease;
    }
    
    .header.expanded {
        left: 0;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .main-content {
        margin-left: 280px;
        margin-top: 70px;
        padding: 2rem;
        transition: margin-left 0.3s ease;
    }
    
    .main-content.expanded {
        margin-left: 0;
    }
</style>

<div class="header" id="header">
    <button onclick="toggleSidebar()" style="background: none; border: none; color: var(--text-primary); font-size: 1.5rem; cursor: pointer;">☰</button>
    
    <div class="user-info">
        <span><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></span>
        <div class="user-avatar"><?php echo strtoupper(substr($user['firstName'], 0, 1)); ?></div>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const header = document.getElementById('header');
        const mainContent = document.querySelector('.main-content');
        
        if (sidebar) {
            sidebar.classList.toggle('collapsed');
            header.classList.toggle('expanded');
            if (mainContent) {
                mainContent.classList.toggle('expanded');
            }
        }
    }
    
    async function logout() {
        if (confirm('Are you sure you want to logout?')) {
            window.location.href = 'logout.php';
        }
    }
</script>

