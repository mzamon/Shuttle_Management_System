<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

if ($_SESSION['role'] !== 'driver') { header('Location: dashboard.php'); exit; }

$stmt = $conn->prepare("SELECT driverId FROM users WHERE userId = ?");
$stmt->bind_param("i", $_SESSION['userId']);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$driverId = $row['driverId'] ?? null;
$stmt->close();
if (!$driverId) { header('Location: logout.php'); exit; }

$tripsStmt = $conn->prepare(
    "SELECT b.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation, b.bookingDate, b.passengers, v.registrationNumber, b.status
     FROM bookings b
     JOIN customers c ON b.customerId = c.customerId
     LEFT JOIN vehicles v ON b.vehicleId = v.vehicleId
     WHERE b.driverId = ? AND b.status IN ('confirmed','completed')
     ORDER BY b.bookingDate ASC"
);
$tripsStmt->bind_param("i", $driverId);
$tripsStmt->execute();
$trips = $tripsStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$tripsStmt->close();

$driverInfo = $conn->query("SELECT fullName, phoneNumber, status FROM drivers WHERE driverId = $driverId")->fetch_assoc();

require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="ph-text"><h1>My Trips</h1><p>Welcome, <strong><?= htmlspecialchars($driverInfo['fullName']) ?></strong></p></div>
</div>

<div class="card">
    <div class="card-header"><h2>Your Information</h2></div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:20px;">
            <div><strong>Name</strong><br><?= htmlspecialchars($driverInfo['fullName']) ?></div>
            <div><strong>Phone</strong><br><?= htmlspecialchars($driverInfo['phoneNumber']) ?></div>
            <div><strong>Status</strong><br><span class="badge badge-<?= str_replace('-', '_', $driverInfo['status']) ?>"><?= ucfirst(str_replace('-', ' ', $driverInfo['status'])) ?></span></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h2>Assigned Trips</h2></div>
    <div class="card-body">
        <?php if (empty($trips)): ?>
        <div class="empty-state"><div class="empty-icon"><svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div><h3>No trips assigned yet</h3></div>
        <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Booking</th><th>Customer</th><th>Route</th><th>Date/Time</th><th>Pax</th><th>Vehicle</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach ($trips as $t): ?>
                    <tr>
                        <td>#<?= $t['bookingId'] ?></td>
                        <td><strong><?= htmlspecialchars($t['fullName']) ?></strong></td>
                        <td><div class="route-from"><?= htmlspecialchars($t['pickupLocation']) ?></div><div class="route-to">→ <?= htmlspecialchars($t['dropoffLocation']) ?></div></td>
                        <td><?= date('d M Y H:i', strtotime($t['bookingDate'])) ?></td>
                        <td><?= $t['passengers'] ?></td>
                        <td><?= htmlspecialchars($t['registrationNumber'] ?? '—') ?></td>
                        <td><span class="badge badge-<?= $t['status'] ?>"><?= ucfirst($t['status']) ?></span></td>
                        <td><?php if ($t['status'] === 'confirmed'): ?><button class="btn-icon success" onclick="completeTrip(<?= $t['bookingId'] ?>)" title="Complete"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></button><?php endif; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
async function completeTrip(id) {
    if (!confirm('Mark this trip as completed?')) return;
    const res = await NBKTravel.apiCall('/nbk-travel/api/schedule.php?action=complete', 'POST', { bookingId: id });
    if (res.success) { NBKTravel.showToast('Trip completed!', 'success'); setTimeout(() => location.reload(), 1500); }
    else NBKTravel.showToast(res.message, 'error');
}
</script>

<?php require_once 'includes/footer.php'; ?>