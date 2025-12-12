<?php
declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Method not allowed']));
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (empty($email) || empty($password)) {
    http_response_code(400);
    die(json_encode(['error' => 'Email and password are required']));
}

// Prevent SQL injection using prepared statements
$stmt = $mysqli->prepare('SELECT id, username, password_hash FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    // Log failed attempt
    $stmt = $mysqli->prepare('INSERT INTO login_attempts (username, ip_address, success) VALUES (?, ?, false)');
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt->bind_param('ss', $email, $ip);
    $stmt->execute();
    
    http_response_code(401);
    die(json_encode(['error' => 'Email or password is incorrect.']));
}

// Verify password
if (password_verify($password, $user['password_hash'])) {
    // Generate session token
    $session_token = bin2hex(random_bytes(32));
    $user_id = $user['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));
    $expires_timestamp = strtotime('+24 hours') * 1000; // Convert to milliseconds for JS

    // Create session
    $stmt = $mysqli->prepare('INSERT INTO user_sessions (user_id, session_token, ip_address, user_agent, expires_at) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('issss', $user_id, $session_token, $ip, $user_agent, $expires_at);
    $stmt->execute();

    // Log successful login
    $stmt = $mysqli->prepare('INSERT INTO login_attempts (username, ip_address, success) VALUES (?, ?, true)');
    $stmt->bind_param('ss', $email, $ip);
    $stmt->execute();

    // Update last login
    $stmt = $mysqli->prepare('UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    echo json_encode([
        'success' => true,
        'session_token' => $session_token,
        'expires_at' => $expires_timestamp
    ]);
} else {
    // Log failed attempt
    $stmt = $mysqli->prepare('INSERT INTO login_attempts (username, ip_address, success) VALUES (?, ?, false)');
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt->bind_param('ss', $email, $ip);
    $stmt->execute();

    http_response_code(401);
    echo json_encode(['error' => 'Email or password is incorrect.']);
}