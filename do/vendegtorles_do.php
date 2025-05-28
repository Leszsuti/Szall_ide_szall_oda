<?php
session_start();
include "../datab.php";

if (isset($_POST["email_torol"])) {
    $email = $_POST["email_torol"];
    if (adatbazis_delete_vendeg($email)) {
        $_SESSION["torles_uzenet"] = "Sikeres törlés.";
    } else {
        $_SESSION["torles_uzenet"] = "Sikertelen törlés.";
    }
}
header("Location: ../view/vendegek_view.php");
exit;
?>
