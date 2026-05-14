<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drivers - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <h1 style="margin-bottom: 2rem;">Driver Management</h1>
            
            <!-- Drivers Grid -->
            <div class="grid grid-3" id="driversGrid">
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem;">Loading drivers...</div>
            </div>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        async function loadDrivers() {
            const result = await apiCall('driver.php?action=list', 'GET');
            
            const grid = document.getElementById('driversGrid');
            grid.innerHTML = '';
            
            if (result.success) {
                result.data.forEach(driver => {
                    const statusBadge = `badge-${driver.status === 'available' ? 'success' : driver.status === 'on-trip' ? 'info' : 'warning'}`;
                    const card = `
                        <div class="card">
                            <div class="card-header">
                                <h4>${driver.fullName}</h4>
                                <span class="badge ${statusBadge}">${driver.status}</span>
                            </div>
                            <div class="card-body">
                                <p><strong>Licence:</strong> ${driver.licenceNumber}</p>
                                <p><strong>Phone:</strong> ${driver.phoneNumber}</p>
                                <p><strong>Total Trips:</strong> ${driver.totalTrips}</p>
                                <p><strong>Total Hours:</strong> ${parseFloat(driver.totalHours || 0).toFixed(1)}</p>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-small btn-primary" onclick="updateDriverStatus(${driver.driverId}, '${driver.status}')">Update Status</button>
                            </div>
                        </div>
                    `;
                    grid.insertAdjacentHTML('beforeend', card);
                });
            }
        }
        
        async function updateDriverStatus(driverId, currentStatus) {
            const statuses = ['available', 'on-trip', 'off-duty'];
            const nextStatus = statuses[(statuses.indexOf(currentStatus) + 1) % statuses.length];
            
            const result = await apiCall('driver.php', 'POST', {
                action: 'updateStatus',
                driverId: driverId,
                status: nextStatus
            });
            
            if (result.success) {
                showToast('success', `Driver status updated to ${nextStatus}`);
                loadDrivers();
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            loadDrivers();
        });
    </script>
</body>
</html>
