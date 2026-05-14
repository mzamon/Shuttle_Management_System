<?php
/**
 * Vehicles Management Page
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$vehiclesResult = $conn->query("SELECT vehicleId, registrationNumber, make, model, capacity, status FROM vehicles ORDER BY registrationNumber");
$vehicles = [];
while ($row = $vehiclesResult->fetch_assoc()) {
    $vehicles[] = $row;
}

require_once 'includes/header.php';
?>

<div class="page-header">
    <h1>Vehicle Management</h1>
    <p>Manage vehicles in your fleet</p>
</div>

<!-- Add Vehicle Form -->
<div class="card">
    <div class="card-header">
        <h2>Add New Vehicle</h2>
    </div>
    <div class="card-body">
        <form id="vehicleForm" class="form-wrapper">
            <div class="form-row">
                <div class="form-group">
                    <label for="registrationNumber">Registration Number *</label>
                    <input type="text" id="registrationNumber" name="registrationNumber" placeholder="e.g., ABC-123" required>
                </div>

                <div class="form-group">
                    <label for="make">Make *</label>
                    <input type="text" id="make" name="make" placeholder="e.g., Toyota" required>
                </div>

                <div class="form-group">
                    <label for="model">Model *</label>
                    <input type="text" id="model" name="model" placeholder="e.g., Hiace" required>
                </div>

                <div class="form-group">
                    <label for="capacity">Capacity (seats) *</label>
                    <input type="number" id="capacity" name="capacity" min="1" value="7" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Vehicle</button>
        </form>
    </div>
</div>

<!-- Vehicles Table -->
<div class="card">
    <div class="card-header">
        <h2>All Vehicles</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Registration</th>
                    <th>Make & Model</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td>#<?php echo $vehicle['vehicleId']; ?></td>
                    <td><?php echo htmlspecialchars($vehicle['registrationNumber']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?></td>
                    <td><?php echo $vehicle['capacity']; ?> seats</td>
                    <td>
                        <span class="badge <?php echo 'badge-' . str_replace('-', '_', $vehicle['status']); ?>">
                            <?php echo ucfirst(str_replace('-', ' ', $vehicle['status'])); ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn-icon" onclick="toggleStatus(<?php echo $vehicle['vehicleId']; ?>, '<?php echo $vehicle['status']; ?>')">⚙️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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

    const result = await NBKTravel.apiCall('/api/vehicles.php?action=create', 'POST', data);
    if (result.success) {
        NBKTravel.showToast('Vehicle added successfully', 'success');
        document.getElementById('vehicleForm').reset();
        setTimeout(() => location.reload(), 1500);
    } else {
        NBKTravel.showToast(result.message, 'error');
    }
});

function toggleStatus(vehicleId, currentStatus) {
    const statuses = ['available', 'in-use', 'maintenance'];
    const currentIndex = statuses.indexOf(currentStatus);
    const newStatus = statuses[(currentIndex + 1) % statuses.length];

    NBKTravel.apiCall('/api/vehicles.php?action=toggle_status', 'POST', {
        vehicleId: vehicleId,
        status: newStatus
    }).then(result => {
        if (result.success) {
            NBKTravel.showToast('Vehicle status updated', 'success');
            location.reload();
        } else {
            NBKTravel.showToast(result.message, 'error');
        }
    });
}
</script>

<?php require_once 'includes/footer.php'; ?>
