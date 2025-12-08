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

if (!isset($data['preferences']) || !is_array($data['preferences'])) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid preferences data']));
}

// Start transaction
$mysqli->begin_transaction();

try {
    // Delete existing preferences
    $stmt = $mysqli->prepare('DELETE FROM user_preferences WHERE user_id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    // Insert new preferences
    if (!empty($data['preferences'])) {
        $stmt = $mysqli->prepare('INSERT INTO user_preferences (user_id, category, preference) VALUES (?, ?, ?)');
        foreach ($data['preferences'] as $pref) {
            if (!isset($pref['category']) || !isset($pref['label'])) {
                throw new Exception('Invalid preference format');
            }
            $stmt->bind_param('iss', $user_id, $pref['category'], $pref['label']);
            $stmt->execute();
        }
    }

    $mysqli->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    $mysqli->rollback();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>