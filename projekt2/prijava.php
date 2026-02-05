<?php
session_start();
include "spoj.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $lozinka = $_POST['lozinka'];

    $sql = "SELECT * FROM korisnici WHERE e_mail=? AND lozinka=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $lozinka);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $korisnik = $result->fetch_assoc();

        $_SESSION['prijavljen'] = true;
        $_SESSION['username'] = $korisnik['e_mail'];
        $_SESSION['ime'] = $korisnik['ime'];
        $_SESSION['prezime'] = $korisnik['prezime'];
        $_SESSION['uloga'] = $korisnik['uloga'];
        $_SESSION['id'] = $korisnik['id'];

        if ($korisnik['uloga'] === "admin") {
            header("Location: dodaj_proizvod.php");
            exit();
        } else {
            header("Location: proizvodi.php");
            exit();
        }

    } else {
        header("Location: prijava.php?error=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-brand">WebShop</div>

    <button class="nav-toggle" onclick="toggleNav()">☰</button>

    <div class="nav-links" id="navLinks">
        <a href="index.html">Početna</a>
        <a href="proizvodi.php">Proizvodi</a>
        <a href="registracija.php">Registracija</a>
    </div>
</nav>

<!-- LOGIN FORM -->
<div class="login-container">
    <h2>Prijava korisnika</h2>

    <?php
    if (isset($_GET['error'])) {
        echo "<p class='error-msg'>Pogrešan email ili lozinka!</p>";
    }
    ?>

    <form method="POST" action="prijava.php" class="login-form">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Lozinka:</label>
        <input type="password" name="lozinka" required>

        <button type="submit">Prijavi se</button>
    </form>

    <div class="login-links">
        <a href="registracija.php">Registracija</a>
        <a href="index.html">Povratak na početnu</a>
    </div>
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
