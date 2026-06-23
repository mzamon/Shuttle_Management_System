<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Detect base path dynamically
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($basePath === '') $basePath = '';

// If already logged in, redirect to dashboard
if (isset($_SESSION['userId'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NBK Travel – Shuttle & Transport Services</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    /* ───────────── Reset & Base ───────────── */
    *,
    *::before,
    *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --bg-deep: #060e1a;
      --bg-primary: #0a1628;
      --bg-card: #0e2040;
      --bg-panel: #0c1c35;
      --cyan: #00d4ff;
      --cyan-dim: rgba(0, 212, 255, 0.12);
      --cyan-glow: 0 0 30px rgba(0, 212, 255, 0.25);
      --text-white: #ffffff;
      --text-muted: #8899b5;
      --border-subtle: rgba(255, 255, 255, 0.06);
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--bg-deep);
      color: var(--text-white);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
    }

    a {
      text-decoration: none;
      color: inherit;
    }
    button {
      font-family: inherit;
      cursor: pointer;
    }
    input,
    select {
      font-family: inherit;
    }
    img {
      max-width: 100%;
      display: block;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
    }

    /* ───────────── Navbar ───────────── */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      background: rgba(6, 14, 26, 0.88);
      backdrop-filter: blur(18px);
      border-bottom: 1px solid rgba(0, 212, 255, 0.08);
      padding: 0 24px;
      height: 72px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .nav-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 700;
      font-size: 20px;
      letter-spacing: -0.5px;
      color: var(--text-white);
    }

    .nav-logo span {
      color: var(--cyan);
    }

    .nav-logo svg {
      width: 32px;
      height: 32px;
      stroke: var(--cyan);
      fill: none;
      stroke-width: 2;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 32px;
      list-style: none;
      font-size: 14px;
      font-weight: 500;
      color: var(--text-muted);
    }

    .nav-links a {
      transition: color 0.2s;
    }
    .nav-links a:hover {
      color: var(--text-white);
    }

    .nav-cta {
      background: var(--cyan);
      color: #04111f;
      padding: 8px 22px;
      border-radius: 40px;
      font-weight: 600;
      font-size: 13px;
      transition: box-shadow 0.25s, transform 0.2s;
    }
    .nav-cta:hover {
      box-shadow: var(--cyan-glow);
      transform: translateY(-1px);
      color: #04111f;
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .nav-actions .login-link {
      font-size: 13px;
      font-weight: 500;
      color: var(--text-muted);
      transition: color 0.2s;
    }
    .nav-actions .login-link:hover {
      color: var(--text-white);
    }

    /* ───────────── Hero ───────────── */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 120px 0 60px;
      position: relative;
      overflow: hidden;
      background: radial-gradient(ellipse at 20% 50%, rgba(0, 100, 200, 0.12) 0%, transparent 60%),
        radial-gradient(ellipse at 80% 30%, rgba(0, 212, 255, 0.06) 0%, transparent 50%),
        var(--bg-deep);
    }

    .hero::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(0, 212, 255, 0.015) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 212, 255, 0.015) 1px, transparent 1px);
      background-size: 60px 60px;
      pointer-events: none;
    }

    .hero-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
      position: relative;
      z-index: 1;
    }

    .hero-content h1 {
      font-family: 'Space Grotesk', sans-serif;
      font-size: clamp(38px, 5vw, 62px);
      font-weight: 700;
      line-height: 1.1;
      letter-spacing: -1px;
      margin-bottom: 16px;
    }

    .hero-content h1 .highlight {
      background: linear-gradient(135deg, var(--cyan), #0088cc);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-content p {
      font-size: 18px;
      color: var(--text-muted);
      max-width: 480px;
      margin-bottom: 32px;
      line-height: 1.7;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(0, 212, 255, 0.08);
      border: 1px solid rgba(0, 212, 255, 0.18);
      border-radius: 40px;
      padding: 6px 16px 6px 10px;
      font-size: 12px;
      font-weight: 500;
      color: var(--cyan);
      margin-bottom: 24px;
      letter-spacing: 0.3px;
    }

    .hero-badge-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--cyan);
      box-shadow: 0 0 12px rgba(0, 212, 255, 0.5);
      animation: pulse-dot 2s ease-in-out infinite;
    }

    @keyframes pulse-dot {
      0%,
      100% {
        opacity: 1;
        transform: scale(1);
      }
      50% {
        opacity: 0.4;
        transform: scale(0.8);
      }
    }

    .hero-visual {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .hero-card {
      background: rgba(14, 32, 64, 0.6);
      border: 1px solid rgba(0, 212, 255, 0.12);
      border-radius: 20px;
      padding: 32px;
      backdrop-filter: blur(12px);
      width: 100%;
      max-width: 440px;
    }

    .hero-card .vehicle-icon {
      display: flex;
      justify-content: center;
      margin-bottom: 16px;
    }

    .hero-card .vehicle-icon svg {
      width: 72px;
      height: 72px;
      stroke: var(--cyan);
      fill: none;
      stroke-width: 1.5;
    }

    .hero-card h3 {
      font-size: 18px;
      font-weight: 600;
      text-align: center;
      margin-bottom: 4px;
    }

    .hero-card p {
      font-size: 13px;
      color: var(--text-muted);
      text-align: center;
      margin-bottom: 20px;
    }

    .hero-stats-row {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 12px;
    }

    .stat-item {
      background: rgba(0, 0, 0, 0.25);
      border-radius: 12px;
      padding: 14px 10px;
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.04);
    }

    .stat-item .num {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--cyan);
    }

    .stat-item .label {
      font-size: 11px;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 2px;
    }

    /* ───────────── Booking Form ───────────── */
    .booking-section {
      padding: 40px 0 70px;
      background: var(--bg-primary);
    }

    .booking-card {
      background: var(--bg-card);
      border: 1px solid rgba(0, 212, 255, 0.08);
      border-radius: 20px;
      padding: 40px 44px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .booking-card .section-tag {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--cyan);
      margin-bottom: 6px;
    }

    .booking-card h2 {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 28px;
    }

    .booking-form {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 18px 24px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .form-group label {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: var(--text-muted);
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 12px 14px;
      background: rgba(6, 14, 26, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.07);
      border-radius: 10px;
      color: var(--text-white);
      font-size: 14px;
      transition: border-color 0.2s, box-shadow 0.2s;
      outline: none;
    }

    .form-group input:focus,
    .form-group select:focus {
      border-color: rgba(0, 212, 255, 0.3);
      box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.06);
    }

    .form-group select option {
      background: var(--bg-panel);
      color: var(--text-white);
    }

    .form-group input::placeholder {
      color: rgba(255, 255, 255, 0.25);
    }

    .btn-find {
      background: var(--cyan);
      color: #04111f;
      border: none;
      padding: 14px 32px;
      border-radius: 10px;
      font-weight: 700;
      font-size: 15px;
      transition: box-shadow 0.25s, transform 0.2s;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      justify-content: center;
      margin-top: 4px;
      height: 52px;
      align-self: flex-end;
    }

    .btn-find:hover {
      box-shadow: var(--cyan-glow);
      transform: translateY(-2px);
    }

    .btn-find svg {
      width: 18px;
      height: 18px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2.5;
    }

    /* ───────────── Features ───────────── */
    .features-section {
      padding: 70px 0 80px;
      background: var(--bg-deep);
      border-top: 1px solid rgba(255, 255, 255, 0.03);
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 30px;
    }

    .feature-item {
      text-align: center;
      padding: 32px 20px;
      background: rgba(14, 32, 64, 0.35);
      border: 1px solid rgba(255, 255, 255, 0.04);
      border-radius: 16px;
      transition: border-color 0.25s, transform 0.2s;
    }

    .feature-item:hover {
      border-color: rgba(0, 212, 255, 0.15);
      transform: translateY(-4px);
    }

    .feature-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      background: rgba(0, 212, 255, 0.08);
      border: 1px solid rgba(0, 212, 255, 0.12);
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .feature-icon svg {
      width: 26px;
      height: 26px;
      stroke: var(--cyan);
      fill: none;
      stroke-width: 1.75;
    }

    .feature-item h4 {
      font-size: 17px;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .feature-item p {
      font-size: 14px;
      color: var(--text-muted);
      max-width: 260px;
      margin: 0 auto;
    }

    /* ───────────── Footer ───────────── */
    .footer {
      padding: 40px 0 30px;
      border-top: 1px solid rgba(255, 255, 255, 0.04);
      text-align: center;
      color: var(--text-muted);
      font-size: 13px;
      background: var(--bg-primary);
    }

    .footer span {
      color: var(--cyan);
    }

    /* ───────────── Login Modal ───────────── */
    .login-modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 2000;
      background: rgba(2, 8, 16, 0.8);
      backdrop-filter: blur(12px);
      align-items: center;
      justify-content: center;
      padding: 24px;
    }
    .login-modal-overlay.active {
      display: flex;
    }
    .login-modal {
      background: var(--bg-card);
      border: 1px solid rgba(0, 212, 255, 0.15);
      border-radius: 20px;
      padding: 40px 36px;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
      position: relative;
    }
    .login-modal h2 {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 22px;
      margin-bottom: 4px;
    }
    .login-modal p.sub {
      color: var(--text-muted);
      font-size: 13px;
      margin-bottom: 24px;
    }
    .login-modal .form-group {
      margin-bottom: 14px;
    }
    .login-modal .btn-primary {
      background: var(--cyan);
      color: #04111f;
      border: none;
      padding: 12px;
      border-radius: 10px;
      font-weight: 700;
      width: 100%;
      font-size: 14px;
      transition: box-shadow 0.25s;
    }
    .login-modal .btn-primary:hover {
      box-shadow: var(--cyan-glow);
    }
    .login-modal .modal-close {
      position: absolute;
      top: 14px;
      right: 18px;
      background: none;
      border: none;
      color: var(--text-muted);
      font-size: 22px;
      cursor: pointer;
    }
    .login-modal .modal-close:hover {
      color: var(--text-white);
    }
    .login-modal .demo-row {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      color: var(--text-muted);
      padding: 4px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }
    .login-modal .demo-row:last-child {
      border-bottom: none;
    }
    .login-modal .demo-row code {
      font-family: monospace;
      color: var(--text-white);
      background: rgba(0, 0, 0, 0.2);
      padding: 0 6px;
      border-radius: 4px;
    }

    /* ───────────── Responsive ───────────── */
    @media (max-width: 1024px) {
      .hero-grid {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
      }
      .hero-content p {
        margin-left: auto;
        margin-right: auto;
      }
      .hero-card {
        max-width: 420px;
        margin: 0 auto;
      }
      .booking-card {
        padding: 28px 20px;
      }
      .booking-form {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      }
    }

    @media (max-width: 768px) {
      .navbar {
        padding: 0 16px;
        height: 64px;
      }
      .nav-links {
        display: none;
      }
      .nav-actions .login-link {
        display: none;
      }
      .hero {
        padding: 100px 0 40px;
        min-height: auto;
      }
      .hero-content h1 {
        font-size: 30px;
      }
      .hero-card {
        padding: 24px;
      }
      .hero-stats-row {
        grid-template-columns: 1fr 1fr 1fr;
        gap: 8px;
      }
      .stat-item .num {
        font-size: 18px;
      }
      .booking-card h2 {
        font-size: 22px;
      }
      .booking-form {
        grid-template-columns: 1fr 1fr;
      }
      .btn-find {
        grid-column: 1 / -1;
      }
      .features-grid {
        grid-template-columns: 1fr;
        max-width: 400px;
        margin: 0 auto;
      }
    }

    @media (max-width: 480px) {
      .booking-form {
        grid-template-columns: 1fr;
      }
      .hero-stats-row {
        grid-template-columns: 1fr 1fr;
      }
      .stat-item:last-child {
        grid-column: 1 / -1;
      }
      .booking-card {
        padding: 20px 16px;
      }
    }
  </style>
</head>
<body>

  <!-- ═══════════ NAVBAR ═══════════ -->
  <nav class="navbar">
    <div class="nav-logo">
      <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
        <rect x="1" y="3" width="15" height="13" rx="2"/>
        <path d="M16 8h4l3 5v3h-7V8z"/>
        <circle cx="5.5" cy="18.5" r="2.5"/>
        <circle cx="18.5" cy="18.5" r="2.5"/>
      </svg>
      NBK<span>TRAVEL</span>
    </div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="bookings.php">Bookings</a></li>
      <li><a href="vehicles.php">Fleet</a></li>
      <li><a href="schedule.php">Locations</a></li>
      <li><a href="reports.php">Offers</a></li>
      <li><a href="notifications.php">Support</a></li>
    </ul>
    <div class="nav-actions">
      <a href="#" class="login-link" onclick="openLoginModal(); return false;">Sign In</a>
      <a href="#" class="nav-cta" onclick="openLoginModal(); return false;">Book Now</a>
    </div>
  </nav>

  <!-- ═══════════ HERO ═══════════ -->
  <section class="hero">
    <div class="container hero-grid">

      <!-- Left: Text -->
      <div class="hero-content">
        <div class="hero-badge">
          <span class="hero-badge-dot"></span>
          Fleet Intelligence Platform
        </div>
        <h1>
          The <span class="highlight">Great Escape</span><br />
          Starts Here
        </h1>
        <p>
          Premium shuttle & transport services across South Africa.
          Book your ride in seconds, track your driver live, and travel with confidence.
        </p>
        <div style="display:flex; gap:14px; flex-wrap:wrap;">
          <button class="btn-find" style="background:var(--cyan);color:#04111f;border:none;padding:14px 32px;border-radius:10px;font-weight:700;font-size:15px;display:inline-flex;align-items:center;gap:10px;" onclick="openLoginModal();">
            <svg viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Find My Ride
          </button>
          <a href="vehicles.php" style="color:var(--text-muted);font-weight:500;display:flex;align-items:center;gap:6px;font-size:14px;">
            View Fleet →
          </a>
        </div>
      </div>

      <!-- Right: Hero Card -->
      <div class="hero-visual">
        <div class="hero-card">
          <div class="vehicle-icon">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <rect x="1" y="3" width="15" height="13" rx="2"/>
              <path d="M16 8h4l3 5v3h-7V8z"/>
              <circle cx="5.5" cy="18.5" r="2.5"/>
              <circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
          </div>
          <h3>Your Journey, Your Way</h3>
          <p>Choose from our premium fleet of shuttles, sedans, and SUVs.</p>

          <div class="hero-stats-row">
            <div class="stat-item">
              <div class="num">40+</div>
              <div class="label">Locations</div>
            </div>
            <div class="stat-item">
              <div class="num">3</div>
              <div class="label">Countries</div>
            </div>
            <div class="stat-item">
              <div class="num">24/7</div>
              <div class="label">Support</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ═══════════ BOOKING FORM ═══════════ -->
  <section class="booking-section">
    <div class="container">
      <div class="booking-card">
        <div class="section-tag">Book Now</div>
        <h2>Find Your Vehicle</h2>

        <form class="booking-form" id="bookingForm" onsubmit="openLoginModal(); return false;">
          <!-- Pick-up Location -->
          <div class="form-group">
            <label for="pickupLocation">Pick-up Location</label>
            <select id="pickupLocation" required>
              <option value="">Select a Location</option>
              <option value="jhb">O.R. Tambo Airport</option>
              <option value="cpt">Cape Town International</option>
              <option value="dur">King Shaka Airport</option>
              <option value="sandton">Sandton City</option>
              <option value="pretoria">Pretoria CBD</option>
            </select>
          </div>

          <!-- Pick-up Date -->
          <div class="form-group">
            <label for="pickupDate">Pick-up Date</label>
            <input type="date" id="pickupDate" value="2026-06-25" required />
          </div>

          <!-- Pick-up Time -->
          <div class="form-group">
            <label for="pickupTime">Pick-up Time</label>
            <select id="pickupTime" required>
              <option value="08:00">08:00</option>
              <option value="09:00">09:00</option>
              <option value="10:00">10:00</option>
              <option value="11:00">11:00</option>
              <option value="12:00" selected>12:00</option>
              <option value="13:00">13:00</option>
              <option value="14:00">14:00</option>
              <option value="15:00">15:00</option>
              <option value="16:00">16:00</option>
              <option value="17:00">17:00</option>
            </select>
          </div>

          <!-- Drop-off Date -->
          <div class="form-group">
            <label for="dropoffDate">Drop-off Date</label>
            <input type="date" id="dropoffDate" value="2026-07-02" required />
          </div>

          <!-- Drop-off Time -->
          <div class="form-group">
            <label for="dropoffTime">Drop-off Time</label>
            <select id="dropoffTime" required>
              <option value="08:00">08:00</option>
              <option value="09:00">09:00</option>
              <option value="10:00">10:00</option>
              <option value="11:00">11:00</option>
              <option value="12:00" selected>12:00</option>
              <option value="13:00">13:00</option>
              <option value="14:00">14:00</option>
              <option value="15:00">15:00</option>
              <option value="16:00">16:00</option>
              <option value="17:00">17:00</option>
            </select>
          </div>

          <!-- Renter Age -->
          <div class="form-group">
            <label for="renterAge">Renter Age</label>
            <select id="renterAge" required>
              <option value="18">18+</option>
              <option value="21">21+</option>
              <option value="25">25+</option>
            </select>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn-find">
            <svg viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Find My Vehicle
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- ═══════════ FEATURES ═══════════ -->
  <section class="features-section">
    <div class="container">
      <div style="text-align:center;margin-bottom:48px;">
        <div style="font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:2px;color:var(--cyan);">Why NBK Travel</div>
        <h2 style="font-family:'Space Grotesk',sans-serif;font-size:30px;font-weight:700;margin-top:6px;">Your Journey, Your Way</h2>
      </div>

      <div class="features-grid">
        <!-- Feature 1 -->
        <div class="feature-item">
          <div class="feature-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <h4>Live Scheduling</h4>
          <p>Real-time driver assignment with conflict detection. Never double-book again.</p>
        </div>

        <!-- Feature 2 -->
        <div class="feature-item">
          <div class="feature-icon">
            <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
          </div>
          <h4>Go Carbon Neutral</h4>
          <p>Our fleet includes hybrid and electric vehicles. Travel sustainably.</p>
        </div>

        <!-- Feature 3 -->
        <div class="feature-item">
          <div class="feature-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
          </div>
          <h4>Premium Fleet</h4>
          <p>From executive sedans to spacious shuttles – we have the right vehicle for every trip.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════════ FOOTER ═══════════ -->
  <footer class="footer">
    <div class="container">
      <p>&copy; 2026 <span>NBK Travel</span> – Shuttle & Transport Services. All rights reserved.</p>
    </div>
  </footer>

  <!-- ═══════════ LOGIN MODAL ═══════════ -->
  <div class="login-modal-overlay" id="loginModal">
    <div class="login-modal">
      <button class="modal-close" onclick="closeLoginModal()">&times;</button>
      <h2>Welcome Back</h2>
      <p class="sub">Sign in to access your dashboard</p>

      <form action="login.php" method="POST" onsubmit="return handleLogin(event)">
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" id="loginUsername" placeholder="Enter your username" value="admin" required />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" id="loginPassword" placeholder="Enter your password" value="password" required />
        </div>
        <button type="submit" class="btn-primary">Sign In</button>
      </form>

      <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.06);">
        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);margin-bottom:8px;">Demo Credentials</div>
        <div class="demo-row"><span>Admin</span><span><code>admin</code> / <code>password</code></span></div>
        <div class="demo-row"><span>Driver</span><span><code>driver</code> / <code>password</code></span></div>
      </div>

      <div style="margin-top:16px;text-align:center;font-size:13px;color:var(--text-muted);">
        Don't have an account? <a href="register.php" style="color:var(--cyan);font-weight:600;">Create one →</a>
      </div>
    </div>
  </div>

  <!-- ═══════════ SCRIPTS ═══════════ -->
  <script>
    // ── Login Modal ──
    function openLoginModal() {
      document.getElementById('loginModal').classList.add('active');
    }
    function closeLoginModal() {
      document.getElementById('loginModal').classList.remove('active');
    }
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeLoginModal();
    });
    document.addEventListener('click', (e) => {
      const modal = document.getElementById('loginModal');
      if (e.target === modal) closeLoginModal();
    });

    // ── Login Handler – if form submission fails, fallback to direct redirect ──
    function handleLogin(e) {
      // The form action is set to login.php, which will process login.
      return true;
    }

    // ── Booking Form (opens login modal) ──
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
      e.preventDefault();
      openLoginModal();
    });
  </script>

</body>
</html>