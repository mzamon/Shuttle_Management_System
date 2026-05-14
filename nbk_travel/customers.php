<?php
/**
 * Customers Management Page
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$customersResult = $conn->query("SELECT customerId, fullName, phoneNumber, emailAddress, preferences FROM customers ORDER BY fullName");
$customers = [];
while ($row = $customersResult->fetch_assoc()) {
    $customers[] = $row;
}

require_once 'includes/header.php';
?>

<div class="page-header">
    <h1>Customer Management</h1>
    <p>Manage customer profiles and booking history</p>
</div>

<!-- Add Customer Form -->
<div class="card">
    <div class="card-header">
        <h2>Add New Customer</h2>
    </div>
    <div class="card-body">
        <form id="customerForm" class="form-wrapper">
            <div class="form-row">
                <div class="form-group">
                    <label for="fullName">Full Name *</label>
                    <input type="text" id="fullName" name="fullName" required>
                </div>

                <div class="form-group">
                    <label for="phoneNumber">Phone Number *</label>
                    <input type="tel" id="phoneNumber" name="phoneNumber" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="emailAddress">Email Address</label>
                    <input type="email" id="emailAddress" name="emailAddress">
                </div>

                <div class="form-group">
                    <label for="preferences">Preferences</label>
                    <input type="text" id="preferences" name="preferences" placeholder="e.g., Window seat, Early pickup">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Customer</button>
        </form>
    </div>
</div>

<!-- Customers Table -->
<div class="card">
    <div class="card-header">
        <h2>All Customers</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Preferences</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td>#<?php echo $customer['customerId']; ?></td>
                    <td><?php echo htmlspecialchars($customer['fullName']); ?></td>
                    <td><?php echo htmlspecialchars($customer['phoneNumber']); ?></td>
                    <td><?php echo htmlspecialchars($customer['emailAddress'] ?? '—'); ?></td>
                    <td><?php echo htmlspecialchars($customer['preferences'] ?? '—'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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

    const result = await NBKTravel.apiCall('/api/customers.php?action=create', 'POST', data);
    if (result.success) {
        NBKTravel.showToast('Customer added successfully', 'success');
        document.getElementById('customerForm').reset();
        setTimeout(() => location.reload(), 1500);
    } else {
        NBKTravel.showToast(result.message, 'error');
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
