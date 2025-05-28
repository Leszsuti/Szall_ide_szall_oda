<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="../style/login.css">
</head>
<body>
<?php
error_reporting(0);
include "../view/fejlec.php";
?>
<div class="outside">
    <h2>Bejelentkezés</h2>
    <form action="../do/login_do.php" method="POST">
        <label for="username">Felhasználónév:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Jelszó:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button class="gomb" type="submit">Bejelentkezés</button>
    </form>
    <?php
    session_start();
        if(isset($_SESSION["error"]) && $_SESSION["error"]===0){
            echo "<p>"."Sikeres bejelentkezés"."</p>";
            unset($_SESSION["error"]);
        }
        if(isset($_SESSION["error"]) && $_SESSION["error"]===1){
            echo "<p>Hibás felhasználónév vagy jelszó</p>";
            unset($_SESSION["error"]);
        }
    ?>
</div>
</body>
</html>