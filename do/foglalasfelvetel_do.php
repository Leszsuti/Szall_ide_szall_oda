<?php
session_start();
include "../datab.php";
$email=$_POST["email"];
$szobaszam=$_POST["szobaszam"];
$mettol=$_POST["mettol"];
$meddig=$_POST["meddig"];

if(isset($_POST["email"]) && isset($_POST["szobaszam"]) && isset($_POST["mettol"]) && isset($_POST["meddig"])){
    if(adatbazis_insert_foglalas($email, $szobaszam, $mettol, $meddig)){
        $_SESSION["error_foglalas"]="Sikeres foglalás ($email , Szoba: $szobaszam , $mettol - $meddig)";
    }else{
        $_SESSION["error_foglalas"]="Sikertelen foglalás";
    }
}else{
    $_SESSION["error_foglalas"]="Mindent mezőt ki kell tölteni";
}
header("location:../view/foglalasok_view.php");
