<?php
session_start();
include "spoj.php";

if (!isset($_SESSION['prijavljen'])) {
    header("Location: prijava.php");
    exit();
}

$korisnik_id = $_SESSION['id'];

$sql = "SELECT * FROM narudzbe WHERE korisnik_id = ? ORDER BY datum DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $korisnik_id);
$stmt->execute();
$rez = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje narudžbe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">WebShop</div>
    <button class="nav-toggle" onclick="toggleNav()">☰</button>
    <div class="nav-links" id="navLinks">
        <?php if ($_SESSION['uloga'] === 'admin'): ?>
    <a href="dodaj_proizvod.php">Dodaj proizvod</a>
    <a href="ispis.php">Ispis proizvoda</a>
<?php endif; ?>
        <a href="proizvodi.php">Proizvodi</a>
        <a href="kosarica.php">Košarica</a>
        <a href="odjava.php">Odjava</a>
    </div>
</nav>

<h2 class="page-title">Moje narudžbe</h2>

<?php if ($rez->num_rows > 0): ?>

<div class="grid-container">

<?php while ($row = $rez->fetch_assoc()): ?>
    <div class="card">

        <h3>Narudžba #<?= $row['id'] ?></h3>

        <p class="cijena">Datum: <?= $row['datum'] ?></p>
        <p class="cijena">Ukupno: <?= $row['ukupna_cijena'] ?> €</p>

        <a href="moje_narudzbe_detalji.php?id=<?= $row['id'] ?>" 
           style="margin-top:15px; display:inline-block; padding:10px 15px; background:#1a1a1a; color:white; border-radius:6px; text-decoration:none;">
           Otvori
        </a>

    </div>
<?php endwhile; ?>

</div>

<?php else: ?>
<p class="empty-cart">Nemaš još narudžbi.</p>
<?php endif; ?>

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
