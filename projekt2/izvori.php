<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izvori</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">WebShop</div>
    <button class="nav-toggle" onclick="toggleNav()">☰</button>
    <div class="nav-links" id="navLinks">
        <a href="index.html">Početna</a>
       
    </div>
</nav>

<h2 class="page-title">Izvori</h2>

<div style="text-align:center; line-height:1.8;">
    <p>1. W3Schools</p>
    <p>2. ChatGPT</p>
    <p>3. Merlin – predlošci s LV-ova</p>
    <p>4. Cysecor</p>
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
