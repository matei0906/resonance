<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Method not allowed']));
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['password']) || empty($data['password'])) {
    http_response_code(400);
    die(json_encode(['error' => 'Password is required']));
}

$password = $data['password'];

// Verify password
$stmt = $mysqli->prepare('SELECT password_hash FROM users WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    die(json_encode(['error' => 'User not found']));
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password_hash'])) {
    http_response_code(401);
    die(json_encode(['error' => 'Incorrect password']));
}

// Start transaction
$mysqli->begin_transaction();

try {
    // Delete user's post likes
    $stmt = $mysqli->prepare('DELETE FROM post_likes WHERE user_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }

    // Delete likes on user's posts
    $stmt = $mysqli->prepare('DELETE pl FROM post_likes pl INNER JOIN posts p ON pl.post_id = p.id WHERE p.user_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }

    // Delete user's comments
    $stmt = $mysqli->prepare('DELETE FROM post_comments WHERE user_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }

    // Delete comments on user's posts
    $stmt = $mysqli->prepare('DELETE pc FROM post_comments pc INNER JOIN posts p ON pc.post_id = p.id WHERE p.user_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }

    // Delete user's posts
    $stmt = $mysqli->prepare('DELETE FROM posts WHERE user_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }

    // Delete user's notifications
    $stmt = $mysqli->prepare('DELETE FROM notifications WHERE user_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }

    // Delete user's preferences
    $stmt = $mysqli->prepare('DELETE FROM user_preferences WHERE user_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }

    // Delete user's sessions
    $stmt = $mysqli->prepare('DELETE FROM user_sessions WHERE user_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }

    // Finally, delete the user
    $stmt = $mysqli->prepare('DELETE FROM users WHERE id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception('Failed to delete user');
    }

    // Commit transaction
    $mysqli->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Account deleted successfully'
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $mysqli->rollback();
    http_response_code(500);
    echo json_encode(['error' => 'Failed to delete account: ' . $e->getMessage()]);
}
?>

