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

// Auto-create notifications table if it doesn't exist
$tableCheck = $mysqli->query("SHOW TABLES LIKE 'notifications'");
if ($tableCheck && $tableCheck->num_rows === 0) {
    $mysqli->query("
        CREATE TABLE notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            from_user_id INT NOT NULL,
            type ENUM('like', 'comment') NOT NULL,
            post_id INT NOT NULL,
            comment_id INT DEFAULT NULL,
            is_read BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user_id (user_id),
            INDEX idx_is_read (is_read),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
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

// Fetch notifications for the user
$stmt = $mysqli->prepare('
    SELECT 
        n.*,
        u.first_name as from_first_name,
        u.last_name as from_last_name,
        u.username as from_username,
        p.content as post_content,
        c.content as comment_content
    FROM notifications n
    JOIN users u ON n.from_user_id = u.id
    JOIN posts p ON n.post_id = p.id
    LEFT JOIN post_comments c ON n.comment_id = c.id
    WHERE n.user_id = ?
    ORDER BY n.created_at DESC
    LIMIT 50
');

if (!$stmt) {
    echo json_encode([
        'notifications' => [],
        'unread_count' => 0
    ]);
    exit;
}

$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'id' => intval($row['id']),
        'type' => $row['type'],
        'post_id' => intval($row['post_id']),
        'comment_id' => $row['comment_id'] ? intval($row['comment_id']) : null,
        'is_read' => (bool)$row['is_read'],
        'created_at' => $row['created_at'],
        'from_first_name' => $row['from_first_name'],
        'from_last_name' => $row['from_last_name'],
        'from_username' => $row['from_username'],
        'post_content' => $row['post_content'],
        'comment_content' => $row['comment_content']
    ];
}

// Get unread count
$stmt = $mysqli->prepare('SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = FALSE');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$countResult = $stmt->get_result()->fetch_assoc();

echo json_encode([
    'notifications' => $notifications,
    'unread_count' => intval($countResult['count'])
]);

