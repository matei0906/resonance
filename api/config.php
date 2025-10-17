<?php
// Database configuration using environment variables when available.
// Fallback to local defaults for development.

declare(strict_types=1);

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbName = getenv('DB_NAME') ?: 'resonance';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($mysqli->connect_errno) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Ensure UTF-8
$mysqli->set_charset('utf8mb4');

// Start a secure session for login persistence
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


