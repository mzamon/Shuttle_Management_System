<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1>Schedule Management</h1>
                <div style="display: flex; gap: 1rem;">
                    <button class="btn btn-secondary" id="viewToggle" onclick="toggleView()">Weekly View</button>
                </div>
            </div>
            
            <!-- Date Navigation -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="grid grid-3" style="gap: 1rem; align-items: end;">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" id="startDate" value="" onchange="loadSchedule()">
                    </div>
                    
                    <div class="form-group">
                        <label>Driver Filter</label>
                        <select id="driverFilter" onchange="filterSchedule()">
                            <option value="">All Drivers</option>
                        </select>
                    </div>
                    
                    <div>
                        <button class="btn btn-primary" onclick="loadSchedule()">Refresh</button>
                    </div>
                </div>
            </div>
            
            <!-- Schedule Grid -->
            <div class="card">
                <div id="scheduleContainer" style="overflow-x: auto;">
                    <table id="scheduleTable">
                        <thead>
                            <tr>
                                <th style="min-width: 150px;">Driver</th>
                                <th style="min-width: 150px;">Vehicle</th>
                                <th style="min-width: 200px;">Booking Ref</th>
                                <th style="min-width: 200px;">Route</th>
                                <th style="min-width: 150px;">Scheduled Time</th>
                                <th style="min-width: 120px;">Status</th>
                            </tr>
                        </thead>
                        <tbody id="scheduleBody">
                            <tr><td colspan="6" class="text-center">Loading schedule...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Legend -->
            <div class="card" style="margin-top: 1.5rem;">
                <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="badge badge-info"></span> Pending
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="badge badge-success"></span> Confirmed
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="badge badge-primary"></span> In Progress
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="badge badge-warning"></span> Completed
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        function setDateDefault() {
            const today = new Date();
            document.getElementById('startDate').value = today.toISOString().split('T')[0];
        }
        
        async function loadSchedule() {
            const startDate = document.getElementById('startDate').value;
            const result = await apiCall(`report.php?type=trips&startDate=${startDate}`, 'GET');
            
            const tbody = document.getElementById('scheduleBody');
            tbody.innerHTML = '';
            
            if (result.success && result.data.length > 0) {
                result.data.forEach(row => {
                    const tripDate = new Date(row.date).toLocaleDateString();
                    tbody.insertAdjacentHTML('beforeend', `
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>Trip Assignment</td>
                            <td>${row.tripCount} trips</td>
                            <td>${tripDate}</td>
                            <td><span class="badge badge-primary">${row.status}</span></td>
                        </tr>
                    `);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center">No schedule data available</td></tr>';
            }
        }
        
        function toggleView() {
            const btn = document.getElementById('viewToggle');
            const isWeekly = btn.textContent === 'Weekly View';
            btn.textContent = isWeekly ? 'Daily View' : 'Weekly View';
        }
        
        function filterSchedule() {
            // Implement filter logic
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            setDateDefault();
            loadSchedule();
        });
    </script>
</body>
</html>
