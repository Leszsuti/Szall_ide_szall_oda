<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>fejlec</title>
    <link rel="stylesheet" href="../style/fejlec.css">
    <link rel="stylesheet" href="../style/hulyesegek.css">
</head>
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

<body>
<div class="blokk">
<h2>Személyenkénti költés</h2>
<?php
$koltesek=adatbazis_get_szemelyenkentikoltes();
foreach($koltesek as $koltes){
    echo "<p>".$koltes['email']." - ".$koltes['koltes']." Ft-ot költött"." és " .$koltes['db'] ." db foglalása van"."</p>";
}
?>
</div>
<div class="blokk">
    <h2>Két időpont közötti foglalások összes adata</h2>
    <form action="../view/hulyesegek_view.php" method="POST">
        <label for="start">Intervallum kezdete:</label><br>
        <input type="date" id="start" name="start" required><br><br>

        <label for="end">Intervallum vége:</label><br>
        <input type="date" id="end" name="end" required><br><br>

        <button class="gomb" type="submit">Listázás</button>
    </form>
    <div class="lista">
    <?php
    if(isset($_POST["start"]) && isset($_POST["end"])){
        $start=$_POST["start"];
        $end=$_POST["end"];
        $foglalasok=adatbazis_get_ketidopontkozottmegkezdettfoglalasokadatai($start,$end);
        foreach($foglalasok as $foglalas){
            $mettol=$foglalas['mettol'];
            $meddig=$foglalas['meddig'];
            $email=$foglalas['email'];
            $nev=$foglalas['nev'];
            $szuldat=$foglalas['szuletesi_datum'];
            $telefonszam=$foglalas['telefonszam'];
            $szobaszam=$foglalas['szobaszam'];
            $tipusazonosito=$foglalas['tipusazonosito'];
            $megnevezes=$foglalas['megnevezes'];
            $fekvohelyek=$foglalas['fekvohelyek_szama'];
            $leiras=$foglalas['leiras'];
            $napi_ar=$foglalas['napi_ar']." Ft";
            $teljes_ar=$foglalas['teljes_ar']. " Ft";
            if($tipusazonosito==null){
                $tipusazonosito="nincs!";
                $megnevezes="nincs!";
                $fekvohelyek="nincs!";
                $leiras="nincs!";
                $napi_ar="nincs!";
                $teljes_ar="nincs!";
            }


            echo "<div class='container'>".
                     "<h1 class='balh'>Vendég adatai: </h1><h1 class='jobb'></h1>
                      <p class='bal'>Ímél: </p><p class='jobb'> $email</p>
                      <p class='bal'>Név: </p><p class='jobb'> $nev</p>
                      <p class='bal'>Születési dátum: </p><p class='jobb'> $szuldat</p>
                      <p class='bal'>Telefonszám: </p><p class='jobb'> $telefonszam</p>
                      <h1 class='balh'>Foglalás adatai: </h1><h1 class='jobb'></h1>
                      <p class='bal'>Mettol: </p><p class='jobb'> $mettol</p>
                      <p class='bal'>Meddig: </p><p class='jobb'> $meddig</p>
                      <p class='bal'>Szobaszám: </p><p class='jobb'> $szobaszam</p>
                      <h1 class='balh'>Szobatípus adatai: </h1><h1 class='jobb'></h1>
                      <p class='bal'>Típusazonosító: </p><p class='jobb'> $tipusazonosito</p>
                      <p class='bal'>Megnevezés: </p><p class='jobb'> $megnevezes</p>
                      <p class='bal'>Fekvőhelyek száma: </p><p class='jobb'> $fekvohelyek</p>
                      <p class='bal'>Leírás: </p><p class='jobb leiras'> $leiras</p>
                      <p class='bal'>Napi ár: </p><p class='jobb'> $napi_ar</p>
                      <p class='bal'>Teljes ár: </p><p class='jobb'> $teljes_ar</p>".
                "</div>";
        }
    }
    unset($_POST["start"]);
    unset($_POST["end"]);

    ?>
    </div>
</div>
<div class="blokk">
    <h2>Szobákra eső foglalások száma fekvőhely szerint csoportosítva</h2>
    <?php
    $adatok=adatbazis_get_szobakraesofoglalasokszamafekvohelyszerintcsopotositva();
    foreach($adatok as $adat){
        echo "<p>".$adat['fekvohelyek_szama']." fős szobákra"."  " .$adat['db'] ." db foglalás van összesen"."</p>";
    }
    ?>
</div>
<div class="blokk">
    <h2>Szülinapos vendégek jelenleg a szállodában</h2>
    <?php
    $adatok=adatbazis_get_mavanaszulinapja();
    foreach($adatok as $adat){
        echo "<p>".$adat['email']." , ".$adat['nev']." , ".$adat['szuletesi_datum'] ." , ".$adat['eletkor']." éves és a(z) ".$adat['szobaszam']." számú szobában lakik"."</p>";
    }
    ?>
</div>


</body>
