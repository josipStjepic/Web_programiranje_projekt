<?php
require "db.php";
require "utils.php";

$action = $_GET["action"] ?? "";

/* Spremanje narudžbe */
if ($action === "create") {

    requirePost();
    requireLogin();

    $user_id = $_SESSION["user_id"];
    $cart = json_decode($_POST["cart"], true);

    foreach ($cart as $product_id) {
        $sql = "INSERT INTO orders (user_id, product_id, order_date)
                VALUES (?, ?, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$user_id, $product_id]);
    }

    jsonResponse(["success" => true, "message" => "Narudžba spremljena"]);
}

/* Admin: pregled narudžbi */
if ($action === "list") {
    $q = $db->query("SELECT * FROM orders");
    jsonResponse($q->fetchAll(PDO::FETCH_ASSOC));
}

jsonResponse(["error" => "Nepoznata akcija"]);
?>
