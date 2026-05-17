<?php
/**
 * NBK Travel - Database Setup Script
 * Run this once to create database and import schema
 */

$servername = "localhost";
$username = "root";
$password = "";

// Create connection WITHOUT database name (to create it)
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Connection failed: " . $conn->connect_error,
        "error" => "Make sure MySQL is running on localhost"
    ], JSON_PRETTY_PRINT));
}

echo "<pre style='font-family: monospace; background: #1a1a1a; color: #00ff00; padding: 20px; border-radius: 8px;'>";
echo "🔧 NBK Travel - Database Setup\n";
echo "================================\n\n";

// Step 1: Create database
echo "Step 1: Creating database 'nbk_travel'...\n";
$createDB = $conn->query("CREATE DATABASE IF NOT EXISTS nbk_travel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

if ($createDB) {
    echo "✅ Database created successfully\n\n";
} else {
    echo "❌ Error creating database: " . $conn->error . "\n";
    die("</pre>");
}

// Step 2: Select database
echo "Step 2: Selecting database...\n";
$conn->select_db("nbk_travel");
echo "✅ Database selected\n\n";

// Step 3: Read and execute schema.sql
echo "Step 3: Reading schema.sql...\n";
$schemaFile = __DIR__ . '/database/schema.sql';

if (!file_exists($schemaFile)) {
    echo "❌ Schema file not found at: $schemaFile\n";
    die("</pre>");
}

$schemaSQL = file_get_contents($schemaFile);
echo "✅ Schema file loaded (" . strlen($schemaSQL) . " bytes)\n\n";

// Parse and execute schema queries
echo "Step 4: Executing schema queries...\n";
$queries = array_filter(
    array_map('trim', preg_split('/;(\s|$)/', $schemaSQL)),
    function($q) { return !empty($q) && !preg_match('/^\s*--/', $q); }
);

$tableCount = 0;
foreach ($queries as $query) {
    if (!empty($query)) {
        if ($conn->query($query) === TRUE) {
            if (preg_match('/CREATE TABLE.*?`(\w+)`/i', $query, $matches)) {
                echo "  ✅ Created table: " . $matches[1] . "\n";
                $tableCount++;
            }
        } else {
            echo "  ⚠️  Query result: " . $conn->error . "\n";
        }
    }
}

echo "\n✅ Schema executed - $tableCount tables created\n\n";

// Step 5: Read and execute seed.sql
echo "Step 5: Reading seed.sql...\n";
$seedFile = __DIR__ . '/database/seed.sql';

if (!file_exists($seedFile)) {
    echo "❌ Seed file not found at: $seedFile\n";
    die("</pre>");
}

$seedSQL = file_get_contents($seedFile);
echo "✅ Seed file loaded (" . strlen($seedSQL) . " bytes)\n\n";

// Parse and execute seed queries
echo "Step 6: Executing seed queries...\n";
$seedQueries = array_filter(
    array_map('trim', preg_split('/;(\s|$)/', $seedSQL)),
    function($q) { return !empty($q) && !preg_match('/^\s*--/', $q); }
);

$insertCount = 0;
foreach ($seedQueries as $query) {
    if (!empty($query)) {
        if ($conn->query($query) === TRUE) {
            if (preg_match('/INSERT INTO\s+`?(\w+)`?/i', $query, $matches)) {
                $insertCount++;
            }
        } else {
            echo "  ⚠️  Query error: " . $conn->error . "\n";
        }
    }
}

echo "✅ Seed executed - $insertCount records inserted\n\n";

// Step 7: Verify setup
echo "Step 7: Verifying setup...\n";

// Count tables
$tablesResult = $conn->query("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = 'nbk_travel'");
$tablesRow = $tablesResult->fetch_assoc();
$tableCount = $tablesRow['count'];
echo "  📊 Tables created: $tableCount\n";

// Count records
$tables = ['users', 'customers', 'drivers', 'vehicles', 'bookings', 'schedules', 'invoices', 'notifications'];
foreach ($tables as $table) {
    $result = $conn->query("SELECT COUNT(*) as count FROM $table");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "  📋 $table: " . $row['count'] . " records\n";
    }
}

echo "\n";
echo "================================\n";
echo "✅ SETUP COMPLETE!\n";
echo "================================\n\n";

echo "🎯 Next Steps:\n";
echo "1. Navigate to http://localhost/nbk_travel\n";
echo "2. Login with credentials:\n";
echo "   - Username: admin\n";
echo "   - Password: password\n";
echo "   OR\n";
echo "   - Username: driver\n";
echo "   - Password: password\n";
echo "3. Test the system workflows\n";
echo "\n";

$conn->close();
echo "</pre>";
?>
