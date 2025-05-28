<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendegek</title>
    <link rel="stylesheet" href="../style/szobak.css">
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
    <h2>Új szobatípus felvétele</h2>
    <form action="../do/tipusfelvetel_do.php" method="POST">
        <label for="megnevezes">Megnevezés:</label><br>
        <input type="text" id="megnevezes" name="megnevezes" required><br><br>
        <label for="fekvohelyek_szama">Fekvőhelyek száma:</label><br>
        <input type="number" id="fekvohelyek_szama" name="fekvohelyek_szama" required><br><br>
        <label for="leiras">Leírás:</label><br>
        <textarea id="leiras" name="leiras" rows="5" cols="50" maxlength="250" required></textarea><br><br>
        <label for="napi_ar">Napi ár:</label><br>
        <input type="number" id="napi_ar" name="napi_ar" required> Ft<br><br>
        <button class="gomb" type="submit">Felvétel</button>
    </form>
    <?php
    if(isset($_SESSION["error_tipusfelvetel"])){
        echo "<p>".$_SESSION["error_tipusfelvetel"]."</p>";
        unset($_SESSION["error_tipusfelvetel"]);
    }
    ?>
</div>
<div class="blokk">
    <h2>Szobatípus módosítása</h2>
    <form action="../view/szobak_view.php" method="POST">
        <label for="tipusazonosito">Módosítandó szobatípus azonosítója:</label><br>
        <input type="number" id="tipusazonosito" name="tipusazonosito" list="tipus-list" required>
        <datalist id="tipus-list">
            <?php
            include "../datab.php";
            $tipusok=adatbazis_get_osszestipus();
            foreach ($tipusok as $tipus) {
                echo '<option value="' . htmlspecialchars($tipus["tipusazonosito"]) . '">'. $tipus["megnevezes"] .'</option>';
            }
            ?>
        </datalist><br><br>
        <button class="gomb" type="submit">Adatok lekérdezése</button>
    </form>
    <form action="../do/tipusmodositas_do.php" method="POST">
        <?php
        $tipusazonosito="";
        $megnevezes="";
        $fekvohelyek_szama="";
        $leiras="";
        $napi_ar="";
        if(isset($_POST["tipusazonosito"])){
            $tipusazonosito=$_POST["tipusazonosito"];
            $szobatipus=adatbazis_get_tipus($tipusazonosito);
            if($szobatipus!=null){
                $tipusazonosito=$szobatipus["tipusazonosito"];
                $megnevezes=$szobatipus["megnevezes"];
                $fekvohelyek_szama=$szobatipus["fekvohelyek_szama"];
                $leiras=$szobatipus["leiras"];
                $napi_ar=$szobatipus["napi_ar"];
            }
        }
        ?>
        <!--<label for="tipusazonosito">Típusazonosító:</label><br>-->
        <input type="hidden" id="tipusazonosito" name="tipusazonosito" value="<?php echo $tipusazonosito ?>" readonly><br><br>

        <label for="megnevezes">Megnevezés (új):</label><br>
        <input type="text" id="megnevezes" name="megnevezes" value="<?php echo $megnevezes ?>" required><br><br>
        <label for="fekvohelyek_szama">Fekvőhelyek száma (új):</label><br>
        <input type="number" id="fekvohelyek_szama" name="fekvohelyek_szama" value="<?php echo $fekvohelyek_szama ?>" required><br><br>
        <label for="leiras">Leírás (új):</label><br>
        <textarea id="leiras" name="leiras" rows="5" cols="50" maxlength="250" required><?php echo htmlspecialchars($leiras); ?></textarea><br><br>
        <label for="napi_ar">Napi ár (új):</label><br>
        <input type="number" id="napi_ar" name="napi_ar" value="<?php echo $napi_ar ?>" required> Ft<br><br>
        <button class="gomb" type="submit">Módosítás</button>
    </form>
    <?php
    if(isset($_SESSION["error_tipusmodositas"])){
        echo "<p>".$_SESSION["error_tipusmodositas"]."</p>";
        unset($_SESSION["error_tipusmodositas"]);
    }
    ?>
</div>
<div class="blokk">
    <h2>Szobatípus törlése</h2>
    <form action="../do/tipustorles_do.php" method="POST">
        <label for="tipus_torol">Törlendő szobatípus azonosítója:</label><br>
        <input type="number" id="tipus_torol" name="tipus_torol" list="tipusdelete-list" required>
        <datalist id="tipusdelete-list">
            <?php
            $tipusok=adatbazis_get_osszestipus();
            foreach ($tipusok as $tipus) {
                echo '<option value="' . htmlspecialchars($tipus["tipusazonosito"]) . '">'. $tipus["megnevezes"] .'</option>';
            }
            ?>
        </datalist><br><br>
        <button class="gomb" type="submit">Szobatípus törlése</button>
    </form>
    <?php
    if(isset($_SESSION["torles_uzenet"])){
        echo "<p>".$_SESSION["torles_uzenet"]."</p>";
        unset($_SESSION["torles_uzenet"]);
    }
    ?>
</div>
<!--****************************************************************************************************-->
<div class="blokk">
    <h2>Új szoba felvétele</h2>
    <form action="../do/szobafelvetel_do.php" method="POST">
        <label for="szobaszam">Szobaszám:</label><br>
        <input type="number" id="szobaszam" name="szobaszam" required><br><br>
        <label for="tipusazonosito">Szoba típusa:</label><br>
        <input type="number" id="tipusazonosito" name="tipusazonosito" list="tipusa-list" required>
        <datalist id="tipusa-list">
            <?php
            $tipusok=adatbazis_get_osszestipus();
            foreach ($tipusok as $tipus) {
                echo '<option value="' . htmlspecialchars($tipus["tipusazonosito"]) . '">'. $tipus["megnevezes"] .'</option>';
            }
            ?>
        </datalist><br><br>
        <button class="gomb" type="submit">Felvétel</button>
    </form>
    <?php
    if(isset($_SESSION["error_szobafelvetel"])){
        echo "<p>".$_SESSION["error_szobafelvetel"]."</p>";
        unset($_SESSION["error_szobafelvetel"]);
    }
    ?>
</div>
<div class="blokk">
    <h2>Szoba módosítása</h2>
    <form action="../view/szobak_view.php" method="POST">
        <label for="szobaszam">Szobaszám:</label><br>
        <input type="number" id="szobaszam" name="szobaszam" list="szobaszam-list" required>
        <datalist id="szobaszam-list">
            <?php
            $szobak=adatbazis_get_osszesszoba();
            foreach ($szobak as $szoba) {
                if($szoba["megnevezes"]==null){
                    $szoba["megnevezes"]="nincs!";
                }
                echo '<option value="' . htmlspecialchars($szoba["szobaszam"]) . '">'. "szobatípus:" . " " . $szoba["megnevezes"]. " (" . $szoba["tipusazonosito"].")".'</option>';
            }
            ?>
        </datalist><br><br>
        <button class="gomb" type="submit">Adatok lekérdezése</button>
    </form>
    <?php
    $szobaszam=null;
    $tipusazonosito=null;
    $megnevezes=null;
    $fekvohelyek_szama=null;
    $leiras=null;
    $napi_ar=null;

        if(isset($_POST["szobaszam"])){
            $szobaszam=$_POST["szobaszam"];
            $szoba=adatbazis_get_szoba($szobaszam);
            $tipusazonosito=$szoba["tipusazonosito"];
            if($tipusazonosito==null){
                $tipusazonosito="nincs!";
                $megnevezes="nincs!";
                $fekvohelyek_szama="nincs!";
                $leiras="nincs!";
                $napi_ar="nincs!";
            }else{
                $megnevezes=$szoba["megnevezes"];
                $fekvohelyek_szama=$szoba["fekvohelyek_szama"];
                $leiras=$szoba["leiras"];
                $napi_ar=$szoba["napi_ar"];
            }
        }
    ?>
    <div class="left">
    <form action="../do/szobamodositas_do.php" method="post">
        <input type="hidden" id="szobaszam_old" name="szobaszam_old" value="<?php echo $szobaszam ?>"><br><br>
        <label for="szobaszam_new">Szobaszám (új):</label><br>
        <input type="text" id="szobaszam_new" name="szobaszam_new" value="<?php echo $szobaszam ?>" required><br><br>
        <label for="tipusazonosito">Szoba típusa (új):</label><br>
        <input type="number" id="tipusazonosito" name="tipusazonosito" list="tipusa-list" value="<?php echo $tipusazonosito ?>" required>
        <datalist id="tipusa-list">
            <?php
            $tipusok=adatbazis_get_osszestipus();
            foreach ($tipusok as $tipus) {
                echo '<option value="' . htmlspecialchars($tipus["tipusazonosito"]) . '">'. $tipus["megnevezes"] .'</option>';
            }
            ?>
        </datalist><br><br>
        <button class="gomb" type="submit">Módosítás</button>
    </form>
    </div>
    <div class="right">
        <div class="container">
            <p class="bal">Megnevezés:</p><p class="jobb"> <?php echo "$megnevezes" ?></p>
            <p class="bal">Fekvőhelyek száma:</p><p class="jobb"> <?php echo "$fekvohelyek_szama" ?></p>
            <p class="bal">Leírás:</p><p class="jobb"> <?php echo "$leiras" ?></p>
            <p class="bal">Napi ár:</p><p class="jobb"> <?php echo "$napi_ar" ?></p>
        </div>
    <?php
    if(isset($_SESSION["error_szobamodositas"])){
        echo "<p>".$_SESSION["error_szobamodositas"]."</p>";
        unset($_SESSION["error_szobamodositas"]);
    }
    ?>
    </div>
</div>
<div class="blokk">
    <h2>Szoba törlése</h2>
    <form action="../do/szobatorles_do.php" method="POST">
        <label for="szoba_torol">Törlendő szoba szobaszáma:</label><br>
        <input type="number" id="szoba_torol" name="szoba_torol" list="szobadelete-list" required>
        <datalist id="szobadelete-list">
            <?php
            $szobak=adatbazis_get_osszesszoba();
            foreach ($szobak as $szoba) {
                if($szoba["megnevezes"]==null){
                    $szoba["megnevezes"]="nincs!";
                }
                echo '<option value="' . htmlspecialchars($szoba["szobaszam"]) . '">'. "szobatípus:" . " " . $szoba["megnevezes"]. " (" . $szoba["tipusazonosito"].")".'</option>';
            }
            ?>
        </datalist><br><br>
        <button class="gomb" type="submit">Szoba törlése</button>
    </form>
    <?php
    if(isset($_SESSION["torlesszoba_uzenet"])){
        echo "<p>".$_SESSION["torlesszoba_uzenet"]."</p>";
        unset($_SESSION["torlesszoba_uzenet"]);
    }
    ?>
</div>
</div>
</body>
</html>






















