<?php
/**
 * NBK Travel Shuttle Management System
 * Configuration File
 * 
 * All database, email, and system constants defined here
 */

declare(strict_types=1);

// Enable error reporting in development
error_reporting(E_ALL);
ini_set('display_errors', '0'); // Logged, not displayed to users
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'nbk_travel_shuttle');
define('DB_PORT', 3306);

// Application Configuration
define('APP_NAME', 'NBK Travel - Shuttle Booking Management');
define('APP_VERSION', '1.0.0');
define('APP_TIMEZONE', 'Africa/Johannesburg');
define('APP_CURRENCY', 'ZAR');

// Session Configuration
define('SESSION_TIMEOUT', 1800); // 30 minutes
define('SESSION_NAME', 'NBK_SHUTTLE_SESSION');

// File Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/../public/uploads/');
define('INVOICE_DIR', __DIR__ . '/../public/invoices/');
define('MAX_UPLOAD_SIZE', 10485760); // 10MB

// Security Configuration
define('HASH_ALGORITHM', PASSWORD_BCRYPT);
define('HASH_OPTIONS', ['cost' => 12]);
define('SITE_KEY', 'nbk_travel_2026_shuttle_system');

// Email Configuration (Simulated)
define('NOTIFICATION_EMAIL', 'admin@nbktravel.co.za');
define('NOTIFICATION_SMS_PREFIX', '+27');

// Pagination
define('RECORDS_PER_PAGE', 10);

// Date/Time Format
define('DATE_FORMAT', 'Y-m-d');
define('DATETIME_FORMAT', 'Y-m-d H:i:s');
define('DISPLAY_DATE_FORMAT', 'd M Y');
define('DISPLAY_DATETIME_FORMAT', 'd M Y @ H:i');

// System Status
define('SYSTEM_ACTIVE', true);
define('MAINTENANCE_MODE', false);
define('DEBUG_MODE', false);

// Default Credentials (DEMO ONLY)
define('DEMO_ADMIN_USERNAME', 'admin');
define('DEMO_ADMIN_PASSWORD', 'Admin@123');
define('DEMO_DRIVER_USERNAME', 'john.driver');
define('DEMO_DRIVER_PASSWORD', 'Driver@123');

// Application Paths
define('BASE_PATH', realpath(__DIR__ . '/..') . '/');
define('SRC_PATH', BASE_PATH . 'src/');
define('CONFIG_PATH', BASE_PATH . 'config/');
define('PUBLIC_PATH', BASE_PATH . 'public/');

// Set timezone
date_default_timezone_set(APP_TIMEZONE);

?>
