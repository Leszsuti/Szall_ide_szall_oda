<?php
session_start();
include "../datab.php";
$megnevezes=$_POST["megnevezes"];
$fekvohelyek_szama=$_POST["fekvohelyek_szama"];
$leiras=$_POST['leiras'];
$napi_ar=$_POST["napi_ar"];

if($megnevezes=="" || $fekvohelyek_szama=="" || $leiras=="" || $napi_ar==""){
    $_SESSION["error_tipusfelvetel"]="Minden adatot kötelező megadni";
}else{
    if(adatbazis_insert_tipus($megnevezes,$fekvohelyek_szama,$leiras,$napi_ar)==false){
        $_SESSION["error_tipusfelvetel"]="Ez a szobatípus már fel lett véve régebben";
    }else{
        $_SESSION["error_tipusfelvetel"]="Sikeres felvétel";
    }
}
header("Location: ../view/szobak_view.php");
exit();

?>