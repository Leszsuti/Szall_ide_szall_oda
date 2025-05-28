<?php
session_start();
include "../datab.php";
$szobaszam_old=$_POST["szobaszam_old"];
$szobaszam_new=$_POST["szobaszam_new"];
$tipusazonosito=$_POST["tipusazonosito"];
if(isset($_POST["szobaszam_old"]) &&  isset($_POST["szobaszam_new"]) && $szobaszam_new!=null){
    if(adatbazis_update_szoba($szobaszam_old,$szobaszam_new,$tipusazonosito)){
        $_SESSION["error_szobamodositas"]="Sikeres módosítás";
    }else{
        $_SESSION["error_szobamodositas"]="Már foglalt a szobaszám";
    }
}else{
    $_SESSION["error_szobamodositas"]="A szobaszámot kötelező megadni";
}
header("location:../view/szobak_view.php");
