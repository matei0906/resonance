<?php
require_once 'config.php';
require_once 'auth_helpers.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Get authorization token
$headers = getallheaders();
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
$token = str_replace('Bearer ', '', $auth_header);

if (!$token) {
    http_response_code(401);
    die(json_encode(['error' => 'No authorization token provided']));
}

// Verify session
$userInfo = verifySession($mysqli, $token);

if (!$userInfo) {
    http_response_code(401);
    die(json_encode(['error' => 'Invalid or expired session']));
}

$user_id = $userInfo['user_id'];

// Check if notifications table exists
$tableCheck = $mysqli->query("SHOW TABLES LIKE 'notifications'");
if (!$tableCheck || $tableCheck->num_rows === 0) {
    echo json_encode(['unread_count' => 0]);
    exit;
}

// Get unread count
$stmt = $mysqli->prepare('SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = FALSE');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode([
    'unread_count' => intval($result['count'])
]);

