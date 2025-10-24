<?php
declare(strict_types=1);
header('Content-Type: application/json');

require __DIR__ . '/config.php';

session_destroy();
echo json_encode(['success' => true]);
