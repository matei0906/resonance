<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Get authorization token
$headers = getallheaders();
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
$token = str_replace('Bearer ', '', $auth_header);

if (!$token) {
    http_response_code(401);
    die(json_encode(['error' => 'No authorization token provided']));
}

// Verify session
$stmt = $mysqli->prepare('SELECT user_id FROM user_sessions WHERE session_token = ? AND expires_at > NOW()');
$stmt->bind_param('s', $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(401);
    die(json_encode(['error' => 'Invalid or expired session']));
}

$session = $result->fetch_assoc();
$user_id = $session['user_id'];

// Check if requesting another user's info
$requested_user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : $user_id;

// Get user data
$stmt = $mysqli->prepare('SELECT id, username, email, first_name, last_name, profile_photo, last_login FROM users WHERE id = ?');
$stmt->bind_param('i', $requested_user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    die(json_encode(['error' => 'User not found']));
}

$user = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'user' => [
        'id' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'profile_photo' => $user['profile_photo'],
        'last_login' => $user['last_login']
    ]
]);
?>