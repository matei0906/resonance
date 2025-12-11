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

// Auto-create comments table if it doesn't exist (without foreign keys for compatibility)
$tableCheck = $mysqli->query("SHOW TABLES LIKE 'post_comments'");
if ($tableCheck && $tableCheck->num_rows === 0) {
    $mysqli->query("
        CREATE TABLE post_comments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            post_id INT NOT NULL,
            user_id INT NOT NULL,
            parent_id INT DEFAULT NULL,
            content TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_post_id (post_id),
            INDEX idx_parent_id (parent_id)
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

// Get request body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['post_id']) || !isset($data['content'])) {
    http_response_code(400);
    die(json_encode(['error' => 'Post ID and content are required']));
}

$post_id = intval($data['post_id']);
$content = trim($data['content']);
$parent_id = isset($data['parent_id']) ? intval($data['parent_id']) : null;

if (empty($content)) {
    http_response_code(400);
    die(json_encode(['error' => 'Comment content cannot be empty']));
}

// Verify post exists and get owner
$stmt = $mysqli->prepare('SELECT id, user_id FROM posts WHERE id = ?');
$stmt->bind_param('i', $post_id);
$stmt->execute();
$postResult = $stmt->get_result();
if ($postResult->num_rows === 0) {
    http_response_code(404);
    die(json_encode(['error' => 'Post not found']));
}
$post = $postResult->fetch_assoc();
$post_owner_id = $post['user_id'];

// If parent_id provided, verify it exists and belongs to the same post
if ($parent_id) {
    $stmt = $mysqli->prepare('SELECT id FROM post_comments WHERE id = ? AND post_id = ?');
    $stmt->bind_param('ii', $parent_id, $post_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        http_response_code(400);
        die(json_encode(['error' => 'Parent comment not found']));
    }
}

// Insert comment
if ($parent_id) {
    $stmt = $mysqli->prepare('INSERT INTO post_comments (post_id, user_id, parent_id, content) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('iiis', $post_id, $user_id, $parent_id, $content);
} else {
    $stmt = $mysqli->prepare('INSERT INTO post_comments (post_id, user_id, content) VALUES (?, ?, ?)');
    $stmt->bind_param('iis', $post_id, $user_id, $content);
}

if (!$stmt->execute()) {
    http_response_code(500);
    die(json_encode(['error' => 'Failed to create comment: ' . $stmt->error]));
}

$comment_id = $mysqli->insert_id;

// Create notification for post owner (only if not commenting on own post)
if ($post_owner_id != $user_id) {
    // Check if notifications table exists
    $tableCheck = $mysqli->query("SHOW TABLES LIKE 'notifications'");
    if ($tableCheck && $tableCheck->num_rows > 0) {
        $stmt = $mysqli->prepare('INSERT INTO notifications (user_id, from_user_id, type, post_id, comment_id) VALUES (?, ?, "comment", ?, ?)');
        $stmt->bind_param('iiii', $post_owner_id, $user_id, $post_id, $comment_id);
        $stmt->execute();
    }
}

// Fetch the created comment with user info
$stmt = $mysqli->prepare('
    SELECT c.*, u.first_name, u.last_name, u.username
    FROM post_comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.id = ?
');
$stmt->bind_param('i', $comment_id);
$stmt->execute();
$comment = $stmt->get_result()->fetch_assoc();

echo json_encode([
    'success' => true,
    'comment' => [
        'id' => $comment['id'],
        'post_id' => $comment['post_id'],
        'user_id' => $comment['user_id'],
        'parent_id' => $comment['parent_id'],
        'content' => $comment['content'],
        'created_at' => $comment['created_at'],
        'first_name' => $comment['first_name'],
        'last_name' => $comment['last_name'],
        'username' => $comment['username']
    ]
]);
