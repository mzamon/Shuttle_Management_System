<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - NBK Travel Shuttle Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <h1 style="margin-bottom: 2rem;">Reports & Analytics</h1>
            
            <!-- Report Selector -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="grid grid-3" style="gap: 1rem;">
                    <div class="form-group">
                        <label>Report Type</label>
                        <select id="reportType" onchange="changeReport()">
                            <option value="tripReport">Trip Count Report</option>
                            <option value="revenueReport">Revenue Report</option>
                            <option value="topCustomers">Top Customers</option>
                            <option value="driverUtilisation">Driver Utilisation</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" id="startDate" value="">
                    </div>
                    
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" id="endDate" value="">
                    </div>
                    
                    <div>
                        <label>&nbsp;</label>
                        <button class="btn btn-primary btn-block" onclick="loadReport()">Generate Report</button>
                    </div>
                    
                    <div>
                        <label>&nbsp;</label>
                        <button class="btn btn-secondary btn-block" onclick="exportTableToCSV('reportTable', 'report.csv')">Export CSV</button>
                    </div>
                </div>
            </div>
            
            <!-- Chart -->
            <div class="card" id="chartContainer" style="margin-bottom: 2rem; display: none;">
                <div class="card-header">
                    <h3 id="chartTitle">Report Chart</h3>
                </div>
                <div style="position: relative; height: 300px;">
                    <canvas id="reportChart"></canvas>
                </div>
            </div>
            
            <!-- Data Table -->
            <div class="card">
                <div class="card-header">
                    <h3>Report Data</h3>
                </div>
                <table id="reportTable">
                    <thead id="reportTableHead"></thead>
                    <tbody id="reportTableBody">
                        <tr><td colspan="10" class="text-center">Select report and click Generate</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php require_once 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script>
        let reportChart = null;
        
        function setDateDefaults() {
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(endDate.getDate() - 30);
            
            document.getElementById('startDate').value = startDate.toISOString().split('T')[0];
            document.getElementById('endDate').value = endDate.toISOString().split('T')[0];
        }
        
        async function loadReport() {
            const type = document.getElementById('reportType').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            let endpoint = `report.php?type=${type}&startDate=${startDate}&endDate=${endDate}`;
            
            const result = await apiCall(endpoint, 'GET');
            
            if (result.success) {
                displayReport(type, result.data);
            }
        }
        
        function displayReport(type, data) {
            const tableHead = document.getElementById('reportTableHead');
            const tableBody = document.getElementById('reportTableBody');
            const chartContainer = document.getElementById('chartContainer');
            
            tableHead.innerHTML = '';
            tableBody.innerHTML = '';
            
            if (type === 'tripReport') {
                displayTripReport(data);
            } else if (type === 'revenueReport') {
                displayRevenueReport(data);
            } else if (type === 'topCustomers') {
                displayTopCustomers(data);
            } else if (type === 'driverUtilisation') {
                displayDriverUtilisation(data);
            }
        }
        
        function displayTripReport(data) {
            const tableHead = document.getElementById('reportTableHead');
            const tableBody = document.getElementById('reportTableBody');
            
            tableHead.innerHTML = `
                <tr>
                    <th>Date</th>
                    <th>Pending</th>
                    <th>Confirmed</th>
                    <th>Completed</th>
                    <th>Cancelled</th>
                    <th>Total</th>
                </tr>
            `;
            
            const dateMap = {};
            data.forEach(row => {
                const date = row.date;
                if (!dateMap[date]) {
                    dateMap[date] = { pending: 0, confirmed: 0, completed: 0, cancelled: 0 };
                }
                dateMap[date][row.status] = row.tripCount;
            });
            
            Object.entries(dateMap).forEach(([date, counts]) => {
                const total = Object.values(counts).reduce((a, b) => a + b, 0);
                tableBody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td>${date}</td>
                        <td>${counts.pending}</td>
                        <td>${counts.confirmed}</td>
                        <td>${counts.completed}</td>
                        <td>${counts.cancelled}</td>
                        <td><strong>${total}</strong></td>
                    </tr>
                `);
            });
            
            renderTripChart(data);
        }
        
        function displayRevenueReport(data) {
            const tableHead = document.getElementById('reportTableHead');
            const tableBody = document.getElementById('reportTableBody');
            
            tableHead.innerHTML = `
                <tr>
                    <th>Date</th>
                    <th>Trips</th>
                    <th>Total Revenue</th>
                    <th>Average Fare</th>
                </tr>
            `;
            
            data.daily.forEach(row => {
                tableBody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td>${row.date}</td>
                        <td>${row.tripCount}</td>
                        <td>${formatCurrency(row.totalRevenue)}</td>
                        <td>${formatCurrency(row.avgFare)}</td>
                    </tr>
                `);
            });
            
            const totalRow = `
                <tr style="background: rgba(59, 130, 246, 0.1); font-weight: bold;">
                    <td colspan="2">Total</td>
                    <td>${formatCurrency(data.total)}</td>
                    <td></td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', totalRow);
            
            renderRevenueChart(data);
        }
        
        function displayTopCustomers(data) {
            const tableHead = document.getElementById('reportTableHead');
            const tableBody = document.getElementById('reportTableBody');
            
            tableHead.innerHTML = `
                <tr>
                    <th>Rank</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Bookings</th>
                    <th>Total Spent</th>
                </tr>
            `;
            
            data.forEach((row, index) => {
                tableBody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td><strong>#${index + 1}</strong></td>
                        <td>${row.fullName}</td>
                        <td>${row.phoneNumber}</td>
                        <td>${row.totalBookings}</td>
                        <td>${formatCurrency(row.totalSpent)}</td>
                    </tr>
                `);
            });
            
            document.getElementById('chartContainer').style.display = 'none';
        }
        
        function displayDriverUtilisation(data) {
            const tableHead = document.getElementById('reportTableHead');
            const tableBody = document.getElementById('reportTableBody');
            
            tableHead.innerHTML = `
                <tr>
                    <th>Driver</th>
                    <th>Phone</th>
                    <th>Trips</th>
                    <th>Hours</th>
                    <th>Earnings</th>
                </tr>
            `;
            
            data.forEach(row => {
                tableBody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td>${row.fullName}</td>
                        <td>${row.phoneNumber}</td>
                        <td>${row.totalTrips}</td>
                        <td>${parseFloat(row.totalHours || 0).toFixed(1)}</td>
                        <td>${formatCurrency(row.totalEarnings || 0)}</td>
                    </tr>
                `);
            });
            
            document.getElementById('chartContainer').style.display = 'none';
        }
        
        function renderTripChart(data) {
            const ctx = document.getElementById('reportChart');
            const container = document.getElementById('chartContainer');
            container.style.display = 'block';
            
            const dateMap = {};
            data.forEach(row => {
                if (!dateMap[row.date]) dateMap[row.date] = 0;
                dateMap[row.date] += row.tripCount;
            });
            
            if (reportChart) reportChart.destroy();
            
            reportChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(dateMap),
                    datasets: [{
                        label: 'Trip Count',
                        data: Object.values(dateMap),
                        backgroundColor: 'rgba(59, 130, 246, 0.6)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
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
                            ticks: {
                                color: 'rgba(241, 245, 249, 0.7)'
                            },
                            grid: {
                                color: 'rgba(241, 245, 249, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: 'rgba(241, 245, 249, 0.7)'
                            },
                            grid: {
                                color: 'rgba(241, 245, 249, 0.1)'
                            }
                        }
                    }
                }
            });
        }
        
        function renderRevenueChart(data) {
            const ctx = document.getElementById('reportChart');
            const container = document.getElementById('chartContainer');
            container.style.display = 'block';
            
            if (reportChart) reportChart.destroy();
            
            reportChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.daily.map(d => d.date),
                    datasets: [{
                        label: 'Revenue (R)',
                        data: data.daily.map(d => d.totalRevenue),
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
                            ticks: {
                                color: 'rgba(241, 245, 249, 0.7)'
                            },
                            grid: {
                                color: 'rgba(241, 245, 249, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: 'rgba(241, 245, 249, 0.7)'
                            },
                            grid: {
                                color: 'rgba(241, 245, 249, 0.1)'
                            }
                        }
                    }
                }
            });
        }
        
        function changeReport() {
            // Reset chart when changing report type
            document.getElementById('reportTableHead').innerHTML = '';
            document.getElementById('reportTableBody').innerHTML = '<tr><td colspan="10" class="text-center">Select report and click Generate</td></tr>';
            document.getElementById('chartContainer').style.display = 'none';
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            setDateDefaults();
        });
    </script>
</body>
</html>
