<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Method not allowed']));
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

// Get and validate post data
$input = json_decode(file_get_contents('php://input'), true);
$content = $input['content'] ?? '';
$availability_dates = isset($input['availability_dates']) ? json_encode($input['availability_dates']) : null;

if (empty($content)) {
    http_response_code(400);
    die(json_encode(['error' => 'Content is required']));
}

// Ensure availability_dates column exists - create if not
$columnCheck = $mysqli->query("SHOW COLUMNS FROM posts LIKE 'availability_dates'");
if (!$columnCheck || $columnCheck->num_rows === 0) {
    $mysqli->query("ALTER TABLE posts ADD COLUMN availability_dates TEXT DEFAULT NULL AFTER content");
}

// Create post with availability dates
if ($availability_dates) {
    $stmt = $mysqli->prepare('INSERT INTO posts (user_id, content, availability_dates) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $user_id, $content, $availability_dates);
} else {
    $stmt = $mysqli->prepare('INSERT INTO posts (user_id, content) VALUES (?, ?)');
    $stmt->bind_param('is', $user_id, $content);
}

if (!$stmt->execute()) {
    http_response_code(500);
    die(json_encode(['error' => 'Failed to create post: ' . $mysqli->error]));
}

$post_id = $mysqli->insert_id;

echo json_encode([
    'success' => true,
    'post_id' => $post_id
]);