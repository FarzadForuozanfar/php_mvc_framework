<?php

// migrate.php

// 1. Bootstrap the application to load dependencies and .env
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "Migration script started...\n";

// 2. Database credentials from environment variables
$dbHost = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
$dbName = $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE');
$dbUser = $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME');
$dbPass = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD');

// 3. Read the SQL schema file
$sqlFile = __DIR__ . '/schema.sql';
if (!file_exists($sqlFile)) {
    die("Error: schema.sql file not found!\n");
}
$sql = file_get_contents($sqlFile);

echo "Read schema.sql successfully.\n";

// 4. Connect to the database and execute the query
try {
    // Note: We connect WITHOUT specifying a database name first
    // to ensure we can create it if it doesn't exist.
    $pdo = new PDO("mysql:host={$dbHost}", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // This is optional but good practice: ensure database exists.
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}`");
    $pdo->exec("USE `{$dbName}`");

    echo "Database connected. Running migrations...\n";

    // Execute the main schema
    $pdo->exec($sql);

    echo "✅ Success! Database migration completed.\n";

} catch (PDOException $e) {
    print_r($_ENV);
    die("❌ Database Error: {$e->getMessage()}" . PHP_EOL);
} 