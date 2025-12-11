<?php
require_once 'config.php';
require_once 'auth_helpers.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
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

// Get request body
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['mark_all']) && $data['mark_all']) {
    // Mark all notifications as read
    $stmt = $mysqli->prepare('UPDATE notifications SET is_read = TRUE WHERE user_id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    
    echo json_encode(['success' => true, 'message' => 'All notifications marked as read']);
} else if (isset($data['notification_id'])) {
    // Mark single notification as read
    $notification_id = intval($data['notification_id']);
    
    $stmt = $mysqli->prepare('UPDATE notifications SET is_read = TRUE WHERE id = ? AND user_id = ?');
    $stmt->bind_param('ii', $notification_id, $user_id);
    $stmt->execute();
    
    echo json_encode(['success' => true]);
} else {
    http_response_code(400);
    die(json_encode(['error' => 'notification_id or mark_all is required']));
}

