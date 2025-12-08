<?php
/**
 * Cleanup Expired Password Reset Tokens
 * Run this periodically (e.g., via cron job) to clean up expired tokens
 */

require_once '../config.php';

try {
    // Delete tokens that have expired
    $stmt = $mysqli->prepare("DELETE FROM password_reset_tokens WHERE expires_at < NOW()");
    
    if ($stmt->execute()) {
        $deletedCount = $stmt->affected_rows;
        echo json_encode([
            'success' => true,
            'message' => "Cleaned up $deletedCount expired token(s)",
            'deleted_count' => $deletedCount
        ]);
        error_log("Cleanup: Deleted $deletedCount expired password reset tokens");
    } else {
        throw new Exception('Failed to cleanup tokens: ' . $mysqli->error);
    }

} catch (Exception $e) {
    error_log('Cleanup error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

$mysqli->close();
?>

