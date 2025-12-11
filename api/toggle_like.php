<?php
require_once 'config.php';
require_once 'auth_helpers.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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
$userInfo = verifySession($mysqli, $token);

if (!$userInfo) {
    http_response_code(401);
    die(json_encode(['error' => 'Invalid or expired session']));
}

$user_id = $userInfo['user_id'];

// Get post_id from request
$input = json_decode(file_get_contents('php://input'), true);
$post_id = isset($input['post_id']) ? intval($input['post_id']) : 0;

if (!$post_id) {
    http_response_code(400);
    die(json_encode(['error' => 'Post ID is required']));
}

// Get the post owner
$stmt = $mysqli->prepare('SELECT user_id FROM posts WHERE id = ?');
$stmt->bind_param('i', $post_id);
$stmt->execute();
$postResult = $stmt->get_result();
if ($postResult->num_rows === 0) {
    http_response_code(404);
    die(json_encode(['error' => 'Post not found']));
}
$post = $postResult->fetch_assoc();
$post_owner_id = $post['user_id'];

// Check if user already liked this post
$stmt = $mysqli->prepare('SELECT id FROM post_likes WHERE post_id = ? AND user_id = ?');
$stmt->bind_param('ii', $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Unlike - remove the like
    $stmt = $mysqli->prepare('DELETE FROM post_likes WHERE post_id = ? AND user_id = ?');
    $stmt->bind_param('ii', $post_id, $user_id);
    $stmt->execute();
    $liked = false;
    
    // Remove notification when unliked
    $stmt = $mysqli->prepare('DELETE FROM notifications WHERE from_user_id = ? AND post_id = ? AND type = "like"');
    $stmt->bind_param('ii', $user_id, $post_id);
    $stmt->execute();
} else {
    // Like - add the like
    $stmt = $mysqli->prepare('INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)');
    $stmt->bind_param('ii', $post_id, $user_id);
    $stmt->execute();
    $liked = true;
    
    // Create notification for post owner (only if not liking own post)
    if ($post_owner_id != $user_id) {
        // Check if notifications table exists
        $tableCheck = $mysqli->query("SHOW TABLES LIKE 'notifications'");
        if ($tableCheck && $tableCheck->num_rows > 0) {
            $stmt = $mysqli->prepare('INSERT INTO notifications (user_id, from_user_id, type, post_id) VALUES (?, ?, "like", ?)');
            $stmt->bind_param('iii', $post_owner_id, $user_id, $post_id);
            $stmt->execute();
        }
    }
}

// Get new like count
$stmt = $mysqli->prepare('SELECT COUNT(*) as count FROM post_likes WHERE post_id = ?');
$stmt->bind_param('i', $post_id);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc()['count'];

echo json_encode([
    'success' => true,
    'liked' => $liked,
    'like_count' => intval($count)
]);

$mysqli->close();
?>
