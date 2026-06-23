<?php
$pg = basename($_SERVER['PHP_SELF']);
$initial = strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1));
function navLink($href, $label, $pg, $icon) {
    $active = (basename($href) === $pg) ? 'active' : '';
    return "<a href='$href' class='nav-link $active'><span class='nav-icon'><svg viewBox='0 0 24 24'>$icon</svg></span><span>$label</span></a>";
}
$ICONS = [
  'dashboard'  => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
  'bookings'   => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
  'schedule'   => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
  'customers'  => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
  'drivers'    => '<circle cx="12" cy="8" r="4"/><path d="M6 20v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>',
  'vehicles'   => '<rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
  'reports'    => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>',
  'invoices'   => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>',
  'notifs'     => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
  'mytrips'    => '<rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
  'logout'     => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NBK Travel · <?php echo ucfirst(str_replace(['.php','-'],['',' '],$pg)); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&family=Orbitron:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="app-body">

<aside class="sidebar">
  <div class="sb-header">
    <div class="sb-logo">
      <?php if (file_exists(__DIR__ . '/../assets/images/nbk.jpeg')): ?>
        <img src="assets/images/nbk.jpeg" alt="NBK">
      <?php else: ?>
        <div style="width:36px;height:36px;background:rgba(0,229,255,0.1);border:1px solid rgba(0,229,255,0.3);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00e5ff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        </div>
      <?php endif; ?>
      <div class="sb-logo-text">
        <h2>NBK TRAVEL</h2>
        <span>Fleet Management</span>
      </div>
    </div>
  </div>

  <nav class="sb-nav">
    <?php if ($_SESSION['role'] === 'admin'): ?>
      <span class="sb-section-label">Main</span>
      <?= navLink('dashboard.php','Dashboard',$pg,$ICONS['dashboard']) ?>
      <?= navLink('bookings.php','Bookings',$pg,$ICONS['bookings']) ?>
      <?= navLink('schedule.php','Schedule',$pg,$ICONS['schedule']) ?>
      <span class="sb-section-label">Fleet</span>
      <?= navLink('customers.php','Customers',$pg,$ICONS['customers']) ?>
      <?= navLink('drivers.php','Drivers',$pg,$ICONS['drivers']) ?>
      <?= navLink('vehicles.php','Vehicles',$pg,$ICONS['vehicles']) ?>
      <span class="sb-section-label">Insights</span>
      <?= navLink('reports.php','Reports',$pg,$ICONS['reports']) ?>
      <?= navLink('invoices.php','Invoices',$pg,$ICONS['invoices']) ?>
      <?= navLink('notifications.php','Notifications',$pg,$ICONS['notifs']) ?>
    <?php else: ?>
      <?= navLink('driver-dashboard.php','My Trips',$pg,$ICONS['mytrips']) ?>
    <?php endif; ?>
  </nav>

  <div class="sb-footer">
    <div class="sb-user">
      <div class="sb-avatar"><?= $initial ?></div>
      <div class="sb-user-info">
        <p><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></p>
        <small><?= ucfirst($_SESSION['role'] ?? 'user') ?></small>
      </div>
    </div>
    <a href="logout.php" class="logout-link">
      <svg viewBox="0 0 24 24"><?= $ICONS['logout'] ?></svg>
      <span>Sign Out</span>
    </a>
  </div>
</aside>

<main class="main-content">