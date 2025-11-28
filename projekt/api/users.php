<?php
require "db.php";
require "utils.php";

session_start();

$action = $_GET["action"] ?? "";


// ----------------------------------------
// REGISTER
// ----------------------------------------
if ($action === "register") {

    requirePost();

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // provjera postoji li user
    $check = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check->execute([$username, $email]);
    if ($check->rowCount() > 0) {
        jsonResponse(["success" => false, "message" => "Korisnik već postoji!"]);
    }

    $sql = "INSERT INTO users (username, email, password, role) VALUES (?,?,?, 'user')";
    $stmt = $db->prepare($sql);

    try {
        $stmt->execute([$username, $email, $password]);
        jsonResponse(["success" => true, "message" => "Registracija uspješna!"]);
    } catch (PDOException $e) {
        jsonResponse(["success" => false, "message" => "Greška: " . $e->getMessage()]);
    }
}



// ----------------------------------------
// LOGIN
// ----------------------------------------
if ($action === "login") {

    requirePost();

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];   // dodano!
        $_SESSION["role"] = $user["role"];           // dodano!

        jsonResponse([
            "success" => true,
            "message" => "Prijava uspješna",
            "role" => $user["role"]
        ]);

    } else {
        jsonResponse(["success" => false, "message" => "Neispravni podaci"]);
    }
}



// ----------------------------------------
// LOGOUT
// ----------------------------------------
if ($action === "logout") {
    session_destroy();
    jsonResponse(["success" => true, "message" => "Odjavljeni ste"]);
}



// ----------------------------------------
// SESSION CHECK (bitno za dinamicki navbar)
// ----------------------------------------
if ($action === "session") {

    if (isset($_SESSION["user_id"])) {
        jsonResponse([
            "logged_in" => true,
            "user_id"   => $_SESSION["user_id"],
            "username"  => $_SESSION["username"],
            "role"      => $_SESSION["role"]
        ]);
    } else {
        jsonResponse(["logged_in" => false]);
    }
}



// ----------------------------------------
// DEFAULT – unknown action
// ----------------------------------------
jsonResponse(["error" => "Nepoznata akcija"]);

?>
