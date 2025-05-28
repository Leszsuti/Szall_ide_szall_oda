<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="../style/regist.css">
</head>
<body>
<?php
error_reporting(0);
include "../view/fejlec.php";
?>
<div class="outside">
    <h2>Regisztráció</h2>
    <form action="../do/regist_do.php" method="POST">
        <label for="username">Felhasználónév:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="name">Név:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="password">Jelszó:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <label for="password2">Jelszó mégegyszer:</label><br>
        <input type="password" id="password2" name="password2" required><br><br>

        <button class="gomb" type="submit">Regisztráció</button>
    </form>
    <?php
    session_start();
    if(isset($_SESSION["error_regist"]) && $_SESSION["error_regist"]===0){
        echo "<p>Sikeres regisztráció</p>";
        unset($_SESSION["error_regist"]);
    }
    if(isset($_SESSION["error_regist"]) && $_SESSION["error_regist"]===1){
        echo "<p>Foglalt felhasználónév</p>";
        unset($_SESSION["error_regist"]);
    }
    if(isset($_SESSION["error_regist"]) && $_SESSION["error_regist"]===2){
        echo "<p>Nem egyezik a jelszó</p>";
        unset($_SESSION["error_regist"]);
    }
    ?>
    </div>
</body>
</html>














