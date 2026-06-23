<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

$bookingsStmt = $conn->prepare(
    "SELECT b.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation,
            b.bookingDate, b.passengers, b.fareAmount, b.status,
            d.fullName as driverName, v.registrationNumber
     FROM bookings b
     JOIN customers c ON b.customerId = c.customerId
     LEFT JOIN drivers d ON b.driverId = d.driverId
     LEFT JOIN vehicles v ON b.vehicleId = v.vehicleId
     ORDER BY b.bookingDate DESC"
);
$bookingsStmt->execute();
$bookings = $bookingsStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$bookingsStmt->close();

require_once 'includes/header.php';
?>

<div class="page-header">
    <div class="ph-text">
        <h1>Bookings</h1>
        <p>Create and manage all shuttle bookings</p>
    </div>
</div>

<div class="card">
    <div class="card-header"><h2>Create New Booking</h2></div>
    <div class="card-body">
        <form id="newBookingForm">
            <div class="form-row">
                <div class="form-group" style="position:relative;">
                    <label>Customer *</label>
                    <input type="hidden" id="customerId" name="customerId" required>
                    <div class="autocomplete-wrap">
                        <input type="text" id="customerSearch" placeholder="Search by name or phone…" autocomplete="off" required>
                        <div id="customerSuggestions" class="autocomplete-list"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Passengers *</label>
                    <input type="number" id="passengers" name="passengers" min="1" max="20" value="1" required>
                </div>
                <div class="form-group">
                    <label>Fare Amount (R) *</label>
                    <input type="number" id="fareAmount" name="fareAmount" step="0.01" min="0" placeholder="0.00" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Pickup Location *</label>
                    <input type="text" id="pickupLocation" name="pickupLocation" placeholder="e.g. O.R. Tambo Airport" required>
                </div>
                <div class="form-group">
                    <label>Dropoff Location *</label>
                    <input type="text" id="dropoffLocation" name="dropoffLocation" placeholder="e.g. Sandton City" required>
                </div>
            </div>
            <div class="form-row full">
                <div class="form-group">
                    <label>Date & Time *</label>
                    <input type="datetime-local" id="bookingDate" name="bookingDate" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Create Booking
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>All Bookings</h2>
        <span class="card-header-meta"><?= count($bookings) ?> records</span>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>ID</th><th>Customer</th><th>Route</th><th>Date / Time</th><th>Pax</th><th>Fare</th><th>Driver</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><span style="color:var(--smoke);font-size:11px;">#</span><?= $b['bookingId'] ?></td>
                        <td><strong><?= htmlspecialchars($b['fullName']) ?></strong></td>
                        <td>
                            <div class="route-from"><?= htmlspecialchars($b['pickupLocation']) ?></div>
                            <div class="route-to"><svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg><?= htmlspecialchars($b['dropoffLocation']) ?></div>
                        </td>
                        <td><?= date('d M Y', strtotime($b['bookingDate'])) ?><br><small style="color:var(--smoke);"><?= date('H:i', strtotime($b['bookingDate'])) ?></small></td>
                        <td><?= $b['passengers'] ?></td>
                        <td>R<?= number_format($b['fareAmount'], 2) ?></td>
                        <td><?= $b['driverName'] ? htmlspecialchars($b['driverName']) : '<span style="color:var(--smoke);font-style:italic;">Unassigned</span>' ?></td>
                        <td><span class="badge badge-<?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></td>
                        <td>
                            <div class="action-btns">
                                <?php if (!in_array($b['status'], ['cancelled','completed'])): ?>
                                <button class="btn-icon danger" onclick="cancelBooking(<?= $b['bookingId'] ?>)" title="Cancel"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></button>
                                <?php endif; ?>
                                <?php if ($b['status'] === 'completed'): ?>
                                <button class="btn-icon success" onclick="generateInvoice(<?= $b['bookingId'] ?>)" title="Invoice"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($bookings)): ?>
                    <tr><td colspan="9" style="text-align:center;padding:40px;color:var(--smoke);">No bookings yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const customerSearch = document.getElementById('customerSearch');
const suggestions = document.getElementById('customerSuggestions');

customerSearch.addEventListener('input', NBKTravel.debounce(async (e) => {
    const q = e.target.value.trim();
    if (q.length < 2) { suggestions.style.display = 'none'; return; }
    const res = await NBKTravel.apiCall('api/customers.php?action=search&query=' + encodeURIComponent(q));
    if (res.success && res.data.length) {
        suggestions.innerHTML = res.data.map(c =>
            `<div class="ac-item" onclick="selectCustomer(${c.customerId},'${c.fullName.replace(/'/g,"\\'")}')">
                <strong>${c.fullName}</strong><small>${c.phoneNumber}</small>
            </div>`
        ).join('');
        suggestions.style.display = 'block';
    } else {
        suggestions.innerHTML = '<div class="ac-item" style="cursor:default;color:var(--smoke);">No results</div>';
        suggestions.style.display = 'block';
    }
}, 280));

function selectCustomer(id, name) {
    document.getElementById('customerId').value = id;
    customerSearch.value = name;
    suggestions.style.display = 'none';
}
document.addEventListener('click', (e) => {
    if (!e.target.closest('#customerSearch') && !e.target.closest('#customerSuggestions')) {
        suggestions.style.display = 'none';
    }
});

document.getElementById('newBookingForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const customerId = document.getElementById('customerId').value;
    if (!customerId) return NBKTravel.showToast('Please select a customer', 'warning');
    const data = {
        customerId: parseInt(customerId),
        pickupLocation: document.getElementById('pickupLocation').value,
        dropoffLocation: document.getElementById('dropoffLocation').value,
        bookingDate: document.getElementById('bookingDate').value,
        passengers: parseInt(document.getElementById('passengers').value),
        fareAmount: parseFloat(document.getElementById('fareAmount').value)
    };
    const btn = e.target.querySelector('button[type=submit]');
    btn.disabled = true; btn.textContent = 'Creating…';
    const res = await NBKTravel.apiCall('api/bookings.php?action=create', 'POST', data);
    if (res.success) {
        NBKTravel.showToast('Booking created', 'success');
        e.target.reset();
        document.getElementById('customerId').value = '';
        setTimeout(() => location.reload(), 1500);
    } else {
        NBKTravel.showToast(res.message || 'Error', 'error');
        btn.disabled = false; btn.textContent = 'Create Booking';
    }
});

async function cancelBooking(id) {
    const reason = prompt('Cancellation reason:');
    if (!reason || !reason.trim()) return;
    const res = await NBKTravel.apiCall('api/bookings.php?action=cancel', 'POST', { bookingId: id, reason });
    if (res.success) { NBKTravel.showToast('Cancelled', 'success'); setTimeout(() => location.reload(), 1400); }
    else NBKTravel.showToast(res.message, 'error');
}

async function generateInvoice(id) {
    const res = await NBKTravel.apiCall('api/invoices.php?action=generate', 'POST', { bookingId: id });
    if (res.success) { NBKTravel.showToast('Invoice generated', 'success'); setTimeout(() => location.reload(), 1400); }
    else NBKTravel.showToast(res.message, 'error');
}
</script>

<?php require_once 'includes/footer.php'; ?>
