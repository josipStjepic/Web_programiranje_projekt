<?php
session_start();

$id = $_POST['id'];

if (!isset($_SESSION['kosarica'])) {
    echo json_encode(["status" => "error"]);
    exit();
}

foreach ($_SESSION['kosarica'] as $key => &$stavka) {
    if ($stavka['id'] == $id) {

        // smanji količinu
        $stavka['kolicina']--;

        // ako je količina 0 → izbriši stavku
        if ($stavka['kolicina'] <= 0) {
            unset($_SESSION['kosarica'][$key]);
        }

        echo json_encode(["status" => "success"]);
        exit();
    }
}

echo json_encode(["status" => "not_found"]);
