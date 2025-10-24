<?php
declare(strict_types=1);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require __DIR__ . '/config.php';

// Get all posts with user information
$query = "
    SELECT 
        posts.id,
        posts.content,
        posts.created_at,
        users.name as user_name,
        users.id as user_id
    FROM posts
    JOIN users ON posts.user_id = users.id
    ORDER BY posts.created_at DESC
    LIMIT 50
";

$result = $mysqli->query($query);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error']);
    exit;
}

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = [
        'id' => (int)$row['id'],
        'content' => $row['content'],
        'user_name' => $row['user_name'],
        'user_id' => (int)$row['user_id'],
        'created_at' => $row['created_at'],
    ];
}

echo json_encode([
    'success' => true,
    'posts' => $posts
]);
