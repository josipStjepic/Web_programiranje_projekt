<?php
session_start();
include "spoj.php";

if (!isset($_SESSION['prijavljen'])) {
    header("Location: prijava.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Nedostaje ID narudžbe.");
}

$narudzba_id = $_GET['id'];
$korisnik_id = $_SESSION['id'];

$sql = "SELECT * FROM narudzbe WHERE id = ? AND korisnik_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $narudzba_id, $korisnik_id);
$stmt->execute();
$narudzba = $stmt->get_result()->fetch_assoc();

if (!$narudzba) {
    die("Nemaš pristup ovoj narudžbi.");
}

$sql = "SELECT ns.*, p.nazivProizvod, p.slika 
        FROM narudzbe_stavke ns
        JOIN proizvodi p ON ns.proizvod_id = p.id
        WHERE ns.narudzba_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $narudzba_id);
$stmt->execute();
$stavke = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalji narudžbe</title>
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
        <a href="moje_narudzbe.php">Moje narudžbe</a>
        <a href="proizvodi.php">Proizvodi</a>
        <a href="kosarica.php">Košarica</a>
        <a href="odjava.php">Odjava</a>
    </div>
</nav>

<h2 class="page-title">Detalji narudžbe #<?= $narudzba_id ?></h2>

<div style="text-align:center; margin-bottom:20px;">
    <p><strong>Datum:</strong> <?= $narudzba['datum'] ?></p>
    <p><strong>Ukupno:</strong> <?= $narudzba['ukupna_cijena'] ?> €</p>
</div>

<div class="grid-container">

<?php while ($s = $stavke->fetch_assoc()): ?>
    <div class="card">

        <?php if (!empty($s['slika'])): ?>
            <img src="<?= $s['slika'] ?>" class="product-img">
        <?php else: ?>
            <div class="no-img">Nema slike</div>
        <?php endif; ?>

        <h3><?= htmlspecialchars($s['nazivProizvod']) ?></h3>

        <p class="cijena">Količina: <?= $s['kolicina'] ?></p>
        <p class="cijena">Cijena: <?= $s['cijena'] ?> €</p>
        <p class="cijena">Ukupno: <?= $s['cijena'] * $s['kolicina'] ?> €</p>

    </div>
<?php endwhile; ?>

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
