<?php
declare(strict_types=1);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require __DIR__ . '/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = $_POST ?: [];
}

$content = isset($input['content']) ? trim((string)$input['content']) : '';

if ($content === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Post content cannot be empty']);
    exit;
}

$userId = (int)$_SESSION['user_id'];

$stmt = $mysqli->prepare('INSERT INTO posts (user_id, content) VALUES (?, ?)');
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error']);
    exit;
}

$stmt->bind_param('is', $userId, $content);

if (!$stmt->execute()) {
    $stmt->close();
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to create post']);
    exit;
}

$postId = $stmt->insert_id;
$stmt->close();

echo json_encode([
    'success' => true,
    'post_id' => $postId,
    'message' => 'Post created successfully'
]);
