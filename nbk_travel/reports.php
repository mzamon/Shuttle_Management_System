<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'includes/auth_check.php';
require_once 'includes/db.php';
require_once 'includes/header.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="page-header">
    <div class="ph-text"><h1>Reports & Analytics</h1><p>Business intelligence and performance metrics</p></div>
</div>

<div class="card">
    <div class="tabs-nav">
        <button class="tab-btn active" data-tab="trips"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg> Trips</button>
        <button class="tab-btn" data-tab="revenue"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg> Revenue</button>
        <button class="tab-btn" data-tab="customers"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg> Top Customers</button>
        <button class="tab-btn" data-tab="status"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg> Status</button>
    </div>

    <div id="tab-trips" class="tab-content active" style="padding:24px;">
        <div class="form-row" style="grid-template-columns:auto auto 1fr;">
            <div class="form-group"><label>Start</label><input type="date" id="tripStart" value="<?= date('Y-m-d', strtotime('-30 days')) ?>"></div>
            <div class="form-group"><label>End</label><input type="date" id="tripEnd" value="<?= date('Y-m-d') ?>"></div>
            <div class="form-group" style="display:flex;align-items:flex-end;"><button class="btn btn-primary" onclick="generateTripReport()">Generate</button></div>
        </div>
        <canvas id="tripChart" height="200"></canvas>
        <div class="table-wrap" style="margin-top:20px;">
            <table id="tripTable"><thead><tr><th>Date</th><th>Trips</th></tr></thead><tbody></tbody></table>
        </div>
    </div>

    <div id="tab-revenue" class="tab-content" style="padding:24px;display:none;">
        <div class="form-row" style="grid-template-columns:auto auto 1fr;">
            <div class="form-group"><label>Start</label><input type="date" id="revStart" value="<?= date('Y-m-d', strtotime('-30 days')) ?>"></div>
            <div class="form-group"><label>End</label><input type="date" id="revEnd" value="<?= date('Y-m-d') ?>"></div>
            <div class="form-group" style="display:flex;align-items:flex-end;"><button class="btn btn-primary" onclick="generateRevenueReport()">Generate</button></div>
        </div>
        <canvas id="revenueChart" height="200"></canvas>
        <div class="table-wrap" style="margin-top:20px;"><table id="revenueTable"><thead><tr><th>Date</th><th>Revenue (R)</th></tr></thead><tbody></tbody></table></div>
    </div>

    <div id="tab-customers" class="tab-content" style="padding:24px;display:none;">
        <div class="form-row" style="grid-template-columns:auto 1fr;">
            <div class="form-group"><label>Limit</label><input type="number" id="customerLimit" value="10" min="1" max="50"></div>
            <div class="form-group" style="display:flex;align-items:flex-end;"><button class="btn btn-primary" onclick="generateTopCustomers()">Generate</button></div>
        </div>
        <canvas id="customersChart" height="200"></canvas>
        <div class="table-wrap" style="margin-top:20px;"><table id="customersTable"><thead><tr><th>Customer</th><th>Bookings</th></tr></thead><tbody></tbody></table></div>
    </div>

    <div id="tab-status" class="tab-content" style="padding:24px;display:none;">
        <button class="btn btn-primary" onclick="generateStatusReport()">Generate</button>
        <canvas id="statusChart" height="200" style="max-width:400px;margin-top:20px;"></canvas>
    </div>
</div>

<script>
let tripChart, revenueChart, customersChart, statusChart;

function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + tab).style.display = 'block';
    document.querySelector(`.tab-btn[data-tab="${tab}"]`).classList.add('active');
}
document.querySelectorAll('.tab-btn').forEach(btn => btn.addEventListener('click', () => switchTab(btn.dataset.tab)));

async function generateTripReport() {
    const start = document.getElementById('tripStart').value, end = document.getElementById('tripEnd').value;
    const res = await NBKTravel.apiCall(`/nbk-travel/api/reports.php?action=trips&start=${start}&end=${end}`);
    if (!res.success) return NBKTravel.showToast(res.message, 'error');
    const data = res.data;
    if (tripChart) tripChart.destroy();
    tripChart = new Chart(document.getElementById('tripChart'), {
        type: 'bar',
        data: { labels: data.map(r => r.date), datasets: [{ label: 'Trips', data: data.map(r => r.count), backgroundColor: 'rgba(0,229,255,0.8)' }] },
        options: { responsive: true, plugins: { legend: { labels: { color: '#dde8f7' } } },
            scales: { y: { ticks: { color: '#7da8c8' }, grid: { color: '#1e3a5f' } }, x: { ticks: { color: '#7da8c8' }, grid: { color: '#1e3a5f' } } } }
    });
    const tbody = document.querySelector('#tripTable tbody');
    tbody.innerHTML = data.map(r => `<tr><td>${r.date}</td><td>${r.count}</td></tr>`).join('');
}

async function generateRevenueReport() {
    const start = document.getElementById('revStart').value, end = document.getElementById('revEnd').value;
    const res = await NBKTravel.apiCall(`/nbk-travel/api/reports.php?action=revenue&start=${start}&end=${end}`);
    if (!res.success) return NBKTravel.showToast(res.message, 'error');
    const data = res.data;
    if (revenueChart) revenueChart.destroy();
    revenueChart = new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: { labels: data.map(r => r.date), datasets: [{ label: 'Revenue (R)', data: data.map(r => r.revenue), backgroundColor: 'rgba(16,217,160,0.8)' }] },
        options: { responsive: true, plugins: { legend: { labels: { color: '#dde8f7' } } },
            scales: { y: { ticks: { color: '#7da8c8' }, grid: { color: '#1e3a5f' } }, x: { ticks: { color: '#7da8c8' }, grid: { color: '#1e3a5f' } } } }
    });
    const tbody = document.querySelector('#revenueTable tbody');
    tbody.innerHTML = data.map(r => `<tr><td>${r.date}</td><td>${parseFloat(r.revenue).toFixed(2)}</td></tr>`).join('');
}

async function generateTopCustomers() {
    const limit = document.getElementById('customerLimit').value;
    const res = await NBKTravel.apiCall(`/nbk-travel/api/reports.php?action=topcustomers&limit=${limit}`);
    if (!res.success) return NBKTravel.showToast(res.message, 'error');
    const data = res.data;
    if (customersChart) customersChart.destroy();
    customersChart = new Chart(document.getElementById('customersChart'), {
        type: 'bar',
        data: { labels: data.map(r => r.fullName), datasets: [{ label: 'Bookings', data: data.map(r => r.bookingCount), backgroundColor: 'rgba(245,158,11,0.8)' }] },
        options: { indexAxis: 'y', responsive: true, plugins: { legend: { labels: { color: '#dde8f7' } } },
            scales: { x: { ticks: { color: '#7da8c8' }, grid: { color: '#1e3a5f' } }, y: { ticks: { color: '#7da8c8' }, grid: { color: '#1e3a5f' } } } }
    });
    const tbody = document.querySelector('#customersTable tbody');
    tbody.innerHTML = data.map(r => `<tr><td>${r.fullName}</td><td>${r.bookingCount}</td></tr>`).join('');
}

async function generateStatusReport() {
    const res = await NBKTravel.apiCall('/nbk-travel/api/reports.php?action=status');
    if (!res.success) return NBKTravel.showToast(res.message, 'error');
    const data = res.data;
    const colors = ['#f59e0b','#00e5ff','#10d9a0','#ff4560'];
    if (statusChart) statusChart.destroy();
    statusChart = new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: { labels: data.map(r => r.status), datasets: [{ data: data.map(r => r.count), backgroundColor: colors }] },
        options: { responsive: true, plugins: { legend: { labels: { color: '#dde8f7' } } } }
    });
}

window.addEventListener('load', generateTripReport);
</script>

<?php require_once 'includes/footer.php'; ?>