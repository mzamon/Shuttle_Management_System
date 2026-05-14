<?php
/**
 * Schedule Management Page - Driver & Vehicle Assignment
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

// Get unassigned confirmed bookings
$bookingsStmt = $conn->prepare("SELECT b.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation, b.bookingDate FROM bookings b JOIN customers c ON b.customerId = c.customerId WHERE b.status = 'pending' OR (b.status = 'confirmed' AND b.driverId IS NULL) ORDER BY b.bookingDate ASC");
$bookingsStmt->execute();
$bookingsResult = $bookingsStmt->get_result();
$unassignedBookings = [];
while ($row = $bookingsResult->fetch_assoc()) {
    $unassignedBookings[] = $row;
}
$bookingsStmt->close();

// Get schedule data
$startDate = date('Y-m-d');
$endDate = date('Y-m-d', strtotime('+7 days'));
$scheduleStmt = $conn->prepare("SELECT s.*, b.pickupLocation, b.dropoffLocation, d.fullName as driverName, v.registrationNumber FROM schedules s JOIN bookings b ON s.bookingId = b.bookingId JOIN drivers d ON s.driverId = d.driverId JOIN vehicles v ON s.vehicleId = v.vehicleId WHERE s.scheduledStart BETWEEN ? AND ? ORDER BY s.scheduledStart ASC");
$scheduleStmt->bind_param("ss", $startDate, $endDate);
$scheduleStmt->execute();
$scheduleResult = $scheduleStmt->get_result();
$schedules = [];
while ($row = $scheduleResult->fetch_assoc()) {
    $schedules[] = $row;
}
$scheduleStmt->close();

// Get available drivers and vehicles
$driversResult = $conn->query("SELECT driverId, fullName FROM drivers WHERE status = 'available' ORDER BY fullName");
$drivers = [];
while ($row = $driversResult->fetch_assoc()) {
    $drivers[] = $row;
}

$vehiclesResult = $conn->query("SELECT vehicleId, registrationNumber, make, model FROM vehicles WHERE status = 'available' ORDER BY registrationNumber");
$vehicles = [];
while ($row = $vehiclesResult->fetch_assoc()) {
    $vehicles[] = $row;
}

require_once 'includes/header.php';
?>

<div class="page-header">
    <h1>Schedule Management</h1>
    <p>Assign drivers and vehicles to bookings</p>
</div>

<!-- Assignment Form -->
<div class="card">
    <div class="card-header">
        <h2>Assign Driver & Vehicle</h2>
    </div>
    <div class="card-body">
        <form id="assignmentForm" class="form-wrapper">
            <div class="form-row">
                <div class="form-group full">
                    <label for="bookingId">Select Booking *</label>
                    <select id="bookingId" required onchange="updateBookingDetails()">
                        <option value="">-- Select Booking --</option>
                        <?php foreach ($unassignedBookings as $booking): ?>
                        <option value="<?php echo $booking['bookingId']; ?>">
                            #<?php echo $booking['bookingId']; ?> - <?php echo htmlspecialchars($booking['fullName']); ?> (<?php echo htmlspecialchars($booking['pickupLocation']); ?> → <?php echo htmlspecialchars($booking['dropoffLocation']); ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="driverId">Driver *</label>
                    <select id="driverId" required>
                        <option value="">-- Select Driver --</option>
                        <?php foreach ($drivers as $driver): ?>
                        <option value="<?php echo $driver['driverId']; ?>"><?php echo htmlspecialchars($driver['fullName']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vehicleId">Vehicle *</label>
                    <select id="vehicleId" required>
                        <option value="">-- Select Vehicle --</option>
                        <?php foreach ($vehicles as $vehicle): ?>
                        <option value="<?php echo $vehicle['vehicleId']; ?>"><?php echo htmlspecialchars($vehicle['registrationNumber']); ?> - <?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="startTime">Start Time *</label>
                    <input type="datetime-local" id="startTime" required>
                </div>

                <div class="form-group">
                    <label for="endTime">End Time *</label>
                    <input type="datetime-local" id="endTime" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Assign</button>
        </form>
    </div>
</div>

<!-- Weekly Schedule Grid -->
<div class="card">
    <div class="card-header">
        <h2>Weekly Schedule (<?php echo $startDate; ?> to <?php echo $endDate; ?>)</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Route</th>
                    <th>Driver</th>
                    <th>Vehicle</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedules as $schedule): ?>
                <tr>
                    <td>#<?php echo $schedule['bookingId']; ?></td>
                    <td><?php echo htmlspecialchars($schedule['pickupLocation']); ?> → <?php echo htmlspecialchars($schedule['dropoffLocation']); ?></td>
                    <td><?php echo htmlspecialchars($schedule['driverName']); ?></td>
                    <td><?php echo htmlspecialchars($schedule['registrationNumber']); ?></td>
                    <td><?php echo date('M d H:i', strtotime($schedule['scheduledStart'])); ?></td>
                    <td><?php echo date('M d H:i', strtotime($schedule['scheduledEnd'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function updateBookingDetails() {
    // This would load booking details if needed
}

document.getElementById('assignmentForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const data = {
        bookingId: parseInt(document.getElementById('bookingId').value),
        driverId: parseInt(document.getElementById('driverId').value),
        vehicleId: parseInt(document.getElementById('vehicleId').value),
        startTime: document.getElementById('startTime').value,
        endTime: document.getElementById('endTime').value
    };

    const result = await NBKTravel.apiCall('/api/schedule.php?action=assign', 'POST', data);
    
    if (!result.success) {
        if (result.message === 'CONFLICT_DETECTED') {
            NBKTravel.showToast('⚠️ CONFLICT DETECTED! Driver or vehicle already assigned at this time.', 'warning');
            return;
        }
        NBKTravel.showToast(result.message, 'error');
        return;
    }

    NBKTravel.showToast('Assignment successful', 'success');
    document.getElementById('assignmentForm').reset();
    setTimeout(() => location.reload(), 1500);
});
</script>

<?php require_once 'includes/footer.php'; ?>
