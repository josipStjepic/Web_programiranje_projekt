<?php
session_start();
include "spoj.php";

// Ako je forma poslana
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ime      = $_POST['ime'];
    $prezime  = $_POST['prezime'];
    $email    = $_POST['email'];
    $lozinka  = $_POST['lozinka'];
    $uloga    = 'korisnik';

    // Provjera emaila
    $sql_check = "SELECT * FROM korisnici WHERE e_mail=?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Email već postoji. Odaberi drugi.";
    } else {
        // Ubacivanje u bazu
        $sql_insert = "INSERT INTO korisnici (ime, prezime, e_mail, lozinka, uloga)
                       VALUES (?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql_insert);
        $stmt2->bind_param("sssss", $ime, $prezime, $email, $lozinka, $uloga);
        $stmt2->execute();

        header("Location: prijava.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
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
        <a href="prijava.php">Prijava</a>
    </div>
</nav>

<!-- REGISTRATION FORM -->
<div class="login-container">
    <h2>Registracija korisnika</h2>

    <?php
    if (isset($error)) {
        echo "<p class='error-msg'>$error</p>";
    }
    ?>

    <form method="POST" action="registracija.php" class="login-form">
        <label>Ime:</label>
        <input type="text" name="ime" required>

        <label>Prezime:</label>
        <input type="text" name="prezime" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Lozinka:</label>
        <input type="password" name="lozinka" required>

        <button type="submit">Registriraj se</button>
    </form>

    <div class="login-links">
        <a href="prijava.php">Prijava</a>
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
