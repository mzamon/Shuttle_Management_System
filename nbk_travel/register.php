<?php
/**
 * REGISTER PAGE – Hertz Style
 * Creates a new driver account, then redirects to login.
 */
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['userId'])) {
    header('Location: ' . ($_SESSION['role'] === 'admin' ? 'dashboard.php' : 'driver-dashboard.php'));
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/db.php';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($password) || empty($confirm)) {
        $error = 'All fields are required.';
    } elseif (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $check = $conn->prepare("SELECT userId FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'Username already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (username, passwordHash, role) VALUES (?, ?, 'driver')");
            $stmt->bind_param("ss", $username, $hash);
            if ($stmt->execute()) {
                $success = 'Account created! You can now sign in.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NBK Travel – Create Account</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    :root {
      --bg-deep: #060e1a;
      --bg-card: #0e2040;
      --cyan: #00d4ff;
      --cyan-glow: 0 0 30px rgba(0, 212, 255, 0.25);
      --text-white: #ffffff;
      --text-muted: #8899b5;
    }
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg-deep);
      color: var(--text-white);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }
    .auth-card {
      background: var(--bg-card);
      border: 1px solid rgba(0, 212, 255, 0.12);
      border-radius: 20px;
      padding: 44px 40px;
      max-width: 420px;
      width: 100%;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    }
    .auth-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 28px;
    }
    .auth-logo svg {
      width: 32px;
      height: 32px;
      stroke: var(--cyan);
      fill: none;
      stroke-width: 2;
    }
    .auth-logo strong {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 20px;
      font-weight: 700;
      letter-spacing: -0.5px;
    }
    .auth-logo strong span {
      color: var(--cyan);
    }
    .auth-back {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      color: var(--text-muted);
      margin-bottom: 20px;
      transition: color 0.2s;
    }
    .auth-back:hover {
      color: var(--text-white);
    }
    .auth-back svg {
      width: 14px;
      height: 14px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2.5;
    }
    .auth-card h2 {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 4px;
    }
    .auth-card .sub {
      color: var(--text-muted);
      font-size: 13px;
      margin-bottom: 24px;
    }
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-bottom: 14px;
    }
    .form-group label {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: var(--text-muted);
    }
    .form-group input {
      width: 100%;
      padding: 12px 14px;
      background: rgba(6, 14, 26, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.07);
      border-radius: 10px;
      color: var(--text-white);
      font-size: 14px;
      outline: none;
      transition: border-color 0.2s;
    }
    .form-group input:focus {
      border-color: rgba(0, 212, 255, 0.3);
    }
    .form-group input::placeholder {
      color: rgba(255, 255, 255, 0.25);
    }
    .btn-primary {
      background: var(--cyan);
      color: #04111f;
      border: none;
      padding: 14px;
      border-radius: 10px;
      font-weight: 700;
      font-size: 14px;
      width: 100%;
      transition: box-shadow 0.25s, transform 0.2s;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .btn-primary:hover {
      box-shadow: var(--cyan-glow);
      transform: translateY(-2px);
    }
    .btn-primary svg {
      width: 16px;
      height: 16px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2.5;
    }
    .hint-box {
      background: rgba(0, 212, 255, 0.05);
      border: 1px solid rgba(0, 212, 255, 0.08);
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 12px;
      color: var(--text-muted);
      line-height: 1.6;
      margin-bottom: 20px;
    }
    .hint-box strong {
      color: var(--text-white);
    }
    .alert {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      padding: 12px 16px;
      border-radius: 10px;
      font-size: 13px;
      margin-bottom: 16px;
      border-left: 3px solid;
    }
    .alert-success {
      background: rgba(16, 217, 160, 0.1);
      border-color: #10d9a0;
      color: #10d9a0;
    }
    .alert-danger {
      background: rgba(255, 69, 96, 0.1);
      border-color: #ff4560;
      color: #ff4560;
    }
    .alert svg {
      width: 16px;
      height: 16px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2.5;
      flex-shrink: 0;
      margin-top: 1px;
    }
    .auth-footer {
      margin-top: 20px;
      padding-top: 16px;
      border-top: 1px solid rgba(255, 255, 255, 0.06);
      text-align: center;
      font-size: 13px;
      color: var(--text-muted);
    }
    .auth-footer a {
      color: var(--cyan);
      font-weight: 600;
    }
  </style>
</head>
<body>

<div class="auth-card">
  <!-- Logo -->
  <div class="auth-logo">
    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
      <rect x="1" y="3" width="15" height="13" rx="2"/>
      <path d="M16 8h4l3 5v3h-7V8z"/>
      <circle cx="5.5" cy="18.5" r="2.5"/>
      <circle cx="18.5" cy="18.5" r="2.5"/>
    </svg>
    <strong>NBK<span>TRAVEL</span></strong>
  </div>

  <!-- Back Link -->
  <a href="index.php" class="auth-back">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Home
  </a>

  <h2>Create Account</h2>
  <p class="sub">Join the NBK Travel fleet management platform.</p>

  <?php if ($success): ?>
  <div class="alert alert-success">
    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
    <?= $success ?> <a href="index.php" style="color:var(--cyan);font-weight:600;margin-left:4px;">Sign in →</a>
  </div>
  <?php endif; ?>

  <?php if ($error): ?>
  <div class="alert alert-danger">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <?= htmlspecialchars($error) ?>
  </div>
  <?php endif; ?>

  <?php if (!$success): ?>
  <form method="POST" action="register.php">
    <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" placeholder="Choose a username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required />
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" placeholder="At least 6 characters" required />
    </div>
    <div class="form-group">
      <label>Confirm Password</label>
      <input type="password" name="confirm_password" placeholder="Repeat your password" required />
    </div>

    <div class="hint-box">
      New accounts are created as <strong>Driver</strong> accounts. Contact an administrator for admin access.
    </div>

    <button type="submit" class="btn-primary">
      <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
      Create Account
    </button>
  </form>
  <?php endif; ?>

  <div class="auth-footer">
    Already have an account?
    <a href="index.php">Sign in →</a>
  </div>
</div>

</body>
</html>