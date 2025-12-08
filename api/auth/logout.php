<?php
require "db.php";

if (isset($_COOKIE["session_token"])) {
    $token = $_COOKIE["session_token"];

    $stmt = $conn->prepare("DELETE FROM sessions WHERE token=?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    setcookie("session_token", "", time() - 3600, "/");
}

echo json_encode(["success" => true]);
?>
