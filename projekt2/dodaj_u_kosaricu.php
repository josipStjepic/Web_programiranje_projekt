<?php
session_start();

if (!isset($_SESSION['prijavljen'])) {
    echo json_encode(["status" => "error", "message" => "Niste prijavljeni"]);
    exit();
}

$id       = $_POST['id'];
$naziv    = $_POST['naziv'];
$cijena   = $_POST['cijena'];
$kolicina = $_POST['kolicina'];

if (!isset($_SESSION['kosarica'])) {
    $_SESSION['kosarica'] = [];
}

// Ako isti proizvod postoji → povećaj količinu
$found = false;
foreach ($_SESSION['kosarica'] as &$stavka) {
    if ($stavka['id'] == $id) {
        $stavka['kolicina'] += $kolicina;
        $found = true;
        break;
    }
}

if (!$found) {
    $_SESSION['kosarica'][] = [
        'id' => $id,
        'naziv' => $naziv,
        'cijena' => $cijena,
        'kolicina' => $kolicina
    ];
}

echo json_encode(["status" => "success"]);
