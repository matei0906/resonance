<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
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
$current_user_id = $session['user_id'];

// Category weights for match scoring (only genres and availability)
$category_weights = [
    'genres' => 50,              // 50% weight
    'availability' => 50         // 50% weight
];

try {
    // Get current user's preferences
    $stmt = $mysqli->prepare('SELECT category, preference FROM user_preferences WHERE user_id = ?');
    $stmt->bind_param('i', $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $current_user_prefs = [
        'genres' => [],
        'instruments' => [],
        'instrument_interests' => [],
        'availability' => []
    ];
    
    while ($row = $result->fetch_assoc()) {
        $category = $row['category'];
        if (isset($current_user_prefs[$category])) {
            $current_user_prefs[$category][] = strtolower($row['preference']);
        }
    }
    
    // Get all other users with their preferences
    $sql = "
        SELECT 
            u.id,
            u.username,
            u.first_name,
            u.last_name,
            u.email,
            u.profile_photo,
            up.category,
            up.preference
        FROM users u
        LEFT JOIN user_preferences up ON u.id = up.user_id
        WHERE u.id != ?
        ORDER BY u.id
    ";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Group preferences by user
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['id'];
        
        if (!isset($users[$user_id])) {
            $users[$user_id] = [
                'id' => $user_id,
                'username' => $row['username'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'profile_photo' => $row['profile_photo'],
                'preferences' => [
                    'genres' => [],
                    'instruments' => [],
                    'instrument_interests' => [],
                    'availability' => []
                ]
            ];
        }
        
        if ($row['category'] && $row['preference']) {
            $category = $row['category'];
            if (isset($users[$user_id]['preferences'][$category])) {
                $users[$user_id]['preferences'][$category][] = strtolower($row['preference']);
            }
        }
    }
    
    // Calculate match scores
    $matches = [];
    
    foreach ($users as $user_id => $user) {
        $score_breakdown = [];
        $total_score = 0;
        $total_possible = 0;
        
        // Only calculate for genres and availability
        foreach ($category_weights as $category => $weight) {
            $current_prefs = $current_user_prefs[$category];
            $other_prefs = $user['preferences'][$category];
            
            // Skip if either user has no preferences in this category
            if (empty($current_prefs) && empty($other_prefs)) {
                continue;
            }
            
            // Calculate overlap
            $common = array_intersect($current_prefs, $other_prefs);
            $common_count = count($common);
            
            // Use Jaccard similarity: intersection / union
            $union = array_unique(array_merge($current_prefs, $other_prefs));
            $union_count = count($union);
            
            if ($union_count > 0) {
                $category_score = ($common_count / $union_count) * $weight;
                $total_score += $category_score;
                $total_possible += $weight;
                
                $score_breakdown[$category] = [
                    'common' => array_values($common),
                    'score' => round($category_score, 1),
                    'max' => $weight
                ];
            }
        }
        
        // Cross-match: Your instrument interests vs their instruments (they know what you want to learn)
        $can_teach_you = array_intersect(
            $current_user_prefs['instrument_interests'],
            $user['preferences']['instruments']
        );
        
        // Cross-match: Your instruments vs their instrument interests (they want to learn what you know)
        $you_can_teach = array_intersect(
            $current_user_prefs['instruments'],
            $user['preferences']['instrument_interests']
        );
        
        // Calculate base percentage from genres and availability
        $base_percentage = $total_possible > 0 ? ($total_score / $total_possible) * 100 : 0;
        
        // Apply exponential boost for each skill exchange match
        $cross_match_count = count($can_teach_you) + count($you_can_teach);
        $match_percentage = $base_percentage;
        
        if ($cross_match_count > 0) {
            // Exponential boost: each match multiplies the score
            // Formula: base + (100 - base) * (1 - e^(-0.5 * matches))
            // This gives diminishing returns but significant boosts
            $boost_factor = 1 - exp(-0.5 * $cross_match_count);
            $boost = (100 - $base_percentage) * $boost_factor;
            $match_percentage = $base_percentage + $boost;
            
            // Ensure minimum of 30% if there's at least one skill exchange match
            $match_percentage = max($match_percentage, 30 + ($cross_match_count * 10));
        }
        
        // Cap at 100%
        $match_percentage = min(round($match_percentage), 100);
        
        // Only include users with at least some match OR cross-match
        if ($match_percentage > 0 || $cross_match_count > 0) {
            $matches[] = [
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'name' => trim($user['first_name'] . ' ' . $user['last_name']),
                    'profile_photo' => $user['profile_photo']
                ],
                'match_percentage' => $match_percentage,
                'breakdown' => $score_breakdown,
                'common_interests' => [
                    'genres' => $score_breakdown['genres']['common'] ?? [],
                    'availability' => $score_breakdown['availability']['common'] ?? []
                ],
                'skill_exchange' => [
                    'can_teach_you' => array_values($can_teach_you),
                    'you_can_teach' => array_values($you_can_teach)
                ]
            ];
        }
    }
    
    // Sort by match percentage (highest first)
    usort($matches, function($a, $b) {
        return $b['match_percentage'] - $a['match_percentage'];
    });
    
    // Limit to top 20 matches
    $matches = array_slice($matches, 0, 20);
    
    echo json_encode([
        'success' => true,
        'matches' => $matches,
        'total_found' => count($matches)
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>

