<?php
session_start();
include "../datab.php";
$szoba_torol=$_POST['szoba_torol'];
if(adatbazis_delete_szoba($szoba_torol)){
    $_SESSION["torlesszoba_uzenet"]="Sikeres törlés";
}else{
    $_SESSION["torlesszoba_uzenet"]="Sikertelen törlés";
}
header("location:../view/szobak_view.php");