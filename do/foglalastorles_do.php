<?php
session_start();
include "../datab.php";

if (isset($_POST["email"]) && isset($_POST["szobaszam"]) && isset($_POST["mettol"]) && isset($_POST["meddig"])) {
    $email = $_POST["email"];
    $szobaszam = $_POST["szobaszam"];
    $mettol = $_POST["mettol"];
    $meddig = $_POST["meddig"];
    if (adatbazis_delete_foglalas($szobaszam,$mettol)) {
        $_SESSION["torles_uzenet"] = "Sikeres törlés ($email , Szobaszam: $szobaszam , $mettol - $meddig)";
    } else {
        $_SESSION["torles_uzenet"] = "Sikertelen törlés.";
    }
}
header("Location: ../view/foglalasok_view.php");
exit;
?>