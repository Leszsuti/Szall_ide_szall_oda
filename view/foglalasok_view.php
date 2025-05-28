<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foglalasok</title>
    <link rel="stylesheet" href="../style/foglalasok.css">
</head>
<body>
<?php
session_start();
error_reporting(0);
include "../view/fejlec.php";
include "../datab.php";
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
}else{
    header("location: ../index.php");
}
?>
<div class="outside">
    <div class="blokk-bal">
        <h2>Új foglalás</h2>
        <?php
        $email_=null;
        $mettol_=null;
        $meddig_=null;
        $fekvohelyek_szama_=null;
        if(isset($_POST["email"]) && isset($_POST["mettol"]) && isset($_POST["meddig"]) && isset($_POST["fekvohelyek_szama"])){
            $email_=$_POST["email"];
            $mettol_=$_POST["mettol"];
            $meddig_=$_POST["meddig"];
            $fekvohelyek_szama_=$_POST["fekvohelyek_szama"];
            if($mettol_>=$meddig_){
                $tmp=$mettol_;
                $mettol_=$meddig_;
                $meddig_=$tmp;
            }
        }
        ?>
        <form action="foglalasok_view.php" method="post">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" list="email-list" value="<?php echo $email_?>" required>
            <datalist id="email-list">
                <?php
                $emailek=adatbazis_get_osszesemail();
                foreach ($emailek as $email) {
                    echo '<option value="' . htmlspecialchars($email) . '">';
                }
                ?>
            </datalist><br><br>
            <label for="mettol">Mettől:</label><br>
            <input type="date" id="mettol" name="mettol" value="<?php echo $mettol_?>" required><br><br>
            <label for="meddig">Meddig:</label><br>
            <input type="date" id="meddig" name="meddig" value="<?php echo $meddig_?>" required><br><br>
            <label for="fekvohelyek_szama">Hány főre?</label><br>
            <input type="number" id="fekvohelyek_szama" name="fekvohelyek_szama" value="<?php echo $fekvohelyek_szama_?>" required><br><br>
            <button type="submit" class="gomb">Listázás</button>
        </form>
            <div class="lista">
            <?php
            $szobaszam=null;
            $tipusazonosito=null;
            $megnevezes=null;
            $napi_ar=null;
            $teljes_ar=null;


            if(isset($_POST["mettol"]) && isset($_POST["meddig"]) && isset($_POST["fekvohelyek_szama"])){
                $fekvohelyek_szama=$_POST["fekvohelyek_szama"];
                $email=$_POST["email"];
                $mettol=$_POST["mettol"];
                $meddig=$_POST["meddig"];
                if($mettol>=$meddig){
                    $tmp=$mettol;
                    $mettol=$meddig;
                    $meddig=$tmp;
                }
                $lehetosegek=adatbazis_get_szabadszobak($mettol, $meddig, $fekvohelyek_szama);
                if($lehetosegek==null){
                    $_SESSION["error_foglalas"]="Nincs szabad szoba";
                    goto ide;
                }
                if($mettol===$meddig){
                    $_SESSION["error_foglalas"]="Minimum 1 nap hosszú kell legyen a foglalás";
                    goto ide;
                }
                foreach($lehetosegek as $lehetoseg){
                    $szobaszam=$lehetoseg["szobaszam"];
                    $tipusazonosito=$lehetoseg["tipusazonosito"];
                    $megnevezes=$lehetoseg["megnevezes"];
                    $fekvohelyek=$lehetoseg["fekvohelyek_szama"];
                    $napi_ar=$lehetoseg["napi_ar"];
                    $teljes_ar=$lehetoseg["teljes_ar"];
                    echo "<div class='container_out'>".
                        "<div class='container'>".
                         "<p class='bal'>Szobaszám: </p><p class='jobb'> $szobaszam</p>
                          <p class='bal'>Típus: </p><p class='jobb'> $megnevezes ($tipusazonosito)</p>
                          <p class='bal'>Ágyak: </p><p class='jobb'> $fekvohelyek db</p>
                          <p class='bal'>Napi ár: </p><p class='jobb'> $napi_ar Ft</p>
                          <p class='bal'>Teljes ár: </p><p class='jobb'> $teljes_ar Ft</p>".
                        "</div>".
                         "<form action='../do/foglalasfelvetel_do.php' method='post'>
                          <input type='hidden' name='email' value='$email'>
                          <input type='hidden' name='szobaszam' value='$szobaszam'>
                          <input type='hidden' name='mettol' value='$mettol'>
                          <input type='hidden' name='meddig' value='$meddig'>
                          <button class='gomb gomb_ragad' type='submit'>Foglalás</button>
                          </form>".
                         "</div>";
                }
            }
            ide:
            ?>
            </div>
        <?php
        if(isset($_SESSION["error_foglalas"])){
            echo "<p>".$_SESSION["error_foglalas"]."</p>";
            unset($_SESSION["error_foglalas"]);
        }
        ?>
    </div>
    <div class="blokk-jobb">
        <h2>Összes foglalás</h2>
        <?php
        $foglalasok=adatbazis_get_osszesfoglalas();
        foreach($foglalasok as $foglalas){
            $email__=$foglalas["email"];
            $szobaszam__=$foglalas["szobaszam"];
            $mettol__=$foglalas["mettol"];
            $meddig__=$foglalas["meddig"];
            echo "<div class='container_out'>".
                "<div style='margin-top: 20px' class='container'>".
                "<p class='bal'>Email: </p><p class='jobb'> $email__</p>
                 <p class='bal'>Szobaszam: </p><p class='jobb'> $szobaszam__</p>
                 <p class='bal'>Mettől: </p><p class='jobb'> $mettol__</p>
                 <p class='bal'>Meddig: </p><p class='jobb'> $meddig__</p>".
                "</div>".
                "<form action='../do/foglalastorles_do.php' method='post'>
                      <input type='hidden' name='email' value='$email__'>
                      <input type='hidden' name='szobaszam' value='$szobaszam__'>
                      <input type='hidden' name='mettol' value='$mettol__'>
                      <input type='hidden' name='meddig' value='$meddig__'>
                      <button type='submit' class='gomb gomb_ragad'>Foglalás törlése</button>
                      </form>".
                "</div>";
        }

        ?>
        <?php
        if(isset($_SESSION["torles_uzenet"])){
            echo "<p>".$_SESSION["torles_uzenet"]."</p>";
            unset($_SESSION["torles_uzenet"]);
        }
        ?>
    </div>
</div>
</body>


















