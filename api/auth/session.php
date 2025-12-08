<?php
require "../db.php";

if (!isset($_COOKIE["session_token"])) {
    echo json_encode(["logged_in" => false]);
    exit;
}

$token = $_COOKIE["session_token"];

$stmt = $conn->prepare("
    SELECT users.id, users.email
    FROM sessions
    JOIN users ON sessions.user_id = users.id
    WHERE sessions.token = ? AND sessions.expires_at > NOW()
");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(["logged_in" => false]);
    exit;
}

$stmt->bind_result($id, $email);
$stmt->fetch();

echo json_encode([
    "logged_in" => true,
    "id" => $id,
    "email" => $email
]);
?>
