<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Trips - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <h1 style="margin-bottom: 2rem;">My Assigned Trips</h1>
            
            <!-- Trip List -->
            <div id="tripsList">
                <div class="text-center" style="padding: 2rem;">Loading trips...</div>
            </div>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        async function loadTrips() {
            // Get current user (driver) ID from session - in real scenario
            // For demo, we'll use a hardcoded driver ID
            const driverId = 1;
            
            const result = await apiCall(`driver.php?action=trips&id=${driverId}`, 'GET');
            
            const container = document.getElementById('tripsList');
            container.innerHTML = '';
            
            if (result.success && result.data.length > 0) {
                result.data.forEach(trip => {
                    const card = `
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h4>${trip.bookingReference}</h4>
                                    <p style="color: var(--text-secondary); font-size: 0.9rem;">
                                        ${new Date(trip.bookingDate).toLocaleString()}
                                    </p>
                                </div>
                                <span class="badge badge-${trip.status === 'completed' ? 'success' : trip.status === 'confirmed' ? 'info' : 'warning'}">${trip.status}</span>
                            </div>
                            
                            <div class="card-body">
                                <div class="grid grid-2" style="gap: 1rem; margin: 1rem 0;">
                                    <div>
                                        <strong>Pickup:</strong>
                                        <p>${trip.pickupLocation}</p>
                                    </div>
                                    <div>
                                        <strong>Drop-off:</strong>
                                        <p>${trip.dropoffLocation}</p>
                                    </div>
                                </div>
                                
                                <p><strong>Customer:</strong> ${trip.fullName}</p>
                                <p><strong>Phone:</strong> ${trip.phoneNumber}</p>
                                <p><strong>Passengers:</strong> ${trip.passengers}</p>
                                <p><strong>Vehicle:</strong> ${trip.registrationNumber}</p>
                                <p><strong>Fare:</strong> ${formatCurrency(trip.fareAmount)}</p>
                                
                                ${trip.notes ? `<p><strong>Notes:</strong> ${trip.notes}</p>` : ''}
                            </div>
                            
                            ${trip.status !== 'completed' ? `
                                <div class="card-footer">
                                    <button class="btn btn-success" onclick="completeTrip(${trip.bookingId})">✓ Mark as Completed</button>
                                </div>
                            ` : ''}
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', card);
                });
            } else {
                container.innerHTML = '<div class="card"><div class="card-body" style="text-align: center; padding: 2rem;">No trips assigned yet</div></div>';
            }
        }
        
        async function completeTrip(bookingId) {
            if (!confirm('Mark this trip as completed?')) return;
            
            const result = await apiCall('booking.php', 'POST', {
                action: 'complete',
                bookingId: bookingId
            });
            
            if (result.success) {
                showToast('success', 'Trip marked as completed');
                loadTrips();
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            loadTrips();
        });
    </script>
</body>
</html>
