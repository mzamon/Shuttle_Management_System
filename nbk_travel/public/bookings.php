<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1>Bookings Management</h1>
                <button class="btn btn-primary" onclick="document.getElementById('newBookingModal').querySelector('.modal-content').style.display='block'; document.getElementById('newBookingModal').style.display='flex';">+ New Booking</button>
            </div>
            
            <!-- Filters -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="grid grid-3" style="gap: 1rem;">
                    <div class="form-group">
                        <label>Status Filter</label>
                        <select id="statusFilter" onchange="loadBookings()">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Search</label>
                        <input type="text" id="searchInput" placeholder="Search bookings..." onkeyup="filterBookingsTable()">
                    </div>
                    
                    <div>
                        <label>&nbsp;</label>
                        <button class="btn btn-secondary btn-block" onclick="exportTableToCSV('bookingsTable', 'bookings.csv')">Export CSV</button>
                    </div>
                </div>
            </div>
            
            <!-- Bookings Table -->
            <div class="card">
                <table id="bookingsTable">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Customer</th>
                            <th>Pickup → Dropoff</th>
                            <th>Date/Time</th>
                            <th>Passengers</th>
                            <th>Fare</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="bookingsBody">
                        <tr><td colspan="8" class="text-center">Loading...</td></tr>
                    </tbody>
                </table>
                
                <div id="pagination" style="margin-top: 1.5rem; text-align: center;">
                    <!-- Pagination controls will be added here -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- New Booking Modal -->
    <div id="newBookingModal" class="modal">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3>Create New Booking</h3>
                <button class="modal-close" onclick="this.closest('.modal').style.display='none'">×</button>
            </div>
            
            <form id="newBookingForm">
                <div class="form-group">
                    <label>Customer</label>
                    <input type="text" id="customerSearch" placeholder="Search customer by name or phone..." autocomplete="off">
                    <div id="customerList" style="max-height: 200px; overflow-y: auto; margin-top: 0.5rem;"></div>
                    <input type="hidden" id="customerId" name="customerId">
                    <span class="form-error"></span>
                </div>
                
                <div class="grid grid-2">
                    <div class="form-group">
                        <label>Pickup Location</label>
                        <input type="text" name="pickup" placeholder="e.g. OR Tambo Airport" required>
                        <span class="form-error"></span>
                    </div>
                    
                    <div class="form-group">
                        <label>Drop-off Location</label>
                        <input type="text" name="dropoff" placeholder="e.g. Sandton" required>
                        <span class="form-error"></span>
                    </div>
                </div>
                
                <div class="grid grid-2">
                    <div class="form-group">
                        <label>Booking Date & Time</label>
                        <input type="datetime-local" name="bookingDate" required>
                        <span class="form-error"></span>
                    </div>
                    
                    <div class="form-group">
                        <label>Passengers</label>
                        <input type="number" name="passengers" min="1" max="15" value="1" required>
                        <span class="form-error"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Fare (R)</label>
                    <input type="number" name="fare" min="100" step="10" placeholder="Minimum R100" required>
                    <span class="form-error"></span>
                </div>
                
                <div class="form-group">
                    <label>Notes</label>
                    <textarea name="notes" placeholder="Special requests, etc."></textarea>
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" class="btn btn-secondary" onclick="this.closest('.modal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Booking</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        let currentPage = 1;
        
        async function loadBookings(page = 1) {
            currentPage = page;
            const status = document.getElementById('statusFilter').value;
            const result = await apiCall(`booking.php?action=list&page=${page}&status=${status}`, 'GET');
            
            if (result.success) {
                const tbody = document.getElementById('bookingsBody');
                tbody.innerHTML = '';
                
                result.data.data.forEach(booking => {
                    const statusBadge = `<span class="badge badge-${getStatusColor(booking.status)}">${booking.status}</span>`;
                    const row = `
                        <tr>
                            <td><strong>${booking.bookingReference}</strong></td>
                            <td>${booking.fullName}</td>
                            <td>${booking.pickupLocation} → ${booking.dropoffLocation}</td>
                            <td>${new Date(booking.bookingDate).toLocaleString()}</td>
                            <td>${booking.passengers}</td>
                            <td>${formatCurrency(booking.fareAmount)}</td>
                            <td>${statusBadge}</td>
                            <td>
                                <button class="btn btn-small btn-primary" onclick="editBooking(${booking.bookingId})">Edit</button>
                                ${booking.status !== 'completed' ? `<button class="btn btn-small btn-danger" onclick="cancelBooking(${booking.bookingId})">Cancel</button>` : ''}
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
                
                // Pagination
                const paginationHtml = `
                    ${page > 1 ? `<button class="btn btn-small" onclick="loadBookings(${page - 1})">Previous</button>` : ''}
                    <span style="margin: 0 1rem;">Page ${page} of ${result.data.pages}</span>
                    ${page < result.data.pages ? `<button class="btn btn-small" onclick="loadBookings(${page + 1})">Next</button>` : ''}
                `;
                document.getElementById('pagination').innerHTML = paginationHtml;
            }
        }
        
        function getStatusColor(status) {
            const colors = {
                'pending': 'info',
                'confirmed': 'success',
                'completed': 'primary',
                'cancelled': 'danger'
            };
            return colors[status] || 'primary';
        }
        
        function filterBookingsTable() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const table = document.getElementById('bookingsTable');
            table.querySelectorAll('tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? '' : 'none';
            });
        }
        
        async function cancelBooking(bookingId) {
            confirm('Are you sure you want to cancel this booking?', async () => {
                const reason = prompt('Enter cancellation reason:');
                if (!reason) return;
                
                const result = await apiCall('booking.php', 'POST', {
                    action: 'cancel',
                    bookingId: bookingId,
                    reason: reason
                });
                
                if (result.success) {
                    showToast('success', 'Booking cancelled successfully');
                    loadBookings();
                }
            });
        }
        
        // Customer search
        document.getElementById('customerSearch').addEventListener('keyup', async (e) => {
            const query = e.target.value;
            if (query.length < 2) return;
            
            const result = await apiCall(`customer.php?action=search&q=${encodeURIComponent(query)}`, 'GET');
            
            const list = document.getElementById('customerList');
            list.innerHTML = '';
            
            if (result.success) {
                result.data.forEach(customer => {
                    const item = document.createElement('div');
                    item.style.cssText = 'padding: 0.5rem; background: rgba(59, 130, 246, 0.1); border-radius: 4px; cursor: pointer; margin-bottom: 0.25rem;';
                    item.textContent = `${customer.fullName} - ${customer.phoneNumber}`;
                    item.onclick = () => {
                        document.getElementById('customerId').value = customer.customerId;
                        document.getElementById('customerSearch').value = customer.fullName;
                        list.innerHTML = '';
                    };
                    list.appendChild(item);
                });
            }
        });
        
        // Form submission
        document.getElementById('newBookingForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const rules = {
                customerId: [Validator.required],
                pickup: [Validator.required],
                dropoff: [Validator.required],
                bookingDate: [Validator.required],
                passengers: [Validator.numeric],
                fare: [Validator.numeric]
            };
            
            const validation = validateForm('newBookingForm', rules);
            if (!validation.isValid) return;
            
            const formData = new FormData(document.getElementById('newBookingForm'));
            const data = {
                action: 'create',
                customerId: document.getElementById('customerId').value,
                pickup: formData.get('pickup'),
                dropoff: formData.get('dropoff'),
                bookingDate: formData.get('bookingDate') + ':00',
                passengers: formData.get('passengers'),
                fare: formData.get('fare'),
                notes: formData.get('notes')
            };
            
            const result = await apiCall('booking.php', 'POST', data);
            
            if (result.success) {
                showToast('success', 'Booking created successfully');
                document.getElementById('newBookingModal').style.display = 'none';
                document.getElementById('newBookingForm').reset();
                loadBookings();
            }
        });
        
        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            loadBookings();
        });
    </script>
</body>
</html>
