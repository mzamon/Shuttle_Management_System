<?php
/**
 * Drivers Management Page
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$driversResult = $conn->query("SELECT driverId, fullName, licenceNumber, phoneNumber, status FROM drivers ORDER BY fullName");
$drivers = [];
while ($row = $driversResult->fetch_assoc()) {
    $drivers[] = $row;
}

require_once 'includes/header.php';
?>

<div class="page-header">
    <h1>Driver Management</h1>
    <p>Manage drivers and their assignments</p>
</div>

<!-- Add Driver Form -->
<div class="card">
    <div class="card-header">
        <h2>Add New Driver</h2>
    </div>
    <div class="card-body">
        <form id="driverForm" class="form-wrapper">
            <div class="form-row">
                <div class="form-group">
                    <label for="fullName">Full Name *</label>
                    <input type="text" id="fullName" name="fullName" required>
                </div>

                <div class="form-group">
                    <label for="licenceNumber">Licence Number *</label>
                    <input type="text" id="licenceNumber" name="licenceNumber" required>
                </div>

                <div class="form-group">
                    <label for="phoneNumber">Phone Number *</label>
                    <input type="tel" id="phoneNumber" name="phoneNumber" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Driver</button>
        </form>
    </div>
</div>

<!-- Drivers Table -->
<div class="card">
    <div class="card-header">
        <h2>All Drivers</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Licence #</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($drivers as $driver): ?>
                <tr>
                    <td>#<?php echo $driver['driverId']; ?></td>
                    <td><?php echo htmlspecialchars($driver['fullName']); ?></td>
                    <td><?php echo htmlspecialchars($driver['licenceNumber']); ?></td>
                    <td><?php echo htmlspecialchars($driver['phoneNumber']); ?></td>
                    <td>
                        <span class="badge <?php echo 'badge-' . str_replace('-', '_', $driver['status']); ?>">
                            <?php echo ucfirst(str_replace('-', ' ', $driver['status'])); ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn-icon" onclick="toggleStatus(<?php echo $driver['driverId']; ?>, '<?php echo $driver['status']; ?>')">⚙️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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

    const result = await NBKTravel.apiCall('/api/drivers.php?action=create', 'POST', data);
    if (result.success) {
        NBKTravel.showToast('Driver added successfully', 'success');
        document.getElementById('driverForm').reset();
        setTimeout(() => location.reload(), 1500);
    } else {
        NBKTravel.showToast(result.message, 'error');
    }
});

function toggleStatus(driverId, currentStatus) {
    const statuses = ['available', 'on-trip', 'off-duty'];
    const currentIndex = statuses.indexOf(currentStatus);
    const newStatus = statuses[(currentIndex + 1) % statuses.length];

    NBKTravel.apiCall('/api/drivers.php?action=toggle_status', 'POST', {
        driverId: driverId,
        status: newStatus
    }).then(result => {
        if (result.success) {
            NBKTravel.showToast('Driver status updated', 'success');
            location.reload();
        } else {
            NBKTravel.showToast(result.message, 'error');
        }
    });
}
</script>

<?php require_once 'includes/footer.php'; ?>
