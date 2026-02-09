<?php
session_start();

$id = $_POST['id'];
$akcija = $_POST['akcija'];

foreach ($_SESSION['kosarica'] as $key => &$stavka) {
    if ($stavka['id'] == $id) {
        if ($akcija === "plus") {
            $stavka['kolicina']++;
        }

        if ($akcija === "minus") {
            $stavka['kolicina']--;
            if ($stavka['kolicina'] <= 0) {
                unset($_SESSION['kosarica'][$key]);
            }
        }

        break;
    }
}

$_SESSION['kosarica'] = array_values($_SESSION['kosarica']);

echo json_encode([
    "status" => "success",
    "kosarica" => $_SESSION['kosarica']
]);
