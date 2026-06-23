<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$unassignedStmt = $conn->prepare(
    "SELECT b.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation, b.bookingDate, b.passengers, b.fareAmount
     FROM bookings b JOIN customers c ON b.customerId = c.customerId
     WHERE b.status IN ('pending','confirmed') AND b.driverId IS NULL
     ORDER BY b.bookingDate ASC"
);
$unassignedStmt->execute();
$unassigned = $unassignedStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$unassignedStmt->close();

$drivers = $conn->query("SELECT driverId, fullName FROM drivers WHERE status = 'available'")->fetch_all(MYSQLI_ASSOC);
$vehicles = $conn->query("SELECT vehicleId, registrationNumber, capacity FROM vehicles WHERE status = 'available'")->fetch_all(MYSQLI_ASSOC);

require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="ph-text">
        <h1>Schedule & Assignment</h1>
        <p>Assign drivers and vehicles to bookings</p>
    </div>
</div>

<?php if (empty($unassigned)): ?>
<div class="card"><div class="empty-state"><div class="empty-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div><h3>No unassigned bookings</h3><p>All bookings are assigned or completed.</p></div></div>
<?php else: ?>
<div class="card">
    <div class="card-header">
        <h2>Unassigned Bookings</h2>
        <span class="card-header-meta"><?= count($unassigned) ?> pending</span>
    </div>
    <div class="card-body">
        <?php foreach ($unassigned as $b): ?>
        <div class="assign-card">
            <div class="assign-header">
                <div><strong>#<?= $b['bookingId'] ?></strong> – <span style="color:var(--ice);"><?= htmlspecialchars($b['fullName']) ?></span> <span style="color:var(--smoke);font-size:13px;margin-left:12px;"><?= date('d M Y H:i', strtotime($b['bookingDate'])) ?></span></div>
                <span class="badge badge-pending">Pending</span>
            </div>
            <div class="assign-info">
                <span>📍 <?= htmlspecialchars($b['pickupLocation']) ?> → <?= htmlspecialchars($b['dropoffLocation']) ?></span>
                <span>👥 <?= $b['passengers'] ?> pax</span>
                <span>R<?= number_format($b['fareAmount'], 2) ?></span>
            </div>
            <form class="assign-form" data-booking="<?= $b['bookingId'] ?>">
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <div class="form-group" style="flex:1;min-width:150px;">
                        <label>Driver</label>
                        <select name="driverId" required>
                            <option value="">Select</option>
                            <?php foreach ($drivers as $d): ?><option value="<?= $d['driverId'] ?>"><?= htmlspecialchars($d['fullName']) ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="flex:1;min-width:150px;">
                        <label>Vehicle</label>
                        <select name="vehicleId" required>
                            <option value="">Select</option>
                            <?php foreach ($vehicles as $v): ?><option value="<?= $v['vehicleId'] ?>"><?= htmlspecialchars($v['registrationNumber']) ?> (<?= $v['capacity'] ?> seats)</option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="flex:1;min-width:130px;">
                        <label>Start Time</label>
                        <input type="datetime-local" name="startTime" value="<?= date('Y-m-d\TH:i', strtotime($b['bookingDate'])) ?>" required>
                    </div>
                    <div class="form-group" style="flex:1;min-width:130px;">
                        <label>End Time</label>
                        <input type="datetime-local" name="endTime" value="<?= date('Y-m-d\TH:i', strtotime($b['bookingDate']) + 3600) ?>" required>
                    </div>
                    <div style="display:flex;align-items:flex-end;padding-bottom:4px;">
                        <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                    </div>
                </div>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<script>
document.querySelectorAll('.assign-form').forEach(form => {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const bookingId = form.dataset.booking;
        const data = {
            bookingId: parseInt(bookingId),
            driverId: parseInt(form.querySelector('[name="driverId"]').value),
            vehicleId: parseInt(form.querySelector('[name="vehicleId"]').value),
            startTime: form.querySelector('[name="startTime"]').value,
            endTime: form.querySelector('[name="endTime"]').value
        };
        const btn = form.querySelector('button[type=submit]');
        btn.disabled = true; btn.textContent = 'Assigning…';
        const res = await NBKTravel.apiCall('/nbk-travel/api/schedule.php?action=assign', 'POST', data);
        if (res.success) {
            NBKTravel.showToast('Assignment successful', 'success');
            setTimeout(() => location.reload(), 1500);
        } else if (res.data?.conflict) {
            NBKTravel.showToast('Conflict! Driver/vehicle already booked.', 'error');
            btn.disabled = false; btn.textContent = 'Assign';
        } else {
            NBKTravel.showToast(res.message || 'Failed', 'error');
            btn.disabled = false; btn.textContent = 'Assign';
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>