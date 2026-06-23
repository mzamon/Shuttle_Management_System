<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$drivers = $conn->query("SELECT driverId, fullName, licenceNumber, phoneNumber, status FROM drivers ORDER BY fullName")->fetch_all(MYSQLI_ASSOC);
require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="ph-text"><h1>Drivers</h1><p>Manage drivers and their assignments</p></div>
</div>

<div class="card">
    <div class="card-header"><h2>Add New Driver</h2></div>
    <div class="card-body">
        <form id="driverForm">
            <div class="form-row">
                <div class="form-group"><label>Full Name *</label><input type="text" id="fullName" name="fullName" required></div>
                <div class="form-group"><label>Licence Number *</label><input type="text" id="licenceNumber" name="licenceNumber" required></div>
                <div class="form-group"><label>Phone Number *</label><input type="tel" id="phoneNumber" name="phoneNumber" required></div>
            </div>
            <button type="submit" class="btn btn-primary"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Driver</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><h2>All Drivers</h2><span class="card-header-meta"><?= count($drivers) ?> records</span></div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Name</th><th>Licence #</th><th>Phone</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($drivers as $d): ?>
                    <tr>
                        <td><span style="color:var(--smoke);font-size:11px;">#</span><?= $d['driverId'] ?></td>
                        <td><strong><?= htmlspecialchars($d['fullName']) ?></strong></td>
                        <td><?= htmlspecialchars($d['licenceNumber']) ?></td>
                        <td><?= htmlspecialchars($d['phoneNumber']) ?></td>
                        <td><span class="badge badge-<?= str_replace('-', '_', $d['status']) ?>"><?= ucfirst(str_replace('-', ' ', $d['status'])) ?></span></td>
                        <td><button class="btn-icon" onclick="toggleStatus(<?= $d['driverId'] ?>, '<?= $d['status'] ?>')"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></button></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($drivers)): ?><tr><td colspan="6" style="text-align:center;padding:40px;color:var(--smoke);">No drivers yet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('driverForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = {
        fullName: document.getElementById('fullName').value,
        licenceNumber: document.getElementById('licenceNumber').value,
        phoneNumber: document.getElementById('phoneNumber').value
    };
    const res = await NBKTravel.apiCall('/nbk-travel/api/drivers.php?action=create', 'POST', data);
    if (res.success) { NBKTravel.showToast('Driver added', 'success'); e.target.reset(); setTimeout(() => location.reload(), 1500); }
    else NBKTravel.showToast(res.message, 'error');
});

async function toggleStatus(id, current) {
    const statuses = ['available','on-trip','off-duty'];
    const idx = statuses.indexOf(current);
    const next = statuses[(idx + 1) % statuses.length];
    const res = await NBKTravel.apiCall('/nbk-travel/api/drivers.php?action=toggle_status', 'POST', { driverId: id, status: next });
    if (res.success) { NBKTravel.showToast('Status updated', 'success'); setTimeout(() => location.reload(), 1200); }
    else NBKTravel.showToast(res.message, 'error');
}
</script>

<?php require_once 'includes/footer.php'; ?>