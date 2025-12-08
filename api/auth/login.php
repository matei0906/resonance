<?php
require "db.php";

$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"];
$password = $data["password"];

$stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(["success" => false, "error" => "Invalid email"]);
    exit;
}

$stmt->bind_result($id, $hashed);
$stmt->fetch();

if (!password_verify($password, $hashed)) {
    echo json_encode(["success" => false, "error" => "Wrong password"]);
    exit;
}

$token = bin2hex(random_bytes(32));
$expires = date("Y-m-d H:i:s", time() + 60*60*24*7); // 7 days

$stmt2 = $conn->prepare("INSERT INTO sessions (user_id, token, expires_at) VALUES (?, ?, ?)");
$stmt2->bind_param("iss", $id, $token, $expires);
$stmt2->execute();

setcookie("session_token", $token, time()+60*60*24*7, "/", "", false, true);

echo json_encode(["success" => true]);
?>
