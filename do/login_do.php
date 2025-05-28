<?php
session_start();
include "../datab.php";
$username = $_POST['username'];
$password = $_POST['password'];
$felhasznalo=(adatbazis_get_felhasznalo($username));
if($felhasznalo!=null && password_verify($password, $felhasznalo["jelszo"])){
    $_SESSION=[];
    $_SESSION["logged_in"] = true;
    $_SESSION["username"] = $felhasznalo["felhasznalonev"];
    $_SESSION["error"]=0;
    header("Location: ../view/login_view.php");
    exit();
}else{
    $_SESSION["error"]=1;
    header("Location: ../view/login_view.php");
    exit();
}
?>