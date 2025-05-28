<?php
session_start();
include "../datab.php";

if (isset($_POST["tipus_torol"])) {
    $tipus = $_POST["tipus_torol"];
    if (adatbazis_delete_tipus($tipus)) {
        $_SESSION["torles_uzenet"] = "Sikeres törlés.";
    } else {
        $_SESSION["torles_uzenet"] = "Sikertelen törlés.";
    }
}
header("Location: ../view/szobak_view.php");
exit;
?>

