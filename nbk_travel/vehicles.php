<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$vehicles = $conn->query("SELECT vehicleId, registrationNumber, make, model, capacity, status FROM vehicles ORDER BY registrationNumber")->fetch_all(MYSQLI_ASSOC);
require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="ph-text"><h1>Vehicles</h1><p>Manage your fleet</p></div>
</div>

<div class="card">
    <div class="card-header"><h2>Add New Vehicle</h2></div>
    <div class="card-body">
        <form id="vehicleForm">
            <div class="form-row">
                <div class="form-group"><label>Registration *</label><input type="text" id="registrationNumber" name="registrationNumber" placeholder="e.g. ABC-123" required></div>
                <div class="form-group"><label>Make *</label><input type="text" id="make" name="make" placeholder="e.g. Toyota" required></div>
                <div class="form-group"><label>Model *</label><input type="text" id="model" name="model" placeholder="e.g. Hiace" required></div>
                <div class="form-group"><label>Capacity (seats) *</label><input type="number" id="capacity" name="capacity" min="1" value="7" required></div>
            </div>
            <button type="submit" class="btn btn-primary"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Vehicle</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><h2>All Vehicles</h2><span class="card-header-meta"><?= count($vehicles) ?> records</span></div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Registration</th><th>Make & Model</th><th>Capacity</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($vehicles as $v): ?>
                    <tr>
                        <td><span style="color:var(--smoke);font-size:11px;">#</span><?= $v['vehicleId'] ?></td>
                        <td><strong><?= htmlspecialchars($v['registrationNumber']) ?></strong></td>
                        <td><?= htmlspecialchars($v['make'] . ' ' . $v['model']) ?></td>
                        <td><?= $v['capacity'] ?> seats</td>
                        <td><span class="badge badge-<?= str_replace('-', '_', $v['status']) ?>"><?= ucfirst(str_replace('-', ' ', $v['status'])) ?></span></td>
                        <td><button class="btn-icon" onclick="toggleStatus(<?= $v['vehicleId'] ?>, '<?= $v['status'] ?>')"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></button></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($vehicles)): ?><tr><td colspan="6" style="text-align:center;padding:40px;color:var(--smoke);">No vehicles yet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('vehicleForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = {
        registrationNumber: document.getElementById('registrationNumber').value,
        make: document.getElementById('make').value,
        model: document.getElementById('model').value,
        capacity: parseInt(document.getElementById('capacity').value)
    };
    const res = await NBKTravel.apiCall('/nbk-travel/api/vehicles.php?action=create', 'POST', data);
    if (res.success) { NBKTravel.showToast('Vehicle added', 'success'); e.target.reset(); setTimeout(() => location.reload(), 1500); }
    else NBKTravel.showToast(res.message, 'error');
});

async function toggleStatus(id, current) {
    const statuses = ['available','in-use','maintenance'];
    const idx = statuses.indexOf(current);
    const next = statuses[(idx + 1) % statuses.length];
    const res = await NBKTravel.apiCall('/nbk-travel/api/vehicles.php?action=toggle_status', 'POST', { vehicleId: id, status: next });
    if (res.success) { NBKTravel.showToast('Status updated', 'success'); setTimeout(() => location.reload(), 1200); }
    else NBKTravel.showToast(res.message, 'error');
}
</script>

<?php require_once 'includes/footer.php'; ?>