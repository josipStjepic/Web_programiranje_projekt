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
    <title>Proizvodi</title>
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
        <a href="kosarica.php">Košarica</a>
        <a href="odjava.php">Odjava</a>
    </div>
</nav>

<h2 class="page-title">Proizvodi</h2>

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
        <p class="cijena"><?= $row['cijena'] ?> €</p>

        <div class="buy-box">
            <input type="number" class="kol" value="1" min="1">
            <button class="dodaj"
                data-id="<?= $row['id'] ?>"
                data-naziv="<?= htmlspecialchars($row['nazivProizvod']) ?>"
                data-cijena="<?= $row['cijena'] ?>">
                Dodaj u košaricu
            </button>
        </div>

    </div>
<?php endwhile; ?>

</div>

<script>
function toggleNav() {
    document.getElementById("navLinks").classList.toggle("open");
}

document.querySelectorAll(".dodaj").forEach(btn => {
    btn.addEventListener("click", () => {

        const id = btn.dataset.id;
        const naziv = btn.dataset.naziv;
        const cijena = btn.dataset.cijena;

        const kolicinaInput = btn.parentElement.querySelector(".kol");
        const kolicina = parseInt(kolicinaInput.value);

        const formData = new FormData();
        formData.append("id", id);
        formData.append("naziv", naziv);
        formData.append("cijena", cijena);
        formData.append("kolicina", kolicina);

        fetch("dodaj_u_kosaricu.php", {
            method: "POST",
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === "success") {
                
            }
        });
    });
});
</script>
<footer class="footer">
    <p>@Josip Stjepić</p>
    <p>2025 / 2026</p>
</footer>

</body>
</html>
