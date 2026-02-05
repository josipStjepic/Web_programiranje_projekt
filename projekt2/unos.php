<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proizvod unesen</title>
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

        <?php if ($_SESSION['uloga'] === 'admin'): ?>
            <a href="dodaj_proizvod.php">Dodaj proizvod</a>
        <?php endif; ?>

        <a href="odjava.php">Odjava</a>
    </div>
</nav>

<h2 class="page-title">Proizvod je uspješno unesen!</h2>

<div class="form-container" style="text-align:center;">
    <a href="dodaj_proizvod.php" class="submit-btn" style="display:inline-block; margin-bottom:15px;">
        Unesi novi proizvod
    </a>

    <a href="ispis.php" class="submit-btn" style="display:inline-block;">
        Ispis proizvoda
    </a>
</div>

<footer class="footer">
    <p>@Josip Stjepić</p>
    <p>2025 / 2026</p>
</footer>

<script>
function toggleNav() {
    document.getElementById("navLinks").classList.toggle("open");
}
</script>

</body>
</html>

