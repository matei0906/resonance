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
$user_id = $session['user_id'];

// Get other user ID
if (!isset($_GET['user_id'])) {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => 'Missing user_id parameter']));
}

$other_user_id = intval($_GET['user_id']);

// Get messages between the two users
$stmt = $mysqli->prepare('
    SELECT 
        m.id,
        m.sender_id,
        m.receiver_id,
        m.message,
        m.created_at,
        u.first_name,
        u.last_name
    FROM messages m
    JOIN users u ON u.id = m.sender_id
    WHERE (m.sender_id = ? AND m.receiver_id = ?) 
       OR (m.sender_id = ? AND m.receiver_id = ?)
    ORDER BY m.created_at ASC
');
$stmt->bind_param('iiii', $user_id, $other_user_id, $other_user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'id' => $row['id'],
        'sender_id' => $row['sender_id'],
        'receiver_id' => $row['receiver_id'],
        'message' => $row['message'],
        'created_at' => $row['created_at'],
        'sender_name' => $row['first_name'] . ' ' . $row['last_name'],
        'is_sent' => $row['sender_id'] == $user_id
    ];
}

echo json_encode([
    'success' => true,
    'messages' => $messages
]);
?>
