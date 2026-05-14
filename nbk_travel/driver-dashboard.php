<?php
/**
 * Driver Dashboard
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

// Ensure user is a driver
if ($_SESSION['role'] !== 'driver') {
    header('Location: /dashboard.php');
    exit;
}

// Get driver ID from session
$stmt = $conn->prepare("SELECT driverId FROM users WHERE userId = ?");
$stmt->bind_param("i", $_SESSION['userId']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$driverId = $row['driverId'] ?? null;
$stmt->close();

if (!$driverId) {
    header('Location: /logout.php');
    exit;
}

// Get assigned trips for this driver
$tripsStmt = $conn->prepare("SELECT b.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation, b.bookingDate, b.passengers, v.registrationNumber, b.status FROM bookings b JOIN customers c ON b.customerId = c.customerId LEFT JOIN vehicles v ON b.vehicleId = v.vehicleId WHERE b.driverId = ? AND (b.status = 'confirmed' OR b.status = 'completed') ORDER BY b.bookingDate ASC");
$tripsStmt->bind_param("i", $driverId);
$tripsStmt->execute();
$tripsResult = $tripsStmt->get_result();
$trips = [];
while ($row = $tripsResult->fetch_assoc()) {
    $trips[] = $row;
}
$tripsStmt->close();

// Get driver info
$driverStmt = $conn->prepare("SELECT fullName, phoneNumber, status FROM drivers WHERE driverId = ?");
$driverStmt->bind_param("i", $driverId);
$driverStmt->execute();
$driverResult = $driverStmt->get_result();
$driverInfo = $driverResult->fetch_assoc();
$driverStmt->close();

require_once 'includes/header.php';
?>

<div class="page-header">
    <h1>My Trips Dashboard</h1>
    <p>Welcome, <?php echo htmlspecialchars($driverInfo['fullName']); ?>! Here are your assigned trips.</p>
</div>

<!-- Driver Info Card -->
<div class="card">
    <div class="card-header">
        <h2>Your Information</h2>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
            <div>
                <strong>Name</strong><br>
                <?php echo htmlspecialchars($driverInfo['fullName']); ?>
            </div>
            <div>
                <strong>Phone</strong><br>
                <?php echo htmlspecialchars($driverInfo['phoneNumber']); ?>
            </div>
            <div>
                <strong>Status</strong><br>
                <span class="badge <?php echo 'badge-' . str_replace('-', '_', $driverInfo['status']); ?>">
                    <?php echo ucfirst(str_replace('-', ' ', $driverInfo['status'])); ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Assigned Trips -->
<div class="card">
    <div class="card-header">
        <h2>My Assigned Trips</h2>
    </div>
    <div class="card-body">
        <?php if (count($trips) === 0): ?>
            <div style="text-align: center; padding: 40px; color: var(--text-secondary);">
                <p style="font-size: 18px;">No trips assigned yet</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Pickup Location</th>
                        <th>Dropoff Location</th>
                        <th>Date & Time</th>
                        <th>Passengers</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trips as $trip): ?>
                    <tr>
                        <td>#<?php echo $trip['bookingId']; ?></td>
                        <td><?php echo htmlspecialchars($trip['fullName']); ?></td>
                        <td><?php echo htmlspecialchars($trip['pickupLocation']); ?></td>
                        <td><?php echo htmlspecialchars($trip['dropoffLocation']); ?></td>
                        <td><?php echo date('M d, Y H:i', strtotime($trip['bookingDate'])); ?></td>
                        <td><?php echo $trip['passengers']; ?></td>
                        <td><?php echo htmlspecialchars($trip['registrationNumber'] ?? '—'); ?></td>
                        <td>
                            <span class="badge <?php echo 'badge-' . $trip['status']; ?>">
                                <?php echo ucfirst($trip['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($trip['status'] === 'confirmed'): ?>
                            <button class="btn-icon success" onclick="completeTrip(<?php echo $trip['bookingId']; ?>)" title="Mark as Complete">✓</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
function completeTrip(bookingId) {
    if (!confirm('Mark this trip as completed?')) return;

    NBKTravel.apiCall('/api/schedule.php?action=complete', 'POST', {
        bookingId: bookingId
    }).then(result => {
        if (result.success) {
            NBKTravel.showToast('Trip marked as completed! 🎉', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            NBKTravel.showToast(result.message, 'error');
        }
    });
}
</script>

<?php require_once 'includes/footer.php'; ?>
