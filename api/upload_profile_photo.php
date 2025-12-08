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

// Check if file was uploaded
if (!isset($_FILES['profile_photo']) || $_FILES['profile_photo']['error'] !== UPLOAD_ERR_OK) {
    $error = $_FILES['profile_photo']['error'] ?? 'No file uploaded';
    http_response_code(400);
    die(json_encode(['error' => 'File upload failed: ' . $error]));
}

$file = $_FILES['profile_photo'];
$allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$max_size = 5 * 1024 * 1024; // 5MB

// Validate file type
if (!in_array($file['type'], $allowed_types)) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.']));
}

// Validate file size
if ($file['size'] > $max_size) {
    http_response_code(400);
    die(json_encode(['error' => 'File size exceeds 5MB limit.']));
}

// Validate file is actually an image
$image_info = getimagesize($file['tmp_name']);
if (!$image_info) {
    http_response_code(400);
    die(json_encode(['error' => 'Uploaded file is not a valid image.']));
}

// Ensure uploads directory exists and is writable
$upload_dir = __DIR__ . '/../assets/images/uploads/';
if (!is_dir($upload_dir)) {
    if (!mkdir($upload_dir, 0755, true)) {
        http_response_code(500);
        die(json_encode(['error' => 'Failed to create uploads directory.']));
    }
}
if (!is_writable($upload_dir)) {
    http_response_code(500);
    die(json_encode(['error' => 'Uploads directory is not writable.']));
}

// Generate unique filename
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$unique_name = uniqid('profile_', true) . '.' . $extension;
$target_path = $upload_dir . $unique_name;

// Move uploaded file
if (!move_uploaded_file($file['tmp_name'], $target_path)) {
    http_response_code(500);
    die(json_encode(['error' => 'Failed to save uploaded file.']));
}

// Update database with photo URL (absolute path for web access)
$photo_url = '/assets/images/uploads/' . $unique_name;
$stmt = $mysqli->prepare('UPDATE users SET profile_photo = ? WHERE id = ?');
$stmt->bind_param('si', $photo_url, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'photo_url' => $photo_url]);
} else {
    // Clean up file if DB update fails
    unlink($target_path);
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update profile photo in database.']);
}
?>