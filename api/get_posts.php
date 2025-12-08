<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Auto-create availability_dates column if it doesn't exist
$colCheck = $mysqli->query("SHOW COLUMNS FROM posts LIKE 'availability_dates'");
if ($colCheck && $colCheck->num_rows === 0) {
    $mysqli->query("ALTER TABLE posts ADD COLUMN availability_dates TEXT DEFAULT NULL AFTER content");
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

// Check if post_likes table exists
$likesTableExists = false;
$tableCheck = $mysqli->query("SHOW TABLES LIKE 'post_likes'");
if ($tableCheck && $tableCheck->num_rows > 0) {
    $likesTableExists = true;
}

// Get posts with user info and like counts (if likes table exists)
try {
    if ($likesTableExists) {
        $stmt = $mysqli->prepare('
            SELECT p.*, u.first_name, u.last_name, u.username,
                   (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id) as like_count,
                   (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id AND user_id = ?) as user_liked
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            ORDER BY p.created_at DESC 
            LIMIT 50
        ');
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $mysqli->error);
        }
        $stmt->bind_param('i', $user_id);
    } else {
        $stmt = $mysqli->prepare('
            SELECT p.*, u.first_name, u.last_name, u.username
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            ORDER BY p.created_at DESC 
            LIMIT 50
        ');
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $mysqli->error);
        }
    }

    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }
    
    $result = $stmt->get_result();
    if (!$result) {
        throw new Exception('Get result failed: ' . $stmt->error);
    }
} catch (Exception $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}

$posts = [];

while ($row = $result->fetch_assoc()) {
    $availability_dates = null;
    if (isset($row['availability_dates']) && $row['availability_dates']) {
        $availability_dates = json_decode($row['availability_dates'], true);
    }
    
    $posts[] = [
        'id' => $row['id'],
        'content' => $row['content'],
        'created_at' => $row['created_at'],
        'user_id' => $row['user_id'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'username' => $row['username'],
        'availability_dates' => $availability_dates,
        'like_count' => isset($row['like_count']) ? intval($row['like_count']) : 0,
        'user_liked' => isset($row['user_liked']) ? intval($row['user_liked']) > 0 : false
    ];
}

echo json_encode($posts);