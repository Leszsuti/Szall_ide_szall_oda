<?php
session_start();
include "../datab.php";
$nev = $_POST["nev"];
$email = $_POST["email"];
$telefonszam = $_POST["telefonszam"];
$szuldat=$_POST["szuldat"];
if($nev=="" || $email=="" || $telefonszam=="" || $szuldat==""){
    $_SESSION["error_vendegfelvetel"]="Minden adatot kötelező megadni";
}else if(strlen($telefonszam)>16){
    $_SESSION["error_vendegfelvetel"]="A telefonszám max 16 karakter hosszú lehet";
}else{
    if(adatbazis_insert_vendeg($email,$nev,$szuldat,$telefonszam)==false){
        $_SESSION["error_vendegfelvetel"]="Ez a vendég már fel lett véve régebben";
    }else{
        $_SESSION["error_vendegfelvetel"]="Sikeres felvétel";
    }
}
header("Location: ../view/vendegek_view.php");
exit();

?>