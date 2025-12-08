<?php
header('Content-Type: application/json');
session_start();

require_once 'db.php';

try {
    // Get JSON data from request
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['preferences']) || !is_array($data['preferences'])) {
        throw new Exception('Invalid preferences data');
    }
    
    // Start transaction
    $conn->begin_transaction();

    // Insert preferences
    $stmt = $conn->prepare("INSERT INTO user_preferences (user_id, category, preference) VALUES (?, ?, ?)");
    
    foreach ($data['preferences'] as $pref) {
        if (!isset($pref['category']) || !isset($pref['value'])) {
            throw new Exception('Invalid preference format');
        }
        $stmt->bind_param("iss", $_SESSION['user_id'], $pref['category'], $pref['value']);
        $stmt->execute();
    }

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Preferences saved successfully'
    ]);

} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollback();
    }
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>