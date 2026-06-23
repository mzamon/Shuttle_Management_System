<?php
/**
 * Registration Page
 * NBK Travel Shuttle Booking Management System
 */

if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['userId'])) {
    header('Location: ' . ($_SESSION['role'] === 'admin' ? 'dashboard.php' : 'driver-dashboard.php'));
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/db.php';

    $username  = trim(htmlspecialchars($_POST['username'] ?? ''));
    $password  = $_POST['password'] ?? '';
    $confirm   = $_POST['confirm_password'] ?? '';
    $role      = 'driver'; // New registrations default to driver role

    if (empty($username) || empty($password) || empty($confirm)) {
        $error = 'All fields are required.';
    } elseif (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        // Check if username exists
        $check = $conn->prepare("SELECT userId FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'That username is already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (username, passwordHash, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hash, $role);
            if ($stmt->execute()) {
                $success = 'Account created! You can now sign in.';
            } else {
                $error = 'Something went wrong. Please try again.';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBK Travel – Create Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">

    <div class="login-bg-grid"></div>

    <div class="login-container">
        <div class="login-card">

            <!-- Logo -->
            <div class="login-logo-wrap">
                <img src="assets/images/nbk.jpeg" alt="NBK Travel" style="max-width:180px; width:100%; height:auto; filter:drop-shadow(0 4px 20px rgba(0,212,255,0.3));">
            </div>

            <div class="login-divider">
                <span>Create your account</span>
            </div>

            <?php if ($success): ?>
            <div class="alert alert-success" style="margin-bottom: 20px;">
                <?php echo $success; ?>
                <a href="index.php" style="color:inherit;font-weight:600;margin-left:8px;">Sign in &rarr;</a>
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="alert alert-danger" style="margin-bottom: 20px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <?php if (!$success): ?>
            <form method="POST" action="register.php" class="login-form">

                <div class="form-group" style="margin-bottom:16px;">
                    <label for="username">Username</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);display:flex;align-items:center;pointer-events:none;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6688a8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M6 20v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg>
                        </span>
                        <input type="text" id="username" name="username" placeholder="Choose a username" style="padding-left:38px;" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:16px;">
                    <label for="password">Password</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);display:flex;align-items:center;pointer-events:none;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6688a8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" id="password" name="password" placeholder="At least 6 characters" style="padding-left:38px;" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:24px;">
                    <label for="confirm_password">Confirm Password</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);display:flex;align-items:center;pointer-events:none;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6688a8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </span>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat your password" style="padding-left:38px;" required>
                    </div>
                </div>

                <div style="background:rgba(0,212,255,0.06);border:1px solid rgba(0,212,255,0.18);border-radius:8px;padding:12px 14px;margin-bottom:20px;font-size:12.5px;color:var(--text-secondary);line-height:1.6;">
                    New accounts are created as <strong style="color:var(--text-primary);">Driver</strong> accounts. Contact an administrator to be granted admin access.
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    Create Account
                </button>

            </form>
            <?php endif; ?>

            <div class="login-actions">
                <p>Already have an account?</p>
                <a href="index.php">Sign in &rarr;</a>
            </div>

        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>