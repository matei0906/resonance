<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
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
$stmt = $mysqli->prepare('SELECT user_id FROM user_sessions WHERE session_token = ? AND expires_at > NOW()');
$stmt->bind_param('s', $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(401);
    die(json_encode(['error' => 'Invalid or expired session']));
}

$session = $result->fetch_assoc();
$current_user_id = $session['user_id'];

// Get post_id from query params
if (!isset($_GET['post_id'])) {
    http_response_code(400);
    die(json_encode(['error' => 'Post ID is required']));
}

$post_id = intval($_GET['post_id']);

// Fetch all comments for the post
$stmt = $mysqli->prepare('
    SELECT c.*, u.first_name, u.last_name, u.username
    FROM post_comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.post_id = ?
    ORDER BY c.created_at ASC
');

if (!$stmt) {
    // Table might not have any comments yet, return empty
    echo json_encode([
        'comments' => [],
        'total_count' => 0
    ]);
    exit;
}

$stmt->bind_param('i', $post_id);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = [
        'id' => intval($row['id']),
        'post_id' => intval($row['post_id']),
        'user_id' => intval($row['user_id']),
        'parent_id' => $row['parent_id'] ? intval($row['parent_id']) : null,
        'content' => $row['content'],
        'created_at' => $row['created_at'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'username' => $row['username']
    ];
}

// Build threaded structure
function buildCommentTree($comments, $parentId = null) {
    $tree = [];
    foreach ($comments as $comment) {
        if ($comment['parent_id'] === $parentId) {
            $comment['replies'] = buildCommentTree($comments, $comment['id']);
            $tree[] = $comment;
        }
    }
    return $tree;
}

$threadedComments = buildCommentTree($comments);

echo json_encode([
    'comments' => $threadedComments,
    'total_count' => count($comments),
    'current_user_id' => intval($current_user_id)
]);
