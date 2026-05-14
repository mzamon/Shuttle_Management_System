<?php
/**
 * Database Connection Handler
 * 
 * Establishes MySQLi connection with error handling
 * All queries use prepared statements for security
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';

class Database {
    private static ?\mysqli $connection = null;
    
    /**
     * Get database connection singleton
     */
    public static function connect(): \mysqli {
        if (self::$connection === null) {
            self::$connection = new \mysqli(
                DB_HOST,
                DB_USER,
                DB_PASSWORD,
                DB_NAME,
                DB_PORT
            );
            
            if (self::$connection->connect_error) {
                error_log("Database Connection Failed: " . self::$connection->connect_error);
                die(json_encode([
                    'success' => false,
                    'message' => 'Database connection failed. Contact administrator.',
                    'errors' => []
                ]));
            }
            
            self::$connection->set_charset('utf8mb4');
        }
        
        return self::$connection;
    }
    
    /**
     * Close database connection
     */
    public static function close(): void {
        if (self::$connection !== null) {
            self::$connection->close();
            self::$connection = null;
        }
    }
    
    /**
     * Prepare and execute query
     */
    public static function query(string $sql, array $params = [], string $types = ''): \mysqli_result|bool|null {
        $conn = self::connect();
        
        try {
            if (empty($params)) {
                return $conn->query($sql);
            }
            
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new \Exception("Prepare failed: " . $conn->error);
            }
            
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            
            if (!$stmt->execute()) {
                throw new \Exception("Execute failed: " . $stmt->error);
            }
            
            return $stmt->get_result();
        } catch (\Exception $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}

?>
