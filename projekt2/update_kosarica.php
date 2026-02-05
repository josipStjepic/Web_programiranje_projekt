<?php
session_start();

$id = $_POST['id'];
$akcija = $_POST['akcija']; // plus ili minus

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

echo json_encode(["status" => "success"]);
