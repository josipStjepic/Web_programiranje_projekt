<?php

function jsonResponse($data) {
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($data);
    exit;
}

function requirePost() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        jsonResponse(["error" => "Only POST allowed"]);
    }
}

function requireLogin() {
    session_start();
    if (!isset($_SESSION["user_id"])) {
        jsonResponse(["success" => false, "message" => "Niste prijavljeni"]);
    }
}

?>
