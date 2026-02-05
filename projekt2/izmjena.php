<?php
session_start();
include "spoj.php";

if (!isset($_SESSION['prijavljen']) || $_SESSION['uloga'] !== 'admin') {
    header("Location: prijava.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id       = $_POST['id'];
    $naziv    = $_POST['naziv'];
    $opis     = $_POST['opis'];
    $kolicina = $_POST['kolicina'];
    $cijena   = $_POST['cijena'];
    $slika    = $_POST['slika'];

    $sql = "UPDATE proizvodi SET nazivProizvod=?, opis=?, kolicina=?, cijena=?, slika=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssidsi", $naziv, $opis, $kolicina, $cijena, $slika, $id);
    $stmt->execute();

    header("Location: ispis.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM proizvodi WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $proizvod = $result->fetch_assoc();

    if (!$proizvod) {
        header("Location: ispis.php");
        exit();
    }
} else {
    header("Location: ispis.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi proizvod</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">WebShop</div>
    <button class="nav-toggle" onclick="toggleNav()">☰</button>
    <div class="nav-links" id="navLinks">
        <a href="dodaj_proizvod.php">Dodaj proizvod</a>
        <a href="ispis.php">Ispis proizvoda</a>
        <a href="proizvodi.php">Proizvodi</a>
        <a href="moje_narudzbe.php">Moje narudžbe</a>
        <a href="kosarica.php">Košarica</a>
        <a href="odjava.php">Odjava</a>
    </div>
</nav>

<h2 class="page-title">Uredi proizvod</h2>

<div class="form-container">
    <form action="izmjena.php" method="post" class="form-box">

        <input type="hidden" name="id" value="<?= $proizvod['id'] ?>">

        <label>Naziv proizvoda:</label>
        <input type="text" name="naziv" value="<?= $proizvod['nazivProizvod'] ?>" required>

        <label>Opis:</label>
        <textarea name="opis" required><?= $proizvod['opis'] ?></textarea>

        <label>Količina:</label>
        <input type="number" name="kolicina" value="<?= $proizvod['kolicina'] ?>" min="0" required>

        <label>Cijena (€):</label>
        <input type="number" step="0.01" name="cijena" value="<?= $proizvod['cijena'] ?>" required>

        <label>URL slike:</label>
        <input type="url" name="slika" value="<?= $proizvod['slika'] ?>" required>

        <button type="submit" class="submit-btn">Spremi promjene</button>
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
