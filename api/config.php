<?php
declare(strict_types=1);

// Load database credentials from local config file (gitignored)
$configFile = __DIR__ . '/config.local.php';
if (!file_exists($configFile)) {
    die(json_encode([
        'success' => false,
        'error' => 'Database configuration not found. Copy config.example.php to config.local.php and add your credentials.'
    ]));
}

$dbConfig = require $configFile;

define('DB_HOST', $dbConfig['DB_HOST']);
define('DB_NAME', $dbConfig['DB_NAME']);
define('DB_USER', $dbConfig['DB_USER']);
define('DB_PASSWORD', $dbConfig['DB_PASSWORD']);

// Create connection
try {
    error_log("Attempting to connect to database at " . DB_HOST);
    
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($mysqli->connect_error) {
        error_log("Database connection failed: " . $mysqli->connect_error);
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }

    error_log("Successfully connected to database");

    // Set charset to utf8mb4
    if (!$mysqli->set_charset("utf8mb4")) {
        error_log("Failed to set charset: " . $mysqli->error);
        throw new Exception("Error setting charset: " . $mysqli->error);
    }

    error_log("Database connection fully configured");

} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'message' => 'Database connection error',
        'error' => $e->getMessage()
    ]));
}