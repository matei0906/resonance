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

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = $_POST ?: [];
}

$name = isset($input['name']) ? trim((string)$input['name']) : '';
$email = isset($input['email']) ? trim((string)$input['email']) : '';
$password = isset($input['password']) ? (string)$input['password'] : '';

// Validation
if ($name === '' || $email === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

if (strpos($email, '@') === false) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid email format']);
    exit;
}

if (strlen($password) < 6) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Password must be at least 6 characters']);
    exit;
}

// Check if email already exists
$stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Query prepare failed']);
    exit;
}

$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    $stmt->close();
    http_response_code(409);
    echo json_encode(['success' => false, 'error' => 'Email already registered']);
    exit;
}
$stmt->close();

// Hash the password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$stmt = $mysqli->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Query prepare failed']);
    exit;
}

$stmt->bind_param('sss', $name, $email, $passwordHash);
if (!$stmt->execute()) {
    $stmt->close();
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to create account']);
    exit;
}

$userId = $stmt->insert_id;
$stmt->close();

// Auto-login the user by setting session
$_SESSION['user_id'] = $userId;
$_SESSION['email'] = $email;
$_SESSION['name'] = $name;

echo json_encode([
    'success' => true,
    'message' => 'Account created successfully',
    'user' => [
        'id' => $userId,
        'email' => $email,
        'name' => $name,
    ],
]);
