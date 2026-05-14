<?php
/**
 * Invoices Generator Page
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

// Get pending completed bookings
$stmt = $conn->prepare("SELECT b.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation, b.bookingDate, b.fareAmount FROM bookings b JOIN customers c ON b.customerId = c.customerId WHERE b.status = 'completed' AND b.bookingId NOT IN (SELECT DISTINCT bookingId FROM invoices) ORDER BY b.bookingDate DESC");
$stmt->execute();
$result = $stmt->get_result();
$pendingBookings = [];
while ($row = $result->fetch_assoc()) {
    $pendingBookings[] = $row;
}
$stmt->close();

// Get generated invoices
$invoicesStmt = $conn->prepare("SELECT i.invoiceId, i.bookingId, c.fullName, b.pickupLocation, b.dropoffLocation, i.invoiceDate, i.totalAmount FROM invoices i JOIN bookings b ON i.bookingId = b.bookingId JOIN customers c ON i.customerId = c.customerId ORDER BY i.invoiceDate DESC LIMIT 20");
$invoicesStmt->execute();
$invoicesResult = $invoicesStmt->get_result();
$invoices = [];
while ($row = $invoicesResult->fetch_assoc()) {
    $invoices[] = $row;
}
$invoicesStmt->close();

require_once 'includes/header.php';
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<div class="page-header">
    <h1>Invoice Generator</h1>
    <p>Generate and manage customer invoices</p>
</div>

<!-- Generate Invoice -->
<div class="card">
    <div class="card-header">
        <h2>Generate New Invoice</h2>
    </div>
    <div class="card-body">
        <form id="invoiceForm" class="form-wrapper">
            <div class="form-group full">
                <label for="bookingId">Select Completed Booking *</label>
                <select id="bookingId" required onchange="previewInvoice()">
                    <option value="">-- Select Booking --</option>
                    <?php foreach ($pendingBookings as $booking): ?>
                    <option value="<?php echo $booking['bookingId']; ?>">
                        #<?php echo $booking['bookingId']; ?> - <?php echo htmlspecialchars($booking['fullName']); ?> (<?php echo date('M d, Y', strtotime($booking['bookingDate'])); ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Generate Invoice</button>
        </form>
    </div>
</div>

<!-- Invoice Preview -->
<div id="invoicePreview" style="display: none;">
    <div class="invoice-preview" style="background: white; color: black; padding: 40px; border: 1px solid #ddd; page-break-after: always;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="color: #0a0f1e; margin: 0;">🚐 NBK Travel</h1>
            <p style="color: #666; margin: 8px 0 0 0;">Shuttle Booking Management System</p>
        </div>

        <table style="width: 100%; margin-bottom: 40px;">
            <tr>
                <td>
                    <strong>Invoice #:</strong> <span id="invoiceNumber"></span><br>
                    <strong>Date:</strong> <span id="invoiceDate"></span>
                </td>
                <td style="text-align: right;">
                    <strong>Bill To:</strong><br>
                    <span id="customerName"></span><br>
                    <span id="customerPhone"></span><br>
                    <span id="customerEmail"></span>
                </td>
            </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 40px;">
            <thead>
                <tr style="background: #f0f0f0; border-bottom: 2px solid #333;">
                    <th style="padding: 12px; text-align: left;">Description</th>
                    <th style="padding: 12px; text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 12px;">
                        <strong>Trip:</strong> <span id="tripRoute"></span><br>
                        <small id="tripDateTime"></small>
                    </td>
                    <td style="padding: 12px; text-align: right;" id="tripFare"></td>
                </tr>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 12px; text-align: right;"><strong>Subtotal:</strong></td>
                    <td style="padding: 12px; text-align: right;" id="subtotal"></td>
                </tr>
                <tr style="border-bottom: 2px solid #333;">
                    <td style="padding: 12px; text-align: right;"><strong>Tax (15%):</strong></td>
                    <td style="padding: 12px; text-align: right;" id="taxAmount"></td>
                </tr>
                <tr>
                    <td style="padding: 12px; text-align: right;"><strong style="font-size: 16px;">TOTAL:</strong></td>
                    <td style="padding: 12px; text-align: right; font-size: 16px; font-weight: bold;" id="totalAmount"></td>
                </tr>
            </tbody>
        </table>

        <div style="border-top: 1px solid #ddd; padding-top: 20px; text-align: center; color: #666; font-size: 12px;">
            <p>Thank you for using NBK Travel! Safe travels!</p>
            <p>For inquiries: info@nbktravel.co.za | +27 (0) 123 456 7890</p>
        </div>
    </div>

    <div style="margin-top: 24px; display: flex; gap: 12px;">
        <button class="btn btn-primary" onclick="downloadInvoicePDF()">📥 Download PDF</button>
        <button class="btn btn-secondary" onclick="saveToDB()">💾 Save Invoice</button>
    </div>
</div>

<!-- Generated Invoices -->
<div class="card">
    <div class="card-header">
        <h2>Generated Invoices</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Booking ID</th>
                    <th>Customer</th>
                    <th>Route</th>
                    <th>Date</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $invoice): ?>
                <tr>
                    <td>#<?php echo $invoice['invoiceId']; ?></td>
                    <td>#<?php echo $invoice['bookingId']; ?></td>
                    <td><?php echo htmlspecialchars($invoice['fullName']); ?></td>
                    <td><?php echo htmlspecialchars($invoice['pickupLocation']); ?> → <?php echo htmlspecialchars($invoice['dropoffLocation']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($invoice['invoiceDate'])); ?></td>
                    <td>$<?php echo number_format($invoice['totalAmount'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
let currentBooking = null;

async function previewInvoice() {
    const bookingId = document.getElementById('bookingId').value;
    if (!bookingId) return;

    // Get booking details (in real app, would fetch from API)
    const bookingSelect = document.getElementById('bookingId');
    const selectedOption = bookingSelect.options[bookingSelect.selectedIndex];
    
    const option = Array.from(document.getElementById('bookingId').options)
        .find(opt => opt.value === bookingId);

    // For demo, use hardcoded customer name from option
    const customerName = option.text.split(' - ')[1].split(' (')[0];

    // Populate preview (would normally fetch real data)
    document.getElementById('invoiceNumber').textContent = 'NBK-' + bookingId + '-' + new Date().getFullYear();
    document.getElementById('invoiceDate').textContent = new Date().toLocaleDateString();
    document.getElementById('customerName').textContent = customerName;
    document.getElementById('customerPhone').textContent = '+27 (0) 123 456 7890';
    document.getElementById('customerEmail').textContent = 'customer@email.com';
    document.getElementById('tripRoute').textContent = 'Shuttle Transfer';
    document.getElementById('tripDateTime').textContent = option.text;

    // Calculate amounts (hardcoded for demo)
    const fare = 150; // Would come from booking
    const tax = fare * 0.15;
    const total = fare + tax;

    document.getElementById('tripFare').textContent = '$' + fare.toFixed(2);
    document.getElementById('subtotal').textContent = '$' + fare.toFixed(2);
    document.getElementById('taxAmount').textContent = '$' + tax.toFixed(2);
    document.getElementById('totalAmount').textContent = '$' + total.toFixed(2);

    document.getElementById('invoicePreview').style.display = 'block';
}

function downloadInvoicePDF() {
    const element = document.querySelector('.invoice-preview');
    const opt = {
        margin: 10,
        filename: 'NBK-Invoice-' + document.getElementById('bookingId').value + '.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, backgroundColor: '#ffffff' },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(element).save();
}

async function saveToDB() {
    const bookingId = parseInt(document.getElementById('bookingId').value);
    
    const result = await NBKTravel.apiCall('/api/invoices.php?action=generate', 'POST', {
        bookingId: bookingId
    });

    if (result.success) {
        NBKTravel.showToast('Invoice saved successfully', 'success');
        setTimeout(() => location.reload(), 1500);
    } else {
        NBKTravel.showToast(result.message, 'error');
    }
}

document.getElementById('invoiceForm').addEventListener('submit', (e) => {
    e.preventDefault();
    downloadInvoicePDF();
});
</script>

<?php require_once 'includes/footer.php'; ?>
