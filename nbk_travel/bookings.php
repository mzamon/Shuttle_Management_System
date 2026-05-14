<?php
/**
 * Bookings Management Page
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

// Get all customers for dropdown
$customersResult = $conn->query("SELECT customerId, fullName FROM customers ORDER BY fullName");
$customers = [];
while ($row = $customersResult->fetch_assoc()) {
    $customers[] = $row;
}

// Get all bookings
$bookingsStmt = $conn->prepare("SELECT b.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation, b.bookingDate, b.passengers, b.fareAmount, b.status, d.fullName as driverName, v.registrationNumber FROM bookings b JOIN customers c ON b.customerId = c.customerId LEFT JOIN drivers d ON b.driverId = d.driverId LEFT JOIN vehicles v ON b.vehicleId = v.vehicleId ORDER BY b.bookingDate DESC");
$bookingsStmt->execute();
$bookingsResult = $bookingsStmt->get_result();
$bookings = [];
while ($row = $bookingsResult->fetch_assoc()) {
    $bookings[] = $row;
}
$bookingsStmt->close();

require_once 'includes/header.php';
?>

<div class="page-header">
    <h1>Bookings Management</h1>
    <p>Create, view, and manage all shuttle bookings</p>
</div>

<!-- New Booking Form -->
<div class="card">
    <div class="card-header">
        <h2>Create New Booking</h2>
    </div>
    <div class="card-body">
        <form id="newBookingForm" class="form-wrapper">
            <div class="form-row">
                <div class="form-group">
                    <label for="customerId">Customer *</label>
                    <input type="hidden" id="customerId" name="customerId" required>
                    <input type="text" id="customerSearch" placeholder="Search customer..." autocomplete="off" required>
                    <div id="customerSuggestions" style="position: absolute; background: var(--bg-panel); border: 1px solid var(--border); border-radius: 6px; margin-top: 4px; max-height: 200px; overflow-y: auto; min-width: 250px; z-index: 100; display: none;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="passengers">Passengers *</label>
                    <input type="number" id="passengers" name="passengers" min="1" max="10" value="1" required>
                </div>

                <div class="form-group">
                    <label for="fareAmount">Fare Amount ($) *</label>
                    <input type="number" id="fareAmount" name="fareAmount" step="0.01" min="0" required>
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="pickupLocation">Pickup Location *</label>
                    <input type="text" id="pickupLocation" name="pickupLocation" required>
                </div>

                <div class="form-group">
                    <label for="dropoffLocation">Dropoff Location *</label>
                    <input type="text" id="dropoffLocation" name="dropoffLocation" required>
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="bookingDate">Date & Time *</label>
                    <input type="datetime-local" id="bookingDate" name="bookingDate" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create Booking</button>
        </form>
    </div>
</div>

<!-- Bookings Table -->
<div class="card">
    <div class="card-header">
        <h2>All Bookings</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Route</th>
                    <th>Date/Time</th>
                    <th>Passengers</th>
                    <th>Fare</th>
                    <th>Driver</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td>#<?php echo $booking['bookingId']; ?></td>
                    <td><?php echo htmlspecialchars($booking['fullName']); ?></td>
                    <td><?php echo htmlspecialchars($booking['pickupLocation']); ?><br><small>→ <?php echo htmlspecialchars($booking['dropoffLocation']); ?></small></td>
                    <td><?php echo date('M d, Y H:i', strtotime($booking['bookingDate'])); ?></td>
                    <td><?php echo $booking['passengers']; ?></td>
                    <td>$<?php echo number_format($booking['fareAmount'], 2); ?></td>
                    <td><?php echo $booking['driverName'] ? htmlspecialchars($booking['driverName']) : '<em>Unassigned</em>'; ?></td>
                    <td>
                        <span class="badge <?php echo 'badge-' . $booking['status']; ?>">
                            <?php echo ucfirst($booking['status']); ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <?php if ($booking['status'] !== 'cancelled' && $booking['status'] !== 'completed'): ?>
                            <button type="button" class="btn-icon edit" onclick="cancelBooking(<?php echo $booking['bookingId']; ?>)" title="Cancel">❌</button>
                            <?php endif; ?>
                            <?php if ($booking['status'] === 'completed'): ?>
                            <button type="button" class="btn-icon download" onclick="generateInvoice(<?php echo $booking['bookingId']; ?>)" title="Invoice">📄</button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Customer Search
const customerSearchInput = document.getElementById('customerSearch');
const customerSuggestions = document.getElementById('customerSuggestions');

customerSearchInput.addEventListener('input', NBKTravel.debounce(async (e) => {
    const query = e.target.value;
    if (query.length < 2) {
        customerSuggestions.style.display = 'none';
        return;
    }

    const result = await NBKTravel.apiCall(`/api/customers.php?action=search&query=${encodeURIComponent(query)}`);
    if (result.success) {
        customerSuggestions.innerHTML = '';
        result.data.forEach(customer => {
            const div = document.createElement('div');
            div.style.cssText = 'padding: 8px 12px; cursor: pointer; border-bottom: 1px solid var(--border);';
            div.textContent = `${customer.fullName} (${customer.phoneNumber})`;
            div.onclick = () => {
                document.getElementById('customerId').value = customer.customerId;
                customerSearchInput.value = customer.fullName;
                customerSuggestions.style.display = 'none';
            };
            customerSuggestions.appendChild(div);
        });
        customerSuggestions.style.display = 'block';
    }
}, 300));

// Create Booking
document.getElementById('newBookingForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const customerId = document.getElementById('customerId').value;
    if (!customerId) {
        NBKTravel.showToast('Please select a customer', 'warning');
        return;
    }

    const data = {
        customerId: parseInt(customerId),
        pickupLocation: document.getElementById('pickupLocation').value,
        dropoffLocation: document.getElementById('dropoffLocation').value,
        bookingDate: document.getElementById('bookingDate').value,
        passengers: parseInt(document.getElementById('passengers').value),
        fareAmount: parseFloat(document.getElementById('fareAmount').value)
    };

    const result = await NBKTravel.apiCall('/api/bookings.php?action=create', 'POST', data);
    if (result.success) {
        NBKTravel.showToast('Booking created successfully', 'success');
        document.getElementById('newBookingForm').reset();
        setTimeout(() => location.reload(), 1500);
    } else {
        NBKTravel.showToast(result.message, 'error');
    }
});

function cancelBooking(bookingId) {
    const reason = prompt('Enter cancellation reason:');
    if (!reason) return;

    NBKTravel.apiCall('/api/bookings.php?action=cancel', 'POST', {
        bookingId: bookingId,
        reason: reason
    }).then(result => {
        if (result.success) {
            NBKTravel.showToast('Booking cancelled', 'success');
            location.reload();
        } else {
            NBKTravel.showToast(result.message, 'error');
        }
    });
}

function generateInvoice(bookingId) {
    NBKTravel.apiCall('/api/invoices.php?action=generate', 'POST', {
        bookingId: bookingId
    }).then(result => {
        if (result.success) {
            NBKTravel.showToast('Invoice generated', 'success');
            location.reload();
        } else {
            NBKTravel.showToast(result.message, 'error');
        }
    });
}
</script>

<?php require_once 'includes/footer.php'; ?>
