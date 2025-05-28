<?php
session_start();
$_SESSION=[];
include "../datab.php";
$username = $_POST['username'];
$name = $_POST['name'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
if($password !== $password2){
    $_SESSION["error_regist"]=2;
    header("Location: ../view/regist_view.php");
    exit();
}else{
    if(adatbazis_insert_felhasznalo($username, $name, $password)==false){
        $_SESSION["error_regist"]=1;
        header("Location: ../view/regist_view.php");
        exit();
    }else{
        $_SESSION["error_regist"]=0;
        header("Location: ../view/regist_view.php");
        exit();
    }
}

?>
