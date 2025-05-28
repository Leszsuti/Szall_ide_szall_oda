<?php
session_start();
include "../datab.php";
$szobaszam=$_POST["szobaszam"];
$tipusazonosito=$_POST["tipusazonosito"];

if(isset($_POST["szobaszam"]) && isset($_POST["tipusazonosito"])){
    if(adatbazis_insert_szoba($szobaszam,$tipusazonosito)){
        $_SESSION["error_szobafelvetel"]="Sikeres felvétel";
    }else{
        $_SESSION["error_szobafelvetel"]="Ez a szobaszám már létezik";
    }
}else{
    $_SESSION["error_szobafelvetel"]="Mindent mezőt ki kell tölteni";
}
header("location:../view/szobak_view.php");
