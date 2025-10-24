<?php
declare(strict_types=1);
header('Content-Type: application/json');

require __DIR__ . '/config.php';

if (isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => true,
        'user' => [
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['email'],
            'name' => $_SESSION['name'],
        ],
    ]);
} else {
    echo json_encode(['success' => false]);
}
