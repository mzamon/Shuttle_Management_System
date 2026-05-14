<?php
/**
 * Global Helper Functions
 * Reusable functions for common operations
 */

declare(strict_types=1);

// ============================================
// API Response Helpers
// ============================================

/**
 * Send success JSON response
 */
function successResponse(string $message, mixed $data = null, int $httpCode = 200): void {
    http_response_code($httpCode);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => $message,
        'data' => $data,
        'errors' => []
    ]);
    exit;
}

/**
 * Send error JSON response
 */
function errorResponse(string $message, array $errors = [], int $httpCode = 400): void {
    http_response_code($httpCode);
    header('Content-Type: application/json');
    
    error_log("API Error [$httpCode]: $message - " . json_encode($errors));
    
    echo json_encode([
        'success' => false,
        'message' => $message,
        'data' => null,
        'errors' => $errors
    ]);
    exit;
}

/**
 * Validation error response
 */
function validationError(array $errors): void {
    errorResponse('Validation failed', $errors, 422);
}

// ============================================
// Validation Helpers
// ============================================

/**
 * Validate required field
 */
function validateRequired(string $value, string $fieldName): ?string {
    if (empty(trim($value))) {
        return "$fieldName is required";
    }
    return null;
}

/**
 * Validate email format
 */
function validateEmail(string $email): ?string {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format";
    }
    return null;
}

/**
 * Validate phone number (basic)
 */
function validatePhone(string $phone): ?string {
    $phone = preg_replace('/\D/', '', $phone);
    if (strlen($phone) < 10 || strlen($phone) > 15) {
        return "Phone number must be 10-15 digits";
    }
    return null;
}

/**
 * Validate datetime format
 */
function validateDateTime(string $datetime): ?string {
    $d = \DateTime::createFromFormat(DATE_FORMAT . ' H:i:s', $datetime);
    if (!$d || $d->format(DATE_FORMAT . ' H:i:s') !== $datetime) {
        return "Invalid datetime format (YYYY-MM-DD HH:MM:SS)";
    }
    return null;
}

/**
 * Validate numeric value
 */
function validateNumeric(string $value, string $fieldName): ?string {
    if (!is_numeric($value) || $value < 0) {
        return "$fieldName must be a positive number";
    }
    return null;
}

/**
 * Validate minimum length
 */
function validateMinLength(string $value, int $minLength, string $fieldName): ?string {
    if (strlen($value) < $minLength) {
        return "$fieldName must be at least $minLength characters";
    }
    return null;
}

/**
 * Validate maximum length
 */
function validateMaxLength(string $value, int $maxLength, string $fieldName): ?string {
    if (strlen($value) > $maxLength) {
        return "$fieldName must not exceed $maxLength characters";
    }
    return null;
}

// ============================================
// Sanitization Helpers
// ============================================

/**
 * Sanitize string input
 */
function sanitizeString(string $value): string {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize email
 */
function sanitizeEmail(string $email): string {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

/**
 * Sanitize phone number
 */
function sanitizePhone(string $phone): string {
    return preg_replace('/[^\d+\-\s]/', '', $phone);
}

// ============================================
// Security Helpers
// ============================================

/**
 * Hash password with bcrypt
 */
function hashPassword(string $password): string {
    return password_hash($password, HASH_ALGORITHM, HASH_OPTIONS);
}

/**
 * Verify password against hash
 */
function verifyPassword(string $password, string $hash): bool {
    return password_verify($password, $hash);
}

/**
 * Generate secure random token
 */
function generateToken(int $length = 32): string {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Generate booking reference number
 */
function generateBookingReference(): string {
    return 'NBK-' . date('Y') . '-' . str_pad((string)rand(1, 9999), 5, '0', STR_PAD_LEFT);
}

/**
 * Generate invoice number
 */
function generateInvoiceNumber(): string {
    return 'INV-' . date('Y-m-d') . '-' . str_pad((string)rand(1, 999), 4, '0', STR_PAD_LEFT);
}

/**
 * Sanitize SQL for logging only (never use in queries)
 */
function sanitizeForLog(string $sql): string {
    return htmlspecialchars(substr($sql, 0, 200), ENT_QUOTES, 'UTF-8');
}

// ============================================
// Date/Time Helpers
// ============================================

/**
 * Get current datetime
 */
function getCurrentDateTime(): string {
    return date(DATETIME_FORMAT);
}

/**
 * Get current date
 */
function getCurrentDate(): string {
    return date(DATE_FORMAT);
}

/**
 * Format date for display
 */
function formatDate(string $date): string {
    return date(DISPLAY_DATE_FORMAT, strtotime($date));
}

/**
 * Format datetime for display
 */
function formatDateTime(string $datetime): string {
    return date(DISPLAY_DATETIME_FORMAT, strtotime($datetime));
}

/**
 * Calculate trip duration in hours
 */
function calculateDuration(\DateTime $start, \DateTime $end): float {
    return ($end->getTimestamp() - $start->getTimestamp()) / 3600;
}

/**
 * Check if time is in future
 */
function isFutureDateTime(string $datetime): bool {
    return strtotime($datetime) > time();
}

/**
 * Check if time is in past
 */
function isPastDateTime(string $datetime): bool {
    return strtotime($datetime) < time();
}

// ============================================
// Currency Helpers
// ============================================

/**
 * Format currency value
 */
function formatCurrency(float $amount): string {
    return APP_CURRENCY . ' ' . number_format($amount, 2, '.', ',');
}

/**
 * Calculate tax (15% VAT for South Africa)
 */
function calculateVAT(float $subtotal, float $taxRate = 0.15): float {
    return round($subtotal * $taxRate, 2);
}

/**
 * Calculate total with tax
 */
function calculateTotal(float $subtotal, float $taxRate = 0.15): float {
    return round($subtotal + calculateVAT($subtotal, $taxRate), 2);
}

// ============================================
// String Helpers
// ============================================

/**
 * Truncate string
 */
function truncateString(string $string, int $limit = 50, string $suffix = '...'): string {
    if (strlen($string) <= $limit) {
        return $string;
    }
    return substr($string, 0, $limit) . $suffix;
}

/**
 * Convert array to CSV line
 */
function arrayToCSV(array $data): string {
    return implode(',', array_map(function ($value) {
        return '"' . str_replace('"', '""', $value) . '"';
    }, $data));
}

// ============================================
// Array Helpers
// ============================================

/**
 * Get value from array safely
 */
function getArrayValue(array $array, string $key, mixed $default = null): mixed {
    return $array[$key] ?? $default;
}

/**
 * Extract specific keys from array
 */
function extractKeys(array $array, array $keys): array {
    return array_filter(
        array_map(function ($key) use ($array) {
            return isset($array[$key]) ? [$key => $array[$key]] : [];
        }, $keys),
        function ($item) {
            return !empty($item);
        }
    );
}

// ============================================
// File Helpers
// ============================================

/**
 * Create directory if not exists
 */
function ensureDirectory(string $path): bool {
    if (!is_dir($path)) {
        return mkdir($path, 0755, true);
    }
    return true;
}

/**
 * Get safe filename
 */
function getSafeFilename(string $filename): string {
    return preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
}

/**
 * Get file extension
 */
function getFileExtension(string $filename): string {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

// ============================================
// Logging Helpers
// ============================================

/**
 * Log message to file
 */
function logMessage(string $message, string $level = 'INFO'): void {
    $timestamp = date('Y-m-d H:i:s');
    $logFile = BASE_PATH . 'logs/app.log';
    
    ensureDirectory(dirname($logFile));
    
    $logEntry = "[$timestamp] [$level] $message\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

/**
 * Log database error
 */
function logDatabaseError(string $query, string $error): void {
    logMessage("DB Error: $error | Query: " . sanitizeForLog($query), 'ERROR');
}

?>
