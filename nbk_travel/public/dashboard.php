<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-light);
            box-shadow: 0 12px 24px rgba(59, 130, 246, 0.2);
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-light);
            margin: 0.5rem 0;
        }
        
        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1>Dashboard</h1>
                <div>
                    <span id="currentTime"></span>
                </div>
            </div>
            
            <!-- Statistics Cards -->
            <div class="grid grid-4" id="statsGrid">
                <div class="stat-card">
                    <div class="stat-label">Bookings Today</div>
                    <div class="stat-value" id="bookingsToday">-</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-label">Trips Completed</div>
                    <div class="stat-value" id="tripsCompleted">-</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-label">Revenue Today</div>
                    <div class="stat-value" id="revenueToday">-</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-label">Active Drivers</div>
                    <div class="stat-value" id="activeDrivers">-</div>
                </div>
            </div>
            
            <!-- Charts Row -->
            <div class="grid grid-2" style="margin-top: 2rem;">
                <div class="card">
                    <div class="card-header">
                        <h3>Trip Status Distribution</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="tripStatusChart"></canvas>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3>Revenue Trend</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="card" style="margin-top: 2rem;">
                <div class="card-header">
                    <h3>Recent Activity</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Booking Reference</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="recentActivity">
                        <tr>
                            <td colspan="5" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        // Load dashboard statistics
        async function loadDashboardStats() {
            const result = await apiCall('report.php?type=dashboard', 'GET');
            
            if (result.success) {
                const stats = result.data;
                document.getElementById('bookingsToday').textContent = stats.totalBookingsToday || 0;
                document.getElementById('tripsCompleted').textContent = stats.completedTripsToday || 0;
                document.getElementById('revenueToday').textContent = formatCurrency(stats.revenueToday || 0);
                document.getElementById('activeDrivers').textContent = stats.activeDrivers || 0;
            }
        }
        
        // Update current time
        function updateTime() {
            const now = new Date();
            document.getElementById('currentTime').textContent = now.toLocaleString();
        }
        
        // Load charts
        async function loadCharts() {
            // Trip Status Chart
            const tripChart = new Chart(document.getElementById('tripStatusChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
                    datasets: [{
                        data: [12, 5, 18, 3],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.6)',
                            'rgba(16, 185, 129, 0.6)',
                            'rgba(79, 70, 229, 0.6)',
                            'rgba(239, 68, 68, 0.6)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: 'rgba(241, 245, 249, 0.9)'
                            }
                        }
                    }
                }
            });
            
            // Revenue Trend Chart
            const revenueChart = new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Revenue (R)',
                        data: [2500, 3200, 2800, 4100, 3900, 4500, 3200],
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: 'rgba(241, 245, 249, 0.9)'
                            }
                        }
                    },
                    scales: {
                        y: {
                            tintColor: 'rgba(241, 245, 249, 0.2)',
                            grid: {
                                color: 'rgba(241, 245, 249, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(241, 245, 249, 0.7)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(241, 245, 249, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(241, 245, 249, 0.7)'
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardStats();
            loadCharts();
            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>
</body>
</html>
