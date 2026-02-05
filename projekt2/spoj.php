<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "trgovina";

// Kreiranje MySQLi objektne konekcije
$conn = new mysqli($servername, $username, $password, $dbname);

// Provjera povezanosti
if ($conn->connect_error) {
    die("Povezivanje na bazu nije uspjelo: " . $conn->connect_error);
}

// Ako želiš provjeriti da radi, otkomentiraj:
// echo "Spojeno na bazu!";
?>
