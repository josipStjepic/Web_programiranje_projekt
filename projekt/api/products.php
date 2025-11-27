<?php
require "db.php";
require "utils.php";

$action = $_GET["action"] ?? "";

/* GET – dohvati sve proizvode */
if ($_SERVER["REQUEST_METHOD"] === "GET" && !$action) {
    $q = $db->query("SELECT * FROM products");
    jsonResponse($q->fetchAll(PDO::FETCH_ASSOC));
}

/* CREATE */
if ($action === "create") {

    requirePost();

    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $image = $_POST["image"];

    $sql = "INSERT INTO products (name, description, price, stock, image) VALUES (?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $description, $price, $stock, $image]);

    jsonResponse(["success" => true]);
}

/* DELETE */
if ($action === "delete") {

    $id = $_GET["id"];

    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    jsonResponse(["success" => true]);
}

/* UPDATE – možeš koristiti kasnije */
if ($action === "update") {

    requirePost();

    $id = $_POST["id"];
    $name = $_POST["name"];
    $desc = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];

    $sql = "UPDATE products SET name=?, description=?, price=?, stock=? WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $desc, $price, $stock, $id]);

    jsonResponse(["success" => true]);
}

jsonResponse(["error" => "Nepoznata akcija"]);
?>
