<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$customers = $conn->query("SELECT customerId, fullName, phoneNumber, emailAddress, preferences FROM customers ORDER BY fullName")->fetch_all(MYSQLI_ASSOC);
require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="ph-text"><h1>Customers</h1><p>Manage customer profiles and booking history</p></div>
</div>

<div class="card">
    <div class="card-header"><h2>Add New Customer</h2></div>
    <div class="card-body">
        <form id="customerForm">
            <div class="form-row">
                <div class="form-group"><label>Full Name *</label><input type="text" id="fullName" name="fullName" required></div>
                <div class="form-group"><label>Phone Number *</label><input type="tel" id="phoneNumber" name="phoneNumber" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Email Address</label><input type="email" id="emailAddress" name="emailAddress"></div>
                <div class="form-group"><label>Preferences</label><input type="text" id="preferences" name="preferences" placeholder="e.g. Window seat"></div>
            </div>
            <button type="submit" class="btn btn-primary"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Customer</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><h2>All Customers</h2><span class="card-header-meta"><?= count($customers) ?> records</span></div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Preferences</th></tr></thead>
                <tbody>
                    <?php foreach ($customers as $c): ?>
                    <tr><td><span style="color:var(--smoke);font-size:11px;">#</span><?= $c['customerId'] ?></td><td><strong><?= htmlspecialchars($c['fullName']) ?></strong></td><td><?= htmlspecialchars($c['phoneNumber']) ?></td><td><?= htmlspecialchars($c['emailAddress'] ?? '—') ?></td><td><?= htmlspecialchars($c['preferences'] ?? '—') ?></td></tr>
                    <?php endforeach; ?>
                    <?php if (empty($customers)): ?><tr><td colspan="5" style="text-align:center;padding:40px;color:var(--smoke);">No customers yet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('customerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = {
        fullName: document.getElementById('fullName').value,
        phoneNumber: document.getElementById('phoneNumber').value,
        emailAddress: document.getElementById('emailAddress').value,
        preferences: document.getElementById('preferences').value
    };
    const res = await NBKTravel.apiCall('/nbk-travel/api/customers.php?action=create', 'POST', data);
    if (res.success) { NBKTravel.showToast('Customer added', 'success'); e.target.reset(); setTimeout(() => location.reload(), 1500); }
    else NBKTravel.showToast(res.message, 'error');
});
</script>

<?php require_once 'includes/footer.php'; ?>