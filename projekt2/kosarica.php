<?php
session_start();
include "spoj.php";

if (!isset($_SESSION['prijavljen'])) {
    header("Location: prijava.php");
    exit();
}

if (isset($_POST['naruci'])) {
    foreach ($_SESSION['kosarica'] as $stavka) {
        $sql = "SELECT kolicina FROM proizvodi WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $stavka['id']);
        $stmt->execute();
        $rez = $stmt->get_result()->fetch_assoc();

        if ($rez['kolicina'] < $stavka['kolicina']) {
            die("<h2>Nema dovoljno proizvoda na stanju za: " . htmlspecialchars($stavka['naziv']) . "</h2>
                 <a href='kosarica.php'>Natrag na košaricu</a>");
        }
    }

    $ukupno = 0;
    foreach ($_SESSION['kosarica'] as $stavka) {
        $ukupno += $stavka['cijena'] * $stavka['kolicina'];
    }

    $korisnik_id = $_SESSION['id'];
    $sql = "INSERT INTO narudzbe (korisnik_id, ukupna_cijena) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $korisnik_id, $ukupno);
    $stmt->execute();
    $narudzba_id = $stmt->insert_id;

    foreach ($_SESSION['kosarica'] as $stavka) {
        $sql = "INSERT INTO narudzbe_stavke (narudzba_id, proizvod_id, kolicina, cijena)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $narudzba_id, $stavka['id'], $stavka['kolicina'], $stavka['cijena']);
        $stmt->execute();

        $sql = "UPDATE proizvodi SET kolicina = kolicina - ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $stavka['kolicina'], $stavka['id']);
        $stmt->execute();
    }

    $_SESSION['kosarica'] = [];

    echo "<h2>Narudžba je uspješno poslana!</h2>";
    echo '<a href="proizvodi.php">Natrag na proizvode</a>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Košarica</title>
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

<h2 class="page-title">Vaša košarica</h2>

<div id="cartContainer">
<?php if (!empty($_SESSION['kosarica'])): ?>

<div class="grid-container" id="cartItems">

<?php 
$ukupno = 0;
foreach ($_SESSION['kosarica'] as $stavka): 
    $stavkaUkupno = $stavka['cijena'] * $stavka['kolicina'];
    $ukupno += $stavkaUkupno;
?>
    <div class="card" data-id="<?= $stavka['id'] ?>">
        <h3><?= htmlspecialchars($stavka['naziv']) ?></h3>
        <p class="cijena">Cijena: <?= $stavka['cijena'] ?> €</p>
        <p class="cijena ukupno">Ukupno: <?= $stavkaUkupno ?> €</p>

        <div class="cart-controls">
            <button class="minus" data-id="<?= $stavka['id'] ?>">-</button>
            <span class="kol"><?= $stavka['kolicina'] ?></span>
            <button class="plus" data-id="<?= $stavka['id'] ?>">+</button>
        </div>
    </div>
<?php endforeach; ?>

</div>

<h3 class="cart-total" id="totalPrice">Ukupno: <?= $ukupno ?> €</h3>

<form method="post" class="cart-order">
    <button type="submit" name="naruci">Pošalji narudžbu</button>
</form>

<?php else: ?>
<p class="empty-cart">Košarica je prazna.</p>
<?php endif; ?>
</div>

<script>
function toggleNav() {
    document.getElementById("navLinks").classList.toggle("open");
}

function updateKosarica(id, akcija) {
    const formData = new FormData();
    formData.append("id", id);
    formData.append("akcija", akcija);

    fetch("update_kosarica.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === "success") {
            renderKosarica(data.kosarica);
        }
    });
}

function renderKosarica(kosarica) {
    const container = document.getElementById("cartContainer");

    if (Object.keys(kosarica).length === 0) {
        container.innerHTML = "<p class='empty-cart'>Košarica je prazna.</p>";
        return;
    }

    let html = '<div class="grid-container" id="cartItems">';
    let ukupno = 0;

    for (const key in kosarica) {
        const s = kosarica[key];
        const stavkaUkupno = s.cijena * s.kolicina;
        ukupno += stavkaUkupno;

        html += `
        <div class="card" data-id="${s.id}">
            <h3>${s.naziv}</h3>
            <p class="cijena">Cijena: ${s.cijena} €</p>
            <p class="cijena ukupno">Ukupno: ${stavkaUkupno} €</p>

            <div class="cart-controls">
                <button class="minus" data-id="${s.id}">-</button>
                <span class="kol">${s.kolicina}</span>
                <button class="plus" data-id="${s.id}">+</button>
            </div>
        </div>`;
    }

    html += "</div>";
    html += `<h3 class="cart-total" id="totalPrice">Ukupno: ${ukupno} €</h3>
             <form method="post" class="cart-order">
                <button type="submit" name="naruci">Pošalji narudžbu</button>
             </form>`;

    container.innerHTML = html;

    document.querySelectorAll(".plus").forEach(btn => {
        btn.addEventListener("click", () => updateKosarica(btn.dataset.id, "plus"));
    });

    document.querySelectorAll(".minus").forEach(btn => {
        btn.addEventListener("click", () => updateKosarica(btn.dataset.id, "minus"));
    });
}

document.querySelectorAll(".plus").forEach(btn => {
    btn.addEventListener("click", () => updateKosarica(btn.dataset.id, "plus"));
});

document.querySelectorAll(".minus").forEach(btn => {
    btn.addEventListener("click", () => updateKosarica(btn.dataset.id, "minus"));
});
</script>

<footer class="footer">
    <p>@Josip Stjepić</p>
    <p>2025 / 2026</p>
</footer>

</body>
</html>
