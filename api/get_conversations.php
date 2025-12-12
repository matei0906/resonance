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

// Get all conversations (users you've messaged with)
$stmt = $mysqli->prepare('
    SELECT 
        DISTINCT
        CASE 
            WHEN m.sender_id = ? THEN m.receiver_id
            ELSE m.sender_id
        END as other_user_id,
        u.first_name,
        u.last_name,
        u.profile_photo,
        (SELECT message FROM messages 
         WHERE (sender_id = ? AND receiver_id = other_user_id) 
            OR (sender_id = other_user_id AND receiver_id = ?)
         ORDER BY created_at DESC LIMIT 1) as last_message,
        (SELECT created_at FROM messages 
         WHERE (sender_id = ? AND receiver_id = other_user_id) 
            OR (sender_id = other_user_id AND receiver_id = ?)
         ORDER BY created_at DESC LIMIT 1) as last_message_at
    FROM messages m
    JOIN users u ON u.id = CASE 
        WHEN m.sender_id = ? THEN m.receiver_id
        ELSE m.sender_id
    END
    WHERE m.sender_id = ? OR m.receiver_id = ?
    ORDER BY last_message_at DESC
');
$stmt->bind_param('iiiiiiii', $user_id, $user_id, $user_id, $user_id, $user_id, $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$conversations = [];
while ($row = $result->fetch_assoc()) {
    $conversations[] = [
        'user_id' => $row['other_user_id'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'profile_photo' => $row['profile_photo'],
        'last_message' => $row['last_message'],
        'last_message_at' => $row['last_message_at']
    ];
}

echo json_encode([
    'success' => true,
    'conversations' => $conversations
]);
?>
