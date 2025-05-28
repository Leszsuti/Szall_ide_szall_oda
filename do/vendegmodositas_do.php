<?php
session_start();
include "../datab.php";
$email_old=$_POST['email_old'];
$email_new = $_POST['email_new'];
$nev=$_POST['nev'];
$szuldat=$_POST['szuldat'];
$telefonszam=$_POST['telefonszam'];
if($email_old=="" || $email_new=="" || $nev=="" || $telefonszam=="" || $szuldat=="" || $email_old==null || $email_new==null || $nev==null || $telefonszam==null || $szuldat==null){
    $_SESSION["error_vendegmodositas"]="Por favor llene todos los campos";
}else{
    if(adatbazis_update_vendeg($email_old,$email_new,$nev,$szuldat,$telefonszam)==false){
        $_SESSION["error_vendegmodositas"]="Foglalt e-mail";
    }else{
        $_SESSION["error_vendegmodositas"]="Sikeres módosítás";
    }
}
header("location:../view/vendegek_view.php");


?>
