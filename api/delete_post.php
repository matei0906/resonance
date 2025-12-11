<?php
require_once 'config.php';
require_once 'auth_helpers.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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

// Verify session and get user info including role
$userInfo = verifySession($mysqli, $token);

if (!$userInfo) {
    http_response_code(401);
    die(json_encode(['error' => 'Invalid or expired session']));
}

$user_id = $userInfo['user_id'];
$is_admin = $userInfo['role'] === 'administrator';

// Get post_id from request
$input = json_decode(file_get_contents('php://input'), true);
$post_id = isset($input['post_id']) ? intval($input['post_id']) : 0;

if (!$post_id) {
    http_response_code(400);
    die(json_encode(['error' => 'Post ID is required']));
}

// Verify the post exists
$stmt = $mysqli->prepare('SELECT user_id FROM posts WHERE id = ?');
$stmt->bind_param('i', $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    die(json_encode(['error' => 'Post not found']));
}

$post = $result->fetch_assoc();

// Check if user owns the post OR is an administrator
if ($post['user_id'] != $user_id && !$is_admin) {
    http_response_code(403);
    die(json_encode(['error' => 'You can only delete your own posts']));
}

// Delete the post (admins can delete any post)
$stmt = $mysqli->prepare('DELETE FROM posts WHERE id = ?');
$stmt->bind_param('i', $post_id);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Post deleted successfully'
    ]);
} else {
    http_response_code(500);
    die(json_encode(['error' => 'Failed to delete post']));
}

$mysqli->close();
?>
