<?php
/**
 * User Authentication Class
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

class Auth {
    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }
    
    /**
     * Register new user (admin only)
     */
    public function register(string $username, string $password, string $firstName, string $lastName, string $email, string $phone, string $role = 'customer'): array {
        // Validation
        $errors = [];
        
        if (strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters';
        }
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }
        
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        // Check if username exists
        $stmt = $this->db->prepare('SELECT userId FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return ['success' => false, 'errors' => ['Username already exists']];
        }
        
        $passwordHash = hashPassword($password);
        $stmt = $this->db->prepare(
            'INSERT INTO users (username, passwordHash, firstName, lastName, email, phoneNumber, role, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        
        $status = 'active';
        $stmt->bind_param('ssssssss', $username, $passwordHash, $firstName, $lastName, $email, $phone, $role, $status);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'User registered successfully'];
        }
        
        return ['success' => false, 'errors' => ['Registration failed']];
    }
    
    /**
     * Authenticate user login
     */
    public function login(string $username, string $password): array {
        $stmt = $this->db->prepare(
            'SELECT userId, username, passwordHash, role, firstName, lastName, status, email, phoneNumber 
             FROM users WHERE username = ?'
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            logMessage("Login failed: User $username not found", 'WARN');
            return ['success' => false, 'message' => 'Invalid username or password'];
        }
        
        $user = $result->fetch_assoc();
        
        if ($user['status'] !== 'active') {
            logMessage("Login blocked: User $username account inactive", 'WARN');
            return ['success' => false, 'message' => 'Account is inactive. Contact administrator.'];
        }
        
        if (!verifyPassword($password, $user['passwordHash'])) {
            logMessage("Login failed: Invalid password for $username", 'WARN');
            return ['success' => false, 'message' => 'Invalid username or password'];
        }
        
        // Update last login
        $now = getCurrentDateTime();
        $stmt = $this->db->prepare('UPDATE users SET lastLoginAt = ? WHERE userId = ?');
        $stmt->bind_param('si', $now, $user['userId']);
        $stmt->execute();
        
        // Create session
        session_name(SESSION_NAME);
        session_start();
        
        $_SESSION['userId'] = $user['userId'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['firstName'] = $user['firstName'];
        $_SESSION['lastName'] = $user['lastName'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['phone'] = $user['phoneNumber'];
        $_SESSION['loginTime'] = time();
        
        logMessage("User $username logged in successfully", 'INFO');
        
        return [
            'success' => true,
            'message' => 'Login successful',
            'role' => $user['role'],
            'name' => $user['firstName'] . ' ' . $user['lastName']
        ];
    }
    
    /**
     * Logout user
     */
    public function logout(): void {
        if (isset($_SESSION['username'])) {
            logMessage("User {$_SESSION['username']} logged out", 'INFO');
        }
        
        session_destroy();
    }
    
    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated(): bool {
        return isset($_SESSION['userId']) && isset($_SESSION['role']);
    }
    
    /**
     * Check if user has specific role
     */
    public static function hasRole(string $role): bool {
        return self::isAuthenticated() && $_SESSION['role'] === $role;
    }
    
    /**
     * Require authentication
     */
    public static function requireAuth(): void {
        if (!self::isAuthenticated()) {
            header('Location: login.php');
            exit;
        }
    }
    
    /**
     * Get current user ID
     */
    public static function getCurrentUserId(): ?int {
        return $_SESSION['userId'] ?? null;
    }
    
    /**
     * Get current user info
     */
    public static function getCurrentUser(): ?array {
        if (!self::isAuthenticated()) {
            return null;
        }
        
        return [
            'userId' => $_SESSION['userId'],
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role'],
            'firstName' => $_SESSION['firstName'],
            'lastName' => $_SESSION['lastName'],
            'email' => $_SESSION['email'],
            'phone' => $_SESSION['phone']
        ];
    }
    
    /**
     * Check session timeout
     */
    public static function checkTimeout(): void {
        if (isset($_SESSION['loginTime']) && (time() - $_SESSION['loginTime'] > SESSION_TIMEOUT)) {
            session_destroy();
            header('Location: login.php?timeout=1');
            exit;
        }
        $_SESSION['loginTime'] = time();
    }
}

?>
