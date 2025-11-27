<?php
require "db.php";
require "utils.php";

session_start();

$action = $_GET["action"] ?? "";

if ($action === "register") {

    requirePost();

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, role) VALUES (?,?,?, 'user')";
    $stmt = $db->prepare($sql);

    try {
        $stmt->execute([$username, $email, $password]);
        jsonResponse(["success" => true, "message" => "Registracija uspješna!"]);
    } catch (PDOException $e) {
        jsonResponse(["success" => false, "message" => "Greška: " . $e->getMessage()]);
    }
}

if ($action === "login") {

    requirePost();

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];
        jsonResponse(["success" => true, "message" => "Prijava uspješna"]);
    } 
    else {
        jsonResponse(["success" => false, "message" => "Neispravni podaci"]);
    }
}

if ($action === "logout") {
    session_destroy();
    jsonResponse(["success" => true, "message" => "Odjavljeni ste"]);
}

jsonResponse(["error" => "Nepoznata akcija"]);

?>
