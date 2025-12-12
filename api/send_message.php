<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get authorization token
$headers = getallheaders();
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
$token = str_replace('Bearer ', '', $auth_header);

if (!$token) {
    http_response_code(401);
    die(json_encode(['success' => false, 'error' => 'No authorization token provided']));
}

// Verify session
$stmt = $mysqli->prepare('SELECT user_id FROM user_sessions WHERE session_token = ? AND expires_at > NOW()');
$stmt->bind_param('s', $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(401);
    die(json_encode(['success' => false, 'error' => 'Invalid or expired session']));
}

$session = $result->fetch_assoc();
$sender_id = $session['user_id'];

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['receiver_id']) || !isset($data['message'])) {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => 'Missing required fields']));
}

$receiver_id = intval($data['receiver_id']);
$message = trim($data['message']);

if (empty($message)) {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => 'Message cannot be empty']));
}

if ($sender_id === $receiver_id) {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => 'Cannot send message to yourself']));
}

// Verify receiver exists
$stmt = $mysqli->prepare('SELECT id FROM users WHERE id = ?');
$stmt->bind_param('i', $receiver_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    die(json_encode(['success' => false, 'error' => 'Receiver not found']));
}

// Insert message
$stmt = $mysqli->prepare('INSERT INTO messages (sender_id, receiver_id, message, created_at) VALUES (?, ?, ?, NOW())');
$stmt->bind_param('iis', $sender_id, $receiver_id, $message);

if (!$stmt->execute()) {
    http_response_code(500);
    die(json_encode(['success' => false, 'error' => 'Failed to send message']));
}

$message_id = $mysqli->insert_id;

echo json_encode([
    'success' => true,
    'message_id' => $message_id,
    'created_at' => date('Y-m-d H:i:s')
]);
?>
