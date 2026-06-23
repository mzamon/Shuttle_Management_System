<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$notifications = $conn->query("SELECT notificationId, recipientType, channel, messageBody, sentAt, status FROM notifications ORDER BY sentAt DESC LIMIT 100")->fetch_all(MYSQLI_ASSOC);
require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="ph-text"><h1>Notifications</h1><p>System logs and notification history</p></div>
</div>

<div class="card">
    <div class="card-header"><h2>Recent Notifications</h2><span class="card-header-meta">Last 100</span></div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Type</th><th>Channel</th><th>Message</th><th>Sent At</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($notifications as $n): ?>
                    <tr>
                        <td>#<?= $n['notificationId'] ?></td>
                        <td><span class="badge badge-info"><?= ucfirst($n['recipientType']) ?></span></td>
                        <td>
                            <span class="channel-badge">
                                <span class="ch-dot <?= $n['channel'] ?>"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span>
                                <?= strtoupper($n['channel']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars(substr($n['messageBody'], 0, 60)) ?>…</td>
                        <td><?= date('d M Y H:i', strtotime($n['sentAt'])) ?></td>
                        <td><span class="badge badge-<?= $n['status'] ?>"><?= ucfirst($n['status']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($notifications)): ?><tr><td colspan="6" style="text-align:center;padding:40px;color:var(--smoke);">No notifications logged.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>