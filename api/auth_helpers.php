<?php
/**
 * Authentication and Authorization Helper Functions
 */

/**
 * Get the current user's role from the session token
 * @param mysqli $mysqli Database connection
 * @param string $token Session token
 * @return string|null User role ('administrator' or 'user') or null if not found
 */
function getUserRole($mysqli, $token) {
    $stmt = $mysqli->prepare('
        SELECT u.role 
        FROM user_sessions s
        JOIN users u ON s.user_id = u.id
        WHERE s.session_token = ? AND s.expires_at > NOW()
    ');
    
    if (!$stmt) {
        return null;
    }
    
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return null;
    }
    
    $row = $result->fetch_assoc();
    return $row['role'] ?? 'user'; // Default to 'user' if role is null
}

/**
 * Check if the current user is an administrator
 * @param mysqli $mysqli Database connection
 * @param string $token Session token
 * @return bool True if user is administrator, false otherwise
 */
function isAdministrator($mysqli, $token) {
    $role = getUserRole($mysqli, $token);
    return $role === 'administrator';
}

/**
 * Get user ID from session token
 * @param mysqli $mysqli Database connection
 * @param string $token Session token
 * @return int|null User ID or null if not found
 */
function getUserIdFromToken($mysqli, $token) {
    $stmt = $mysqli->prepare('SELECT user_id FROM user_sessions WHERE session_token = ? AND expires_at > NOW()');
    
    if (!$stmt) {
        return null;
    }
    
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return null;
    }
    
    $row = $result->fetch_assoc();
    return intval($row['user_id']);
}

/**
 * Verify session and return user info
 * @param mysqli $mysqli Database connection
 * @param string $token Session token
 * @return array|null Array with user_id and role, or null if invalid
 */
function verifySession($mysqli, $token) {
    $stmt = $mysqli->prepare('
        SELECT s.user_id, u.role 
        FROM user_sessions s
        JOIN users u ON s.user_id = u.id
        WHERE s.session_token = ? AND s.expires_at > NOW()
    ');
    
    if (!$stmt) {
        return null;
    }
    
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return null;
    }
    
    $row = $result->fetch_assoc();
    return [
        'user_id' => intval($row['user_id']),
        'role' => $row['role'] ?? 'user'
    ];
}

