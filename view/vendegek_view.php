<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendegek</title>
    <link rel="stylesheet" href="../style/vendegek.css">
</head>
<body>
<?php
session_start();
error_reporting(0);
include "../view/fejlec.php";
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
}else{
    header("location: ../index.php");
}
?>
<div class="outside">
<div class="blokk">
    <h2>Vendégek felvétele</h2>
    <form action="../do/vendegfelvetel_do.php" method="POST">
        <label for="nev">Név:</label><br>
        <input type="text" id="nev" name="nev" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="telefonszam">Telefonszám:</label><br>
        <input type="text" id="telefonszam" name="telefonszam" maxlength="16" required><br><br>
        <label for="szuldat">Születési dátum:</label><br>
        <input type="date" id="szuldat" name="szuldat" required><br><br>
        <button class="gomb" type="submit">Felvétel</button>
    </form>
    <?php
    if(isset($_SESSION["error_vendegfelvetel"])){
        echo "<p>".$_SESSION["error_vendegfelvetel"]."</p>";
        unset($_SESSION["error_vendegfelvetel"]);
    }
    ?>
</div>
<div class="blokk">
    <h2>Vendégek módosítása</h2>
    <form action="../view/vendegek_view.php" method="POST">
        <label for="email_old">Módosítandó vendég e-mailje:</label><br>
        <input type="email" id="email_old" name="email_old" list="email-list" required>
        <datalist id="email-list">
            <?php
            include "../datab.php";
            $emailek=adatbazis_get_osszesemail();
            foreach ($emailek as $email) {
                echo '<option value="' . htmlspecialchars($email) . '">';
            }
            ?>
        </datalist><br><br>
        <button class="gomb" type="submit">Adatok lekérdezése</button>
    </form>
    <form action="../do/vendegmodositas_do.php" method="POST">
        <?php
        $email_old="";
        $nev="";
        $telefonszam="";
        $szuldat="";
        if(isset($_POST["email_old"])){
            $email_old=$_POST["email_old"];
            $vendeg=adatbazis_get_vendeg($email_old);
            if($vendeg!=null){
                $email_old=$vendeg["email"];
                $nev=$vendeg["nev"];
                $telefonszam=$vendeg["telefonszam"];
                $szuldat=$vendeg["szuletesi_datum"];
            }
        }
        ?>
        <input type="hidden" id="email_old" name="email_old" value="<?php echo $email_old ?>" required><br><br>

        <label for="nev">Név (új):</label><br>
        <input type="text" id="nev" name="nev" value="<?php echo $nev ?>" required><br><br>
        <label for="email_new">Email (új):</label><br>
        <input type="email" id="email_new" name="email_new" value="<?php echo $email_old ?>" required><br><br>
        <label for="telefonszam">Telefonszám (új):</label><br>
        <input type="text" id="telefonszam" name="telefonszam" maxlength="16" value="<?php echo $telefonszam ?>" required><br><br>
        <label for="szuldat">Születési dátum (új):</label><br>
        <input type="date" id="szuldat" name="szuldat" value="<?php echo $szuldat ?>" required><br><br>
        <button class="gomb" type="submit">Módosítás</button>
    </form>
    <?php
    if(isset($_SESSION["error_vendegmodositas"])){
        echo "<p>".$_SESSION["error_vendegmodositas"]."</p>";
        unset($_SESSION["error_vendegmodositas"]);
    }
    ?>
</div>
<div class="blokk">
    <h2>Vendégek törlése</h2>
    <form action="../do/vendegtorles_do.php" method="POST">
        <label for="email_torol">Törlendő vendég e-mailje:</label><br>
        <input type="email" id="email_torol" name="email_torol" list="emaildelete-list" required>
        <datalist id="emaildelete-list">
            <?php
            $emailek = adatbazis_get_osszesemail();
            foreach ($emailek as $email) {
                echo '<option value="' . htmlspecialchars($email) . '">';
            }
            ?>
        </datalist><br><br>
        <button class="gomb" type="submit">Vendég törlése</button>
    </form>
    <?php
    if(isset($_SESSION["torles_uzenet"])){
        echo "<p>".$_SESSION["torles_uzenet"]."</p>";
        unset($_SESSION["torles_uzenet"]);
    }
    ?>
</div>
</div>
</body>
</html>
