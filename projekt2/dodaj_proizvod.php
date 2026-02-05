<?php
session_start();
include "spoj.php";

if (!isset($_SESSION['prijavljen'])) {
    header("Location: prijava.php");
    exit();
}

if ($_SESSION['uloga'] !== 'admin') {
    header("Location: ispis.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj proizvod</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">WebShop</div>
    <button class="nav-toggle" onclick="toggleNav()">☰</button>
    <div class="nav-links" id="navLinks">
        <a href="ispis.php">Ispis proizvoda</a>
        <a href="proizvodi.php">Proizvodi</a>
        <a href="kosarica.php">Košarica</a>
        <a href="moje_narudzbe.php">Moje narudžbe</a>
        <a href="odjava.php">Odjava</a>
    </div>
</nav>

<h2 class="page-title">Dodaj novi proizvod</h2>

<div class="form-container">
    <form action="unos.php" method="post" class="form-box">

        <label>Naziv proizvoda:</label>
        <input type="text" name="naziv" required>

        <label>Opis:</label>
        <textarea name="opis" required></textarea>

        <label>Količina:</label>
        <input type="number" name="kolicina" min="0" required>

        <label>Cijena (€):</label>
        <input type="number" step="0.01" name="cijena" min="0" required>

        <label>URL slike:</label>
        <input type="url" name="slika" required>

        <button type="submit" class="submit-btn">Unesi proizvod</button>
    </form>
</div>

<script>
function toggleNav() {
    document.getElementById("navLinks").classList.toggle("open");
}
</script>
<footer class="footer">
    <p>@Josip Stjepić</p>
    <p>2025 / 2026</p>
</footer>

</body>
</html>
