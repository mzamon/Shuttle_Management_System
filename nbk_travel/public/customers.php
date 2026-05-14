<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1>Customer Management</h1>
                <button class="btn btn-primary" onclick="document.getElementById('newCustomerModal').style.display='flex';">+ New Customer</button>
            </div>
            
            <!-- Search -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="form-group">
                    <input type="text" id="customerSearch" placeholder="Search by name, phone, or email..." onkeyup="searchCustomers()">
                </div>
            </div>
            
            <!-- Customers List -->
            <div class="grid grid-2" id="customersGrid">
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem;">Loading...</div>
            </div>
        </div>
    </div>
    
    <!-- New Customer Modal -->
    <div id="newCustomerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Customer</h3>
                <button class="modal-close" onclick="this.closest('.modal').style.display='none'">×</button>
            </div>
            
            <form id="newCustomerForm">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullName" required>
                    <span class="form-error"></span>
                </div>
                
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phoneNumber" placeholder="+27..." required>
                    <span class="form-error"></span>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="emailAddress">
                    <span class="form-error"></span>
                </div>
                
                <div class="form-group">
                    <label>Preferences</label>
                    <textarea name="preferences" placeholder="Travel preferences..."></textarea>
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Customer</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Customer Details Modal -->
    <div id="customerDetailsModal" class="modal">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3 id="customerName"></h3>
                <button class="modal-close" onclick="this.closest('.modal').style.display='none'">×</button>
            </div>
            
            <div id="customerDetails"></div>
            
            <div style="margin-top: 1.5rem; border-top: 1px solid var(--glass-border); padding-top: 1rem;">
                <h4>Booking History</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Route</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="bookingHistory"></tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        async function loadCustomers() {
            const result = await apiCall('customer.php?action=search&q=@', 'GET');
            
            const grid = document.getElementById('customersGrid');
            grid.innerHTML = '';
            
            if (result.success) {
                result.data.forEach(customer => {
                    const card = `
                        <div class="card">
                            <div class="card-header">
                                <h4>${customer.fullName}</h4>
                                <span class="badge badge-primary">${customer.totalBookings || 0} trips</span>
                            </div>
                            <div class="card-body">
                                <p><strong>Phone:</strong> ${customer.phoneNumber}</p>
                                <p><strong>Email:</strong> ${customer.emailAddress || 'N/A'}</p>
                                <p><strong>Total Spent:</strong> ${formatCurrency(customer.totalSpent || 0)}</p>
                                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 1rem;">
                                    Member since: ${new Date(customer.createdAt).toLocaleDateString()}
                                </p>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-small btn-primary" onclick="viewCustomer(${customer.customerId})">View Details</button>
                            </div>
                        </div>
                    `;
                    grid.insertAdjacentHTML('beforeend', card);
                });
            } else {
                grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center;">No customers found</div>';
            }
        }
        
        async function searchCustomers() {
            const query = document.getElementById('customerSearch').value;
            if (query.length < 1) {
                loadCustomers();
                return;
            }
            
            const result = await apiCall(`customer.php?action=search&q=${encodeURIComponent(query)}`, 'GET');
            
            const grid = document.getElementById('customersGrid');
            grid.innerHTML = '';
            
            if (result.success) {
                result.data.forEach(customer => {
                    const card = `
                        <div class="card">
                            <div class="card-header">
                                <h4>${customer.fullName}</h4>
                                <span class="badge badge-primary">${customer.totalBookings || 0} trips</span>
                            </div>
                            <div class="card-body">
                                <p><strong>Phone:</strong> ${customer.phoneNumber}</p>
                                <p><strong>Email:</strong> ${customer.emailAddress || 'N/A'}</p>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-small btn-primary" onclick="viewCustomer(${customer.customerId})">View Details</button>
                            </div>
                        </div>
                    `;
                    grid.insertAdjacentHTML('beforeend', card);
                });
            }
        }
        
        async function viewCustomer(customerId) {
            const result = await apiCall(`customer.php?action=view&id=${customerId}`, 'GET');
            
            if (result.success) {
                const customer = result.data;
                document.getElementById('customerName').textContent = customer.fullName;
                
                const details = `
                    <div class="card-body">
                        <p><strong>Phone:</strong> ${customer.phoneNumber}</p>
                        <p><strong>Email:</strong> ${customer.emailAddress || 'N/A'}</p>
                        <p><strong>Preferences:</strong> ${customer.preferences || 'None'}</p>
                        <p><strong>Total Bookings:</strong> ${customer.totalBookings || 0}</p>
                        <p><strong>Total Spent:</strong> ${formatCurrency(customer.totalSpent || 0)}</p>
                        <p><strong>Member Since:</strong> ${new Date(customer.createdAt).toLocaleDateString()}</p>
                    </div>
                `;
                document.getElementById('customerDetails').innerHTML = details;
                
                const historyTable = document.getElementById('bookingHistory');
                historyTable.innerHTML = '';
                
                if (customer.bookingHistory && customer.bookingHistory.length > 0) {
                    customer.bookingHistory.forEach(booking => {
                        const row = `
                            <tr>
                                <td>${booking.bookingReference}</td>
                                <td>${new Date(booking.bookingDate).toLocaleDateString()}</td>
                                <td>${booking.pickupLocation} → ${booking.dropoffLocation}</td>
                                <td>${formatCurrency(booking.fareAmount)}</td>
                                <td><span class="badge badge-primary">${booking.status}</span></td>
                            </tr>
                        `;
                        historyTable.insertAdjacentHTML('beforeend', row);
                    });
                } else {
                    historyTable.innerHTML = '<tr><td colspan="5" class="text-center">No bookings yet</td></tr>';
                }
                
                document.getElementById('customerDetailsModal').style.display = 'flex';
            }
        }
        
        document.getElementById('newCustomerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(document.getElementById('newCustomerForm'));
            const data = {
                action: 'create',
                fullName: formData.get('fullName'),
                phoneNumber: formData.get('phoneNumber'),
                emailAddress: formData.get('emailAddress'),
                preferences: formData.get('preferences')
            };
            
            const result = await apiCall('customer.php', 'POST', data);
            
            if (result.success) {
                showToast('success', 'Customer added successfully');
                document.getElementById('newCustomerModal').style.display = 'none';
                document.getElementById('newCustomerForm').reset();
                loadCustomers();
            }
        });
        
        document.addEventListener('DOMContentLoaded', () => {
            loadCustomers();
        });
    </script>
</body>
</html>
