<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <h1 style="margin-bottom: 2rem;">Invoice Management</h1>
            
            <!-- Search -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="form-group">
                    <input type="text" id="invoiceSearch" placeholder="Search by booking reference or customer..." onkeyup="searchInvoices()">
                </div>
            </div>
            
            <!-- Invoices Table -->
            <div class="card">
                <table id="invoicesTable">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Booking Ref</th>
                            <th>Customer</th>
                            <th>Subtotal</th>
                            <th>Tax</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="invoicesBody">
                        <tr><td colspan="9" class="text-center">Loading invoices...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Invoice Template (for PDF) -->
    <div id="invoiceTemplate" style="display: none; background: white; color: black; padding: 2rem; font-family: Arial, sans-serif;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1>NBK TRAVEL</h1>
            <p>Shuttle Booking Management System</p>
            <p>South Africa</p>
        </div>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: 2rem;">
            <div>
                <h3>Invoice</h3>
                <p><strong>Invoice Number:</strong> <span id="tpl-invoiceNum"></span></p>
                <p><strong>Date:</strong> <span id="tpl-date"></span></p>
            </div>
            <div style="text-align: right;">
                <p><strong>Booking Reference:</strong> <span id="tpl-bookingRef"></span></p>
            </div>
        </div>
        
        <div style="margin-bottom: 2rem;">
            <h4>Bill To:</h4>
            <p><strong id="tpl-customer"></strong></p>
            <p>Phone: <span id="tpl-phone"></span></p>
            <p>Email: <span id="tpl-email"></span></p>
        </div>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid black;">
                    <th style="text-align: left; padding: 0.5rem;">Description</th>
                    <th style="text-align: right; padding: 0.5rem;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 0.5rem;">Shuttle Transport Service</td>
                    <td style="text-align: right; padding: 0.5rem;"><strong id="tpl-subtotal"></strong></td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin-top: 1rem; text-align: right;">
            <table style="width: 40%; margin-left: auto;">
                <tr>
                    <td style="padding: 0.5rem;">Subtotal:</td>
                    <td style="text-align: right; padding: 0.5rem;"><span id="tpl-subtotalTotal"></span></td>
                </tr>
                <tr>
                    <td style="padding: 0.5rem;">VAT (15%):</td>
                    <td style="text-align: right; padding: 0.5rem;"><span id="tpl-tax"></span></td>
                </tr>
                <tr style="border-top: 2px solid black; border-bottom: 2px solid black;">
                    <td style="padding: 0.5rem;"><strong>Total Due:</strong></td>
                    <td style="text-align: right; padding: 0.5rem;"><strong id="tpl-total"></strong></td>
                </tr>
            </table>
        </div>
        
        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #ccc; font-size: 0.9rem; color: #666;">
            <p>Thank you for your business!</p>
            <p>Payment Terms: Due upon receipt</p>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        async function loadInvoices() {
            // For demo, we'll load completed bookings and treat them as invoices
            const result = await apiCall('booking.php?action=list&status=completed', 'GET');
            
            const tbody = document.getElementById('invoicesBody');
            tbody.innerHTML = '';
            
            if (result.success) {
                result.data.data.forEach(booking => {
                    const tax = booking.fareAmount * 0.15;
                    const total = booking.fareAmount + tax;
                    const invoice = `
                        <tr>
                            <td>INV-${booking.bookingId}</td>
                            <td>${booking.bookingReference}</td>
                            <td>${booking.fullName}</td>
                            <td>${formatCurrency(booking.fareAmount)}</td>
                            <td>${formatCurrency(tax)}</td>
                            <td>${formatCurrency(total)}</td>
                            <td>${new Date(booking.createdAt).toLocaleDateString()}</td>
                            <td><span class="badge badge-success">Issued</span></td>
                            <td>
                                <button class="btn btn-small btn-primary" onclick="generatePDF(${booking.bookingId})">Download PDF</button>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', invoice);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="9" class="text-center">No invoices found</td></tr>';
            }
        }
        
        function searchInvoices() {
            const query = document.getElementById('invoiceSearch').value.toLowerCase();
            const table = document.getElementById('invoicesTable');
            table.querySelectorAll('tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        }
        
        async function generatePDF(bookingId) {
            const booking = await apiCall(`booking.php?action=view&id=${bookingId}`, 'GET');
            
            if (!booking.success) {
                showToast('error', 'Failed to load booking');
                return;
            }
            
            const b = booking.data;
            const tax = b.fareAmount * 0.15;
            const total = b.fareAmount + tax;
            
            document.getElementById('tpl-invoiceNum').textContent = `INV-${b.bookingId}`;
            document.getElementById('tpl-date').textContent = new Date(b.createdAt).toLocaleDateString();
            document.getElementById('tpl-bookingRef').textContent = b.bookingReference;
            document.getElementById('tpl-customer').textContent = b.fullName;
            document.getElementById('tpl-phone').textContent = b.phoneNumber;
            document.getElementById('tpl-email').textContent = b.email || 'N/A';
            document.getElementById('tpl-subtotal').textContent = formatCurrency(b.fareAmount);
            document.getElementById('tpl-subtotalTotal').textContent = formatCurrency(b.fareAmount);
            document.getElementById('tpl-tax').textContent = formatCurrency(tax);
            document.getElementById('tpl-total').textContent = formatCurrency(total);
            
            const element = document.getElementById('invoiceTemplate');
            const opt = {
                margin: 10,
                filename: `Invoice-${b.bookingReference}.pdf`,
                image: { type: 'png', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { orientation: 'portrait', unit: 'mm', format: 'a4' }
            };
            
            html2pdf().set(opt).from(element).save();
            showToast('success', 'Invoice downloaded');
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            loadInvoices();
        });
    </script>
</body>
</html>
