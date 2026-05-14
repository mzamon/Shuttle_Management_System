<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <h1 style="margin-bottom: 2rem;">Notifications</h1>
            
            <!-- Filter Controls -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Filter by Type</label>
                        <select id="notificationFilter" onchange="loadNotifications()">
                            <option value="">All Notifications</option>
                            <option value="SMS">SMS</option>
                            <option value="EMAIL">Email</option>
                            <option value="PUSH">Push Notification</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Filter by Status</label>
                        <select id="statusFilter" onchange="loadNotifications()">
                            <option value="">All Status</option>
                            <option value="SENT">Sent</option>
                            <option value="PENDING">Pending</option>
                            <option value="FAILED">Failed</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Search</label>
                        <input type="text" id="notificationSearch" placeholder="Search bookings or recipients..." onkeyup="filterNotifications()">
                    </div>
                </div>
            </div>
            
            <!-- Notifications List -->
            <div id="notificationsList">
                <div class="text-center" style="padding: 2rem;">Loading notifications...</div>
            </div>
        </div>
    </div>
    
    <!-- Notification Detail Modal -->
    <div id="notificationModal" class="modal">
        <div class="modal-content" style="width: 500px;">
            <div class="modal-header">
                <h2>Notification Details</h2>
                <button class="modal-close" onclick="notificationModal.hide()">&times;</button>
            </div>
            
            <div class="modal-body">
                <div style="margin-bottom: 1rem;">
                    <label>Booking Reference</label>
                    <p style="margin: 0; font-weight: bold;" id="notif-booking"></p>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label>Recipient</label>
                    <p style="margin: 0;" id="notif-recipient"></p>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label>Channel</label>
                    <p style="margin: 0;" id="notif-channel"></p>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label>Message</label>
                    <p style="margin: 0; padding: 1rem; background: rgba(255,255,255,0.1); border-radius: 0.5rem;" id="notif-message"></p>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label>Status</label>
                        <p style="margin: 0;" id="notif-status"></p>
                    </div>
                    <div>
                        <label>Sent Date</label>
                        <p style="margin: 0;" id="notif-date"></p>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="notificationModal.hide()">Close</button>
            </div>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        const notificationModal = new Modal('notificationModal');
        
        async function loadNotifications() {
            const channel = document.getElementById('notificationFilter').value;
            const status = document.getElementById('statusFilter').value;
            
            let url = 'GET /api/notifications?';
            if (channel) url += `channel=${channel}&`;
            if (status) url += `status=${status}`;
            
            // For demo, we'll simulate notifications from bookings
            const result = await apiCall('booking.php?action=list', 'GET');
            
            const notifsList = document.getElementById('notificationsList');
            notifsList.innerHTML = '';
            
            if (result.success && result.data.data.length > 0) {
                result.data.data.forEach((booking, index) => {
                    const channels = ['SMS', 'EMAIL', 'PUSH'];
                    const statuses = ['SENT', 'PENDING', 'FAILED'];
                    const channel = channels[index % channels.length];
                    const status = statuses[index % statuses.length];
                    
                    let statusBadge = `<span class="badge badge-${status === 'SENT' ? 'success' : status === 'PENDING' ? 'warning' : 'danger'}">${status}</span>`;
                    let channelBadge = `<span class="badge badge-primary" style="margin-left: 0.5rem;">${channel}</span>`;
                    
                    const notifCard = `
                        <div class="card" style="margin-bottom: 1rem; cursor: pointer; hover: rgba(255,255,255,0.1);" onclick="showNotificationDetail('${booking.bookingReference}', '${booking.fullName}', '${channel}', '${status}')">
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div style="flex: 1;">
                                    <p style="margin: 0; font-weight: bold; margin-bottom: 0.5rem;">Booking: ${booking.bookingReference}</p>
                                    <p style="margin: 0; color: rgba(255,255,255,0.7); margin-bottom: 0.5rem;">${booking.fullName}</p>
                                    <p style="margin: 0; color: rgba(255,255,255,0.6); font-size: 0.9rem;">Trip: ${booking.pickupLocation} → ${booking.dropoffLocation}</p>
                                </div>
                                <div style="text-align: right;">
                                    ${statusBadge}
                                    ${channelBadge}
                                    <p style="margin: 0.5rem 0 0 0; color: rgba(255,255,255,0.6); font-size: 0.85rem;">${new Date(booking.createdAt).toLocaleString()}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    notifsList.insertAdjacentHTML('beforeend', notifCard);
                });
            } else {
                notifsList.innerHTML = '<div class="text-center" style="padding: 2rem; color: rgba(255,255,255,0.6);">No notifications found</div>';
            }
        }
        
        function filterNotifications() {
            const query = document.getElementById('notificationSearch').value.toLowerCase();
            document.querySelectorAll('[data-notif-card]').forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(query) ? '' : 'none';
            });
        }
        
        function showNotificationDetail(booking, customer, channel, status) {
            document.getElementById('notif-booking').textContent = booking;
            document.getElementById('notif-recipient').textContent = customer;
            document.getElementById('notif-channel').textContent = channel;
            
            let message = '';
            if (channel === 'SMS') {
                message = `Hi ${customer}, your booking ${booking} has been confirmed. Pickup: Tomorrow at 08:00 AM. Reply CONFIRM to acknowledge.`;
            } else if (channel === 'EMAIL') {
                message = `Dear ${customer},\n\nYour booking ${booking} has been confirmed.\n\nBooking Details:\n- Route: Various\n- Status: Confirmed\n\nPlease check your dashboard for more details.`;
            } else {
                message = `Booking ${booking} confirmation notification. Tap to view details.`;
            }
            
            document.getElementById('notif-message').textContent = message;
            document.getElementById('notif-status').textContent = status;
            document.getElementById('notif-date').textContent = new Date().toLocaleString();
            
            notificationModal.show();
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            loadNotifications();
        });
    </script>
</body>
</html>
