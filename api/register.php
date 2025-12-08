<?php
declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Method not allowed']));
}

// Get and log POST data
$input = file_get_contents('php://input');
error_log('Received input: ' . $input);

$data = json_decode($input, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    die(json_encode([
        'error' => 'Invalid JSON: ' . json_last_error_msg(),
        'received' => $input
    ]));
}

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$name = $data['name'] ?? '';
$interests = $data['interests'] ?? [];

// Split full name into first and last name
$nameParts = explode(' ', trim($name), 2);
$firstName = $nameParts[0] ?? '';
$lastName = $nameParts[1] ?? '';

// Validate data
if (empty($email) || empty($password) || empty($name)) {
    http_response_code(400);
    die(json_encode(['error' => 'All fields are required']));
}

// Ensure we have both first and last name
if (empty($lastName)) {
    http_response_code(400);
    die(json_encode(['error' => 'Please enter your full name (first and last name)']));
}

// Validate RPI email
if (!str_ends_with($email, '@rpi.edu')) {
    http_response_code(400);
    die(json_encode(['error' => 'Please use your RPI email address']));
}

// Extract username from email
$username = substr($email, 0, strpos($email, '@'));

try {
    error_log("Starting user registration for email: " . $email);
    
    // Start transaction
    if (!$mysqli->begin_transaction()) {
        error_log("Failed to start transaction: " . $mysqli->error);
        throw new Exception('Failed to start transaction');
    }
    
    error_log("Transaction started successfully");

    // Check if email already exists
    $stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ?');
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        throw new Exception('Database prepare failed');
    }
    
    $stmt->bind_param('s', $email);
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        throw new Exception('Database execute failed');
    }
    
    $result = $stmt->get_result();
    if (!$result) {
        error_log("Get result failed: " . $stmt->error);
        throw new Exception('Database get result failed');
    }
    
    if ($result->num_rows > 0) {
        error_log("Email already exists: " . $email);
        throw new Exception('Email already registered');
    }
    
    error_log("Email check passed successfully");

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $mysqli->prepare('INSERT INTO users (username, email, password_hash, first_name, last_name) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $username, $email, $password_hash, $firstName, $lastName);
    $stmt->execute();
    $user_id = $mysqli->insert_id;

    // Insert interests if any
    if (!empty($interests)) {
        $stmt = $mysqli->prepare('INSERT INTO user_preferences (user_id, category, preference) VALUES (?, ?, ?)');
        foreach ($interests as $interest) {
            $category = $interest['category'] ?? 'general';
            $preference = $interest['label'] ?? '';
            if (!empty($preference)) {
                $stmt->bind_param('iss', $user_id, $category, $preference);
                $stmt->execute();
            }
        }
    }

    // Generate session token
    $session_token = bin2hex(random_bytes(32));
    $expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

    // Create session
    $stmt = $mysqli->prepare('INSERT INTO user_sessions (user_id, session_token, ip_address, user_agent, expires_at) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('issss', $user_id, $session_token, $ip, $user_agent, $expires_at);
    $stmt->execute();

    // Commit transaction
    $mysqli->commit();

    // Return success
    echo json_encode([
        'success' => true,
        'session_token' => $session_token,
        'expires_at' => $expires_at
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $mysqli->rollback();
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}