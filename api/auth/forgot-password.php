<?php
/**
 * Forgot Password API Endpoint
 * Generates a password reset token and sends an email to the user
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config.php';

try {
    // Get JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!isset($data['email']) || empty($data['email'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Email address is required'
        ]);
        exit();
    }

    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email address format'
        ]);
        exit();
    }

    // Check if user exists
    $stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // For security, don't reveal if email exists or not
        // Return success message anyway
        echo json_encode([
            'success' => true,
            'message' => 'If an account exists with this email, you will receive a password reset link shortly.'
        ]);
        exit();
    }

    $user = $result->fetch_assoc();
    $userId = $user['id'];

    // Generate a secure random token
    $token = bin2hex(random_bytes(32));
    
    // Token expires in 1 hour
    $expiresAt = date('Y-m-d H:i:s', time() + 3600);

    // Delete any existing tokens for this user
    $deleteStmt = $mysqli->prepare("DELETE FROM password_reset_tokens WHERE user_id = ?");
    $deleteStmt->bind_param("i", $userId);
    $deleteStmt->execute();

    // Insert new token
    $insertStmt = $mysqli->prepare(
        "INSERT INTO password_reset_tokens (user_id, email, token, expires_at) VALUES (?, ?, ?, ?)"
    );
    $insertStmt->bind_param("isss", $userId, $email, $token, $expiresAt);

    if (!$insertStmt->execute()) {
        throw new Exception('Failed to create reset token');
    }

    // Create reset link (adjust the URL to match your domain)
    $resetLink = "http://localhost:8000/auth/reset-password.html?token=" . $token;

/*
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'your-email@gmail.com';
    $mail->Password   = 'your-app-password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('noreply@resonance.com', 'Resonance');
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Request - Resonance';
    $mail->Body    = "
        <html>
        <body>
            <h2>Password Reset Request</h2>
            <p>Click the link below to reset your password:</p>
            <p><a href='$resetLink'>Reset Password</a></p>
            <p>This link will expire in 1 hour.</p>
        </body>
        </html>
    ";

    $mail->send();
} catch (Exception $e) {
    error_log("Email failed: {$mail->ErrorInfo}");
}
*/
    // For development: log the reset link
    error_log("Password reset link for $email: $resetLink");

    echo json_encode([
        'success' => true,
        'message' => 'If an account exists with this email, you will receive a password reset link shortly.',
        // Remove this in production! Only for development/testing
        'debug_reset_link' => $resetLink
    ]);

} catch (Exception $e) {
    error_log('Forgot password error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again later.'
    ]);
}

$mysqli->close();
?>

