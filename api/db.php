<?php
// Load database credentials from local config file (gitignored)
$configFile = __DIR__ . '/config.local.php';
if (!file_exists($configFile)) {
    die("Database configuration not found. Copy config.example.php to config.local.php and add your credentials.");
}

$dbConfig = require $configFile;

$conn = new mysqli(
    $dbConfig['DB_HOST'],
    $dbConfig['DB_USER'],
    $dbConfig['DB_PASSWORD'],
    $dbConfig['DB_NAME']
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>