<?php
declare(strict_types=1);

// Rudimentary DB test endpoint for local CLI testing.
// Includes the existing `config.php` which creates $mysqli and exits with JSON on failure.
header('Content-Type: application/json');

require __DIR__ . '/config.php';

// At this point $mysqli should be a connected mysqli instance from config.php
$response = [
    'success' => true,
    'message' => 'Connected to database',
];

// Try a simple query: list tables
$tables = [];
if ($result = $mysqli->query("SHOW TABLES")) {
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
    $result->free();
    $response['tables'] = $tables;
    $response['has_users_table'] = in_array('users', $tables, true);
} else {
    $response = [
        'success' => false,
        'error' => 'Query failed: ' . $mysqli->error,
    ];
}

echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

$mysqli->close();
