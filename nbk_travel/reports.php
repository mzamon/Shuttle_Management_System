<?php
/**
 * Reports & Analytics Page
 * NBK Travel Shuttle Booking Management System
 */

session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';

require_once 'includes/header.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="page-header">
    <h1>Reports & Analytics</h1>
    <p>View business intelligence and performance metrics</p>
</div>

<!-- Tab Navigation -->
<div class="card">
    <div class="card-header">
        <div style="display: flex; gap: 16px; border-bottom: 1px solid var(--border); padding-bottom: 16px; margin: -24px -24px 0 -24px; padding: 16px 24px;">
            <button class="tab-btn active" onclick="switchTab('trips')">📊 Trip Report</button>
            <button class="tab-btn" onclick="switchTab('revenue')">💰 Revenue Report</button>
            <button class="tab-btn" onclick="switchTab('topcustomers')">👥 Top Customers</button>
            <button class="tab-btn" onclick="switchTab('status')">📈 Booking Status</button>
        </div>
    </div>

    <!-- Trip Report Tab -->
    <div id="trips-tab" class="tab-content active" style="padding: 24px;">
        <div class="form-row">
            <div class="form-group">
                <label>Start Date</label>
                <input type="date" id="tripStartDate" value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>">
            </div>
            <div class="form-group">
                <label>End Date</label>
                <input type="date" id="tripEndDate" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group" style="display: flex; align-items: flex-end;">
                <button class="btn btn-primary" onclick="generateTripReport()">Generate</button>
            </div>
        </div>
        <canvas id="tripChart"></canvas>
        <table id="tripTable" style="margin-top: 24px;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Trips</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Revenue Report Tab -->
    <div id="revenue-tab" class="tab-content" style="padding: 24px; display: none;">
        <div class="form-row">
            <div class="form-group">
                <label>Start Date</label>
                <input type="date" id="revenueStartDate" value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>">
            </div>
            <div class="form-group">
                <label>End Date</label>
                <input type="date" id="revenueEndDate" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group" style="display: flex; align-items: flex-end;">
                <button class="btn btn-primary" onclick="generateRevenueReport()">Generate</button>
                <button class="btn btn-secondary" onclick="exportRevenueReport()" style="margin-left: 8px;">📥 Export PDF</button>
            </div>
        </div>
        <canvas id="revenueChart"></canvas>
        <table id="revenueTable" style="margin-top: 24px;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Top Customers Tab -->
    <div id="topcustomers-tab" class="tab-content" style="padding: 24px; display: none;">
        <div class="form-row">
            <div class="form-group">
                <label>Limit</label>
                <input type="number" id="customerLimit" value="10" min="1" max="50">
            </div>
            <div class="form-group" style="display: flex; align-items: flex-end;">
                <button class="btn btn-primary" onclick="generateTopCustomers()">Generate</button>
            </div>
        </div>
        <canvas id="customersChart"></canvas>
        <table id="customersTable" style="margin-top: 24px;">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Bookings</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Status Summary Tab -->
    <div id="status-tab" class="tab-content" style="padding: 24px; display: none;">
        <button class="btn btn-primary" onclick="generateStatusReport()">Generate</button>
        <canvas id="statusChart" style="margin-top: 24px; max-width: 400px;"></canvas>
    </div>
</div>

<style>
.tab-btn {
    background: none;
    border: none;
    color: var(--text-secondary);
    padding: 12px 0;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
    font-size: 14px;
}

.tab-btn.active {
    color: var(--accent);
    border-bottom-color: var(--accent);
}

.tab-btn:hover {
    color: var(--accent);
}
</style>

<script>
let tripChart = null;
let revenueChart = null;
let customersChart = null;
let statusChart = null;

function switchTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    document.getElementById(tabName + '-tab').style.display = 'block';
    event.target.classList.add('active');
}

async function generateTripReport() {
    const startDate = document.getElementById('tripStartDate').value;
    const endDate = document.getElementById('tripEndDate').value;

    const result = await NBKTravel.apiCall(`/api/reports.php?action=trips&start=${startDate}&end=${endDate}`);
    
    if (!result.success) {
        NBKTravel.showToast(result.message, 'error');
        return;
    }

    const data = result.data;
    const labels = data.map(row => row.date);
    const counts = data.map(row => row.count);

    // Destroy existing chart
    if (tripChart) tripChart.destroy();

    const ctx = document.getElementById('tripChart').getContext('2d');
    tripChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Trips',
                data: counts,
                backgroundColor: 'rgba(0, 212, 255, 0.8)',
                borderColor: '#00d4ff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: { color: '#ffffff' }
                }
            },
            scales: {
                y: {
                    ticks: { color: '#8892a4' },
                    grid: { color: '#1e3a5f' }
                },
                x: {
                    ticks: { color: '#8892a4' },
                    grid: { color: '#1e3a5f' }
                }
            }
        }
    });

    // Update table
    const tbody = document.querySelector('#tripTable tbody');
    tbody.innerHTML = '';
    data.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.date}</td><td>${row.count}</td>`;
        tbody.appendChild(tr);
    });
}

async function generateRevenueReport() {
    const startDate = document.getElementById('revenueStartDate').value;
    const endDate = document.getElementById('revenueEndDate').value;

    const result = await NBKTravel.apiCall(`/api/reports.php?action=revenue&start=${startDate}&end=${endDate}`);
    
    if (!result.success) {
        NBKTravel.showToast(result.message, 'error');
        return;
    }

    const data = result.data;
    const labels = data.map(row => row.date);
    const revenue = data.map(row => row.revenue);

    if (revenueChart) revenueChart.destroy();

    const ctx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue ($)',
                data: revenue,
                backgroundColor: 'rgba(46, 213, 115, 0.8)',
                borderColor: '#2ed573',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: { color: '#ffffff' }
                }
            },
            scales: {
                y: {
                    ticks: { color: '#8892a4' },
                    grid: { color: '#1e3a5f' }
                },
                x: {
                    ticks: { color: '#8892a4' },
                    grid: { color: '#1e3a5f' }
                }
            }
        }
    });

    // Update table
    const tbody = document.querySelector('#revenueTable tbody');
    tbody.innerHTML = '';
    data.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.date}</td><td>$${parseFloat(row.revenue).toFixed(2)}</td>`;
        tbody.appendChild(tr);
    });
}

async function generateTopCustomers() {
    const limit = document.getElementById('customerLimit').value;

    const result = await NBKTravel.apiCall(`/api/reports.php?action=topcustomers&limit=${limit}`);
    
    if (!result.success) {
        NBKTravel.showToast(result.message, 'error');
        return;
    }

    const data = result.data;
    const names = data.map(row => row.fullName);
    const bookings = data.map(row => row.bookingCount);

    if (customersChart) customersChart.destroy();

    const ctx = document.getElementById('customersChart').getContext('2d');
    customersChart = new Chart(ctx, {
        type: 'barH',
        data: {
            labels: names,
            datasets: [{
                label: 'Bookings',
                data: bookings,
                backgroundColor: 'rgba(255, 165, 2, 0.8)',
                borderColor: '#ffa502',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    labels: { color: '#ffffff' }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#8892a4' },
                    grid: { color: '#1e3a5f' }
                },
                y: {
                    ticks: { color: '#8892a4' },
                    grid: { color: '#1e3a5f' }
                }
            }
        }
    });

    // Update table
    const tbody = document.querySelector('#customersTable tbody');
    tbody.innerHTML = '';
    data.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.fullName}</td><td>${row.bookingCount}</td>`;
        tbody.appendChild(tr);
    });
}

async function generateStatusReport() {
    const result = await NBKTravel.apiCall('/api/reports.php?action=status');
    
    if (!result.success) {
        NBKTravel.showToast(result.message, 'error');
        return;
    }

    const data = result.data;
    const labels = data.map(row => row.status);
    const counts = data.map(row => row.count);
    const colors = ['#ffa502', '#00d4ff', '#2ed573', '#ff4757'];

    if (statusChart) statusChart.destroy();

    const ctx = document.getElementById('statusChart').getContext('2d');
    statusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: { color: '#ffffff' }
                }
            }
        }
    });
}

// Generate on load
window.addEventListener('load', () => {
    generateTripReport();
});
</script>

<?php require_once 'includes/footer.php'; ?>
