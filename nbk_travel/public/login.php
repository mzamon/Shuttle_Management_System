<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBK Travel - Shuttle Booking System - Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1a1f3a 50%, #2d3561 100%);
        }
        
        .login-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 12px;
            padding: 3rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .login-header p {
            color: #cbd5e1;
            font-size: 0.9rem;
        }
        
        .demo-credentials {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }
        
        .demo-credentials h4 {
            margin-bottom: 0.5rem;
            color: #3b82f6;
        }
        
        .demo-credentials p {
            margin: 0.25rem 0;
            color: #cbd5e1;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>NBK Travel</h1>
                <p>Shuttle Booking Management System</p>
            </div>
            
            <div class="demo-credentials">
                <h4>Demo Credentials</h4>
                <p><strong>Admin:</strong> admin / Admin@123</p>
                <p><strong>Driver:</strong> john.driver / Driver@123</p>
            </div>
            
            <form id="loginForm">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                    <span class="form-error"></span>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                    <span class="form-error"></span>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
    
    <script src="assets/js/main.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const rules = {
                username: [Validator.required, Validator.minLength(3)],
                password: [Validator.required, Validator.minLength(6)]
            };
            
            const validation = validateForm('loginForm', rules);
            if (!validation.isValid) return;
            
            LoadingOverlay.show();
            
            const data = {
                username: document.getElementById('username').value,
                password: document.getElementById('password').value
            };
            
            const result = await apiCall('login.php', 'POST', data);
            
            LoadingOverlay.hide();
            
            if (result.success) {
                showToast('success', 'Login successful. Redirecting...');
                setTimeout(() => {
                    window.location.href = 'dashboard.php';
                }, 1500);
            }
        });
    </script>
</body>
</html>
