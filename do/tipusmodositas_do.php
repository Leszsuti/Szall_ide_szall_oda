<?php
session_start();
include "../datab.php";
$tipusazonosito=$_POST['tipusazonosito'];
$megnevezes = $_POST['megnevezes'];
$fekvohelyek_szama = $_POST['fekvohelyek_szama'];
$leiras = $_POST['leiras'];
$napi_ar=$_POST['napi_ar'];

if($tipusazonosito=="" || $megnevezes=="" || $fekvohelyek_szama=="" || $leiras=="" || $napi_ar==""){
    $_SESSION["error_vendegmodositas"]="Por favor llene todos los campos";
}else{
    if(adatbazis_update_tipus($tipusazonosito,$megnevezes,$fekvohelyek_szama,$leiras,$napi_ar)==false){
        $_SESSION["error_tipusmodositas"]="Sikertelen módosítás";
    }else{
        $_SESSION["error_tipusmodositas"]="Sikeres módosítás";
    }
}
header("location:../view/szobak_view.php");


?>

