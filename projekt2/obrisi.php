<?php
session_start();
include "spoj.php";

if (!isset($_SESSION['prijavljen']) || $_SESSION['uloga'] !== 'admin') {
    header("Location: prijava.php");
    exit();
}

// Dohvat ID proizvoda iz GET-a
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM proizvodi WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Vrati se na ispis proizvoda
header("Location: ispis.php");
exit();
?>
