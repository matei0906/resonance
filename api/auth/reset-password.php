<?php
/**
 * Reset Password API Endpoint
 * Verifies the reset token and updates the user's password
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config.php';

try {
    // Handle GET request to verify token validity
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['token']) || empty($_GET['token'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Token is required'
            ]);
            exit();
        }

        $token = $_GET['token'];

        // Verify token exists and hasn't expired
        $stmt = $mysqli->prepare(
            "SELECT id, user_id, email, expires_at, used 
             FROM password_reset_tokens 
             WHERE token = ? AND used = 0"
        );
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid or expired reset token'
            ]);
            exit();
        }

        $tokenData = $result->fetch_assoc();
        $expiresAt = strtotime($tokenData['expires_at']);

        if ($expiresAt < time()) {
            echo json_encode([
                'success' => false,
                'message' => 'Reset token has expired'
            ]);
            exit();
        }

        echo json_encode([
            'success' => true,
            'message' => 'Token is valid',
            'email' => $tokenData['email']
        ]);
        exit();
    }

    // Handle POST request to reset password
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Validate input
        if (!isset($data['token']) || empty($data['token'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Token is required'
            ]);
            exit();
        }

        if (!isset($data['password']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Password is required'
            ]);
            exit();
        }

        $token = $data['token'];
        $newPassword = $data['password'];

        // Validate password strength
        if (strlen($newPassword) < 8) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Password must be at least 8 characters long'
            ]);
            exit();
        }

        // Verify token
        $stmt = $mysqli->prepare(
            "SELECT id, user_id, email, expires_at, used 
             FROM password_reset_tokens 
             WHERE token = ? AND used = 0"
        );
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Invalid or already used reset token'
            ]);
            exit();
        }

        $tokenData = $result->fetch_assoc();
        $expiresAt = strtotime($tokenData['expires_at']);

        if ($expiresAt < time()) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Reset token has expired'
            ]);
            exit();
        }

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update user's password
        $updateStmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
        $updateStmt->bind_param("si", $hashedPassword, $tokenData['user_id']);

        if (!$updateStmt->execute()) {
            throw new Exception('Failed to update password');
        }

        // Mark token as used
        $markUsedStmt = $mysqli->prepare("UPDATE password_reset_tokens SET used = 1 WHERE id = ?");
        $markUsedStmt->bind_param("i", $tokenData['id']);
        $markUsedStmt->execute();

        echo json_encode([
            'success' => true,
            'message' => 'Password has been reset successfully'
        ]);
        exit();
    }

} catch (Exception $e) {
    error_log('Reset password error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again later.'
    ]);
}

$mysqli->close();
?>

