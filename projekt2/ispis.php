<?php
session_start();
include "spoj.php";

if (!isset($_SESSION['prijavljen'])) {
    header("Location: prijava.php");
    exit();
}

$sql = "SELECT * FROM proizvodi";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ispis proizvoda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">WebShop</div>
    <button class="nav-toggle" onclick="toggleNav()">☰</button>
    <div class="nav-links" id="navLinks">
        <a href="dodaj_proizvod.php">Dodaj proizvod</a>
        <a href="proizvodi.php">Proizvodi</a>
        <a href="kosarica.php">Košarica</a>
        <a href="moje_narudzbe.php">Moje narudžbe</a>
        <a href="odjava.php">Odjava</a>
    </div>
</nav>

<h2 class="page-title">Popis proizvoda</h2>

<div class="grid-container">

<?php while($row = $result->fetch_assoc()): ?>
    <div class="card">

        <?php if(!empty($row['slika'])): ?>
            <img src="<?= $row['slika'] ?>" class="product-img">
        <?php else: ?>
            <div class="no-img">Nema slike</div>
        <?php endif; ?>

        <h3><?= htmlspecialchars($row['nazivProizvod']) ?></h3>

        <p class="opis"><?= htmlspecialchars($row['opis']) ?></p>

        <p class="cijena">Količina: <?= $row['kolicina'] ?></p>
        <p class="cijena">Cijena: <?= $row['cijena'] ?> €</p>

        <?php if($_SESSION['uloga'] == 'admin'): ?>
            <div style="margin-top:15px; display:flex; justify-content:center; gap:15px;">
                <a href="obrisi.php?id=<?= $row['id'] ?>" 
                   style="padding:8px 12px; background:#c62828; color:white; border-radius:6px; text-decoration:none;"
                   onclick="return confirm('Jeste li sigurni da želite obrisati proizvod?')">
                   Obriši
                </a>

                <a href="izmjena.php?id=<?= $row['id'] ?>" 
                   style="padding:8px 12px; background:#1a1a1a; color:white; border-radius:6px; text-decoration:none;">
                   Uredi
                </a>
            </div>
        <?php endif; ?>

    </div>
<?php endwhile; ?>

</div>



<script>
function toggleNav() {
    document.getElementById("navLinks").classList.toggle("open");
}
</script>

</body>
</html>
