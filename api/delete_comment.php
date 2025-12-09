<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
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

// Get request body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['comment_id'])) {
    http_response_code(400);
    die(json_encode(['error' => 'Comment ID is required']));
}

$comment_id = intval($data['comment_id']);

// Verify comment exists and belongs to user
$stmt = $mysqli->prepare('SELECT id, post_id, user_id FROM post_comments WHERE id = ?');
$stmt->bind_param('i', $comment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    die(json_encode(['error' => 'Comment not found']));
}

$comment = $result->fetch_assoc();

// Check if user owns the comment
if ($comment['user_id'] != $user_id) {
    http_response_code(403);
    die(json_encode(['error' => 'You can only delete your own comments']));
}

$post_id = $comment['post_id'];

// Delete all replies to this comment first (cascade)
$stmt = $mysqli->prepare('DELETE FROM post_comments WHERE parent_id = ?');
$stmt->bind_param('i', $comment_id);
$stmt->execute();

// Delete the comment
$stmt = $mysqli->prepare('DELETE FROM post_comments WHERE id = ?');
$stmt->bind_param('i', $comment_id);

if (!$stmt->execute()) {
    http_response_code(500);
    die(json_encode(['error' => 'Failed to delete comment']));
}

// Get updated comment count for the post
$stmt = $mysqli->prepare('SELECT COUNT(*) as count FROM post_comments WHERE post_id = ?');
$stmt->bind_param('i', $post_id);
$stmt->execute();
$countResult = $stmt->get_result()->fetch_assoc();

echo json_encode([
    'success' => true,
    'post_id' => $post_id,
    'comment_count' => intval($countResult['count'])
]);

