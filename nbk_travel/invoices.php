<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$invoices = $conn->query("SELECT i.invoiceId, i.invoiceDate, i.totalAmount, i.status, b.bookingId, c.fullName FROM invoices i JOIN bookings b ON i.bookingId = b.bookingId JOIN customers c ON i.customerId = c.customerId ORDER BY i.invoiceDate DESC")->fetch_all(MYSQLI_ASSOC);
require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="ph-text"><h1>Invoices</h1><p>View and generate invoices</p></div>
</div>

<div class="card">
    <div class="card-header"><h2>All Invoices</h2><span class="card-header-meta"><?= count($invoices) ?> records</span></div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table>
                <thead><tr><th>Invoice #</th><th>Customer</th><th>Booking</th><th>Date</th><th>Total</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($invoices as $inv): ?>
                    <tr><td><strong>#<?= $inv['invoiceId'] ?></strong></td><td><?= htmlspecialchars($inv['fullName']) ?></td><td>#<?= $inv['bookingId'] ?></td><td><?= date('d M Y', strtotime($inv['invoiceDate'])) ?></td><td>R<?= number_format($inv['totalAmount'], 2) ?></td><td><span class="badge badge-<?= $inv['status'] ?>"><?= ucfirst($inv['status']) ?></span></td></tr>
                    <?php endforeach; ?>
                    <?php if (empty($invoices)): ?><tr><td colspan="6" style="text-align:center;padding:40px;color:var(--smoke);">No invoices yet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>