<?php
/**
 * Notifications Log Page
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

// Get notifications
$notificationsResult = $conn->query("SELECT notificationId, recipientType, channel, messageBody, sentAt, status FROM notifications ORDER BY sentAt DESC LIMIT 100");
$notifications = [];
while ($row = $notificationsResult->fetch_assoc()) {
    $notifications[] = $row;
}

require_once 'includes/header.php';
?>

<div class="page-header">
    <h1>Notifications Log</h1>
    <p>View all system notifications and communication history</p>
</div>

<!-- Notifications Table -->
<div class="card">
    <div class="card-header">
        <h2>Recent Notifications</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Channel</th>
                    <th>Message</th>
                    <th>Sent At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notifications as $notification): ?>
                <tr>
                    <td>#<?php echo $notification['notificationId']; ?></td>
                    <td>
                        <span class="badge" style="background: rgba(0, 212, 255, 0.1); color: #00d4ff; border: 1px solid #00d4ff;">
                            <?php echo ucfirst($notification['recipientType']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($notification['channel'] === 'sms'): ?>
                            <span>📱 SMS</span>
                        <?php elseif ($notification['channel'] === 'email'): ?>
                            <span>📧 Email</span>
                        <?php else: ?>
                            <span>🔔 System</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars(substr($notification['messageBody'], 0, 80)); ?>...</td>
                    <td><?php echo date('M d, Y H:i', strtotime($notification['sentAt'])); ?></td>
                    <td>
                        <span class="badge <?php echo $notification['status'] === 'logged' ? 'badge-confirmed' : 'badge-danger'; ?>">
                            <?php echo ucfirst($notification['status']); ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
