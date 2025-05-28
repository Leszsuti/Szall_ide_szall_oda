<?php
function adatbazis_get($lekerdezes){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = array();

    if( mysqli_select_db($conn, 'szalloda') !=null) {
        $sql = $lekerdezes;
        $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');
        while($row = mysqli_fetch_assoc($res)) {
            $kimenet[] = $row;
        }
        mysqli_free_result($res);
    }else{
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_close($conn);
    return $kimenet;
}
function adatbazis_insert_felhasznalo($felhasznalonev, $nev, $jelszo){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error()); // a $conn-ba beleteszi az adatbázist (nem egészen így van, de most ha így képzeled el akkor jó)
    //az az or die cucc kb mindenhonnan elhagyható szerintem
    mysqli_query($conn, 'SET NAMES utf8');                       //
    mysqli_query($conn, "SET character_set_results=utf8");       // ez a 3 sor csak ahhoz kell, hogy biztos jól működjön, ezt PDO-ból kihagyták, pedig oda is kéne
    mysqli_set_charset($conn, 'utf8');                          //
    //eddig mindig ugyanaz ctrlc - ctrlv

    $jelszo=password_hash($jelszo, PASSWORD_DEFAULT); //jelszó hashelése

    $sql="INSERT INTO felhasznalo(felhasznalonev,nev,jelszo) VALUES ('$felhasznalonev', '$nev', '$jelszo')";  //egy változóba beleírod az sql lekérdezést, amit az adatbázison szeretnél lefuttatni

    try{
        mysqli_query($conn, $sql); //az adatbázisnak átadjuk a lekérdezést $conn az adatbázis, $sql a lekérdezés, itt a lekérdezés nem ad vissza semmit, mert csak beszúrunk az adatbázisba
        mysqli_close($conn);       //már nem kell az adatbázis, be kell zárni
        return true;
    }catch(Exception $e){          //ha valami errort dob a mysqli_query($conn, $sql); akkor at catcheli
        mysqli_close($conn);       //ilyenkor csak bezárjuk az adatbázist
        return false;
    }
}
function adatbazis_get_felhasznalo($felhasznalonev){  // login
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    //eddig ugyanaz----------------------------------------------

    $kimenet = null; //ebben lesz a lekérdezés eredménye

    $sql = "SELECT * FROM felhasznalo WHERE felhasznalonev = '$felhasznalonev'"; //ez a lekérdezés
    $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!'); //a $conn-ban lévő adatbázison csinálja meg a $sql-ben levő lekérdezész, most visszaadja a lekérdezés eredményét egy tömbben, aminek minden sora a lekérdezés eredményének egy sora
    $kimenet = mysqli_fetch_assoc($res); //ezt a függvényt nem kell tudnod, csak szerintem hasznos, mindig a következő sort olvassa be és adja vissza az eredményből, jelen esetben csak egy soros az eredmény, szóval tök felesleges XD, ha nem tetszik ez a megoldás simán foreachel is végigmehetsz
    /*foreach ($res as $sor) {
        $kimenet = $sor;               // <- pl. így, ugyanazt csinálja
    }*/

    mysqli_free_result($res); //a lekérdezés eredményére már nincs szükségünk (ez a sor amúgy elhagyható szinte mindig, nekem is csak ctrlc ctrlv miatt maradt itt)
    mysqli_close($conn); //szerintem ez is elhagyható, ha így csak függvényekben használod, függvény végén úgyis megszűnik
    return $kimenet;
}
//----------------------------------------------------------------------------------------------------
function adatbazis_insert_vendeg($email, $nev, $szuldat, $telefonszam){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');

    $sql="INSERT INTO vendeg (email, nev, szuletesi_datum, telefonszam) VALUES ('$email', '$nev', '$szuldat', '$telefonszam')";

    try{
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        return true;
    }catch(Exception $e){
        mysqli_close($conn);
        return false;
    }
}
function adatbazis_get_osszesemail(){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;

    $sql = "SELECT email FROM vendeg";
    $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');
    while($row = mysqli_fetch_assoc($res)) {
        $kimenet[] = $row['email'];
    }
        /* így is lehetne
        foreach ($res as $sor){
            $kimenet[] = $sor['email'];
        }*/
    mysqli_free_result($res);
    mysqli_close($conn);
    return $kimenet;
}
function adatbazis_get_vendeg($email){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;
    try{

        $sql = "SELECT * FROM vendeg WHERE email = '$email'";
        $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');
        // a $res-t valahogy így képzeld el(szedd ki kommentből és akkor kiszínezi):
        /*    $res=[[["email"=>"valaki1@gmail.com"],["nev"=>"Janika"],["szuletesi_datum"=>"2024-11-21"],["telefonszam"=>"+380912345678"]],
                  [["email"=>"valaki2@gmail.com"],["nev"=>"Bubek"],["szuletesi_datum"=>"2004-06-19"],["telefonszam"=>"06307352463"]],
                  [["email"=>"valaki3@gmail.com"],["nev"=>"Sanyi"],["szuletesi_datum"=>"2024-13-39"],["telefonszam"=>"+340913345378"]]];
        */
        while($row = mysqli_fetch_assoc($res)) {
            $kimenet = $row;
        }

        mysqli_free_result($res);
        mysqli_close($conn);
        return $kimenet;
    }catch (Exception $e){
        mysqli_close($conn);
    }
    return $kimenet;
}

function adatbazis_update_vendeg($email_old, $email_new, $nev, $szuldat, $telefonszam){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');

    $sql="UPDATE vendeg SET email='$email_new', nev='$nev', szuletesi_datum='$szuldat', telefonszam='$telefonszam' WHERE email='$email_old'";
    try{
        mysqli_query($conn, $sql); //ha a mysqli_query($conn, $sql) -nek nem sikerül a művelet akkor mindig dob egy exceptiont, ezt ha kell fel tudjuk használni hibakezelésre
        $rows_affected = mysqli_affected_rows($conn);
        mysqli_close($conn);
        if ($rows_affected === 0) {
            return false;
        }
        return true;
    }catch(Exception $e){
        mysqli_close($conn);
        return false;
    }
}

function adatbazis_delete_vendeg($email){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');

    if( mysqli_select_db($conn, 'szalloda') !=null) {
        $sql = "DELETE FROM vendeg WHERE email = '$email'";
        try{
            mysqli_query($conn, $sql);
            return true;
        }catch (Exception $e){
            mysqli_close($conn);
            return false;
        }
    }
    return false;
}

//----------------------------------------------------------------------------------------


function adatbazis_insert_tipus($megnevezes, $fekvohelyek_szama, $leiras, $napi_ar){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');

    $sql="INSERT INTO szobatipus (megnevezes, fekvohelyek_szama, leiras, napi_ar) VALUES ('$megnevezes', '$fekvohelyek_szama', '$leiras', '$napi_ar')";

    try{
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        return true;
    }catch(Exception $e){
        mysqli_close($conn);
        return false;
    }
}
function adatbazis_get_osszestipus(){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;

    if( mysqli_select_db($conn, 'szalloda') !=null) {
        $sql = "SELECT tipusazonosito, megnevezes FROM szobatipus";
        $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');
        while($row = mysqli_fetch_assoc($res)) {
            $kimenet[] = $row;
        }
        mysqli_free_result($res);
    }else{
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_close($conn);
    return $kimenet;
}
function adatbazis_get_tipus($tipusazonosito){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;
    try{
        if( mysqli_select_db($conn, 'szalloda') !=null) {
            $sql = "SELECT * FROM szobatipus WHERE tipusazonosito = '$tipusazonosito'";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');
            while($row = mysqli_fetch_assoc($res)) {
                $kimenet = $row;
            }
            mysqli_free_result($res);
        }else{
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_close($conn);
        return $kimenet;
    }catch (Exception $e){
        mysqli_close($conn);
    }
    return $kimenet;
}
function adatbazis_update_tipus($tipusazonosito, $megnevezes, $fekvohelyek_szama, $leiras, $napi_ar){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');

    $sql="UPDATE szobatipus SET megnevezes='$megnevezes', fekvohelyek_szama='$fekvohelyek_szama', leiras='$leiras', napi_ar='$napi_ar' WHERE tipusazonosito='$tipusazonosito'";
    try{
        mysqli_query($conn, $sql);
        $rows_affected = mysqli_affected_rows($conn);
        mysqli_close($conn);
        if ($rows_affected === 0) {
            return false;
        }
        return true;
    }catch(Exception $e){
        mysqli_close($conn);
        return false;
    }
}
function adatbazis_delete_tipus($tipusazonosito){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');

    if( mysqli_select_db($conn, 'szalloda') !=null) {
        $sql = "DELETE FROM szobatipus WHERE tipusazonosito = '$tipusazonosito'";
        try{
            mysqli_query($conn, $sql);
            return true;
        }catch (Exception $e){
            mysqli_close($conn);
            return false;
        }
    }
    return false;
}


//------------------------------------------------------------------------------------------------

function adatbazis_insert_szoba($szobaszam, $tipusazonosito){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');

    $sql="INSERT INTO szoba (szobaszam, tipusazonosito) VALUES ('$szobaszam', '$tipusazonosito')";

    try{
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        return true;
    }catch(Exception $e){
        mysqli_close($conn);
        return false;
    }
}
function adatbazis_get_osszesszoba(){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;

    $sql = "SELECT szoba.szobaszam, szoba.tipusazonosito, szobatipus.megnevezes FROM szoba LEFT JOIN szobatipus ON szoba.tipusazonosito=szobatipus.tipusazonosito ORDER BY szobaszam"; //inner join vagy valami speciális
    $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');
    while($row = mysqli_fetch_assoc($res)) {
        $kimenet[] = $row;
    }
    mysqli_free_result($res);
    mysqli_close($conn);
    return $kimenet;
}
function adatbazis_get_szoba($szobaszam){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;
    try{

        $sql = "SELECT szoba.szobaszam, szoba.tipusazonosito, szobatipus.megnevezes, szobatipus.fekvohelyek_szama, szobatipus.leiras, szobatipus.napi_ar FROM szoba LEFT JOIN szobatipus ON szoba.tipusazonosito=szobatipus.tipusazonosito WHERE szoba.szobaszam='$szobaszam' ORDER BY szobaszam";
        $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');
        while($row = mysqli_fetch_assoc($res)) {
            $kimenet = $row;
        }
        mysqli_free_result($res);
        mysqli_close($conn);
        return $kimenet;
    }catch (Exception $e){
        mysqli_close($conn);
    }
    return $kimenet;
}
function adatbazis_update_szoba($szobaszam_old, $szobaszam_new, $tipusazonosito){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');

    $sql="UPDATE szoba SET szobaszam='$szobaszam_new', tipusazonosito='$tipusazonosito' WHERE szobaszam='$szobaszam_old'";
    try{
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        return true;
    }catch(Exception $e){
        mysqli_close($conn);
        return false;
    }
}
function adatbazis_delete_szoba($szobaszam){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');


    $sql = "DELETE FROM szoba WHERE szobaszam = '$szobaszam'";
    try{
        mysqli_query($conn, $sql);
        return true;
    }catch (Exception $e){
        mysqli_close($conn);
        return false;
    }
}
//----------------------------------------------------------------------------------------------------------------------

function adatbazis_insert_foglalas($email, $szobaszam, $mettol, $meddig){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');

    $sql="INSERT INTO foglalas (email, szobaszam, mettol, meddig) SELECT '$email', $szobaszam, '$mettol', '$meddig' WHERE NOT EXISTS (SELECT 1 FROM foglalas WHERE szobaszam = $szobaszam AND '$mettol'<=meddig AND '$meddig' >= mettol)";

    try{
        mysqli_query($conn, $sql);
        if(mysqli_affected_rows($conn)==0){
            mysqli_close($conn);
            return false;
        }
        mysqli_close($conn);
        return true;
    }catch(Exception $e){
        mysqli_close($conn);
        return false;
    }
}
function adatbazis_get_osszesfoglalas(){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;

    $sql = "SELECT email, szobaszam, mettol, meddig FROM foglalas ORDER BY mettol";
    $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');
    while($row = mysqli_fetch_assoc($res)) {
        $kimenet[] = $row;
    }
    mysqli_free_result($res);
    mysqli_close($conn);
    return $kimenet;
}
function adatbazis_get_szabadszobak($mettol, $meddig, $fekvohelyek_szama){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;

    //hát ebben már nem vagyok biztos, hogy teljesen helyes, sok sikert az ellenőrzéshez XD
    $sql = "SELECT szoba.szobaszam, szoba.tipusazonosito, szobatipus.megnevezes, szobatipus.fekvohelyek_szama, szobatipus.napi_ar, szobatipus.napi_ar * DATEDIFF('$meddig', '$mettol') AS teljes_ar 
            FROM szoba INNER JOIN szobatipus ON szoba.tipusazonosito=szobatipus.tipusazonosito 
            LEFT JOIN (SELECT szoba.szobaszam 
            FROM szoba INNER JOIN foglalas ON szoba.szobaszam=foglalas.szobaszam WHERE '$mettol'<=foglalas.meddig AND '$meddig' >= foglalas.mettol) rosszak 
            ON szoba.szobaszam=rosszak.szobaszam WHERE szobatipus.fekvohelyek_szama>='$fekvohelyek_szama' AND rosszak.szobaszam IS NULL 
            ORDER BY szobatipus.fekvohelyek_szama, szobatipus.napi_ar";
    $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');
    while($row = mysqli_fetch_assoc($res)) {
        $kimenet[] = $row;
    }
    mysqli_free_result($res);
    mysqli_close($conn);
    return $kimenet;
}

function adatbazis_delete_foglalas($szobaszam, $mettol){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');


    $sql = "DELETE FROM foglalas WHERE szobaszam = '$szobaszam' AND mettol = '$mettol'";
    try{
        mysqli_query($conn, $sql);
        return true;
    }catch (Exception $e){
        mysqli_close($conn);
        return false;
    }
}

//--------------------------------------------------------------------------------------------------------------


function adatbazis_get_szemelyenkentikoltes(){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;
    try{

        $sql = "SELECT foglalas.email, SUM(szobatipus.napi_ar*DATEDIFF(foglalas.meddig, foglalas.mettol)) AS koltes, COUNT(foglalas.email) AS db
                FROM foglalas INNER JOIN szoba ON foglalas.szobaszam=szoba.szobaszam
                INNER JOIN szobatipus ON szoba.tipusazonosito=szobatipus.tipusazonosito GROUP BY foglalas.email ORDER BY koltes DESC ";
        $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');
        while($row = mysqli_fetch_assoc($res)) {
            $kimenet[] = $row;
        }
        mysqli_free_result($res);
        mysqli_close($conn);
        return $kimenet;
    }catch (Exception $e){
        mysqli_close($conn);
    }
    return $kimenet;
}
function adatbazis_get_ketidopontkozottmegkezdettfoglalasokadatai($start, $end){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;
    try{
        //itt tudom, hogy lesznek oszlopok, amik duplikálódni fognak, de lusta vagyok kiírni az összeset, működik így is
        $sql = "SELECT *, szobatipus.napi_ar*DATEDIFF(foglalas.meddig, foglalas.mettol) AS teljes_ar 
                FROM foglalas INNER JOIN vendeg ON foglalas.email=vendeg.email
                INNER JOIN szoba ON foglalas.szobaszam=szoba.szobaszam
                LEFT JOIN szobatipus ON szoba.tipusazonosito=szobatipus.tipusazonosito
                WHERE mettol>='$start' AND meddig<'$end' ORDER BY foglalas.email, foglalas.mettol";
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)) {
            $kimenet[] = $row;
        }
        mysqli_free_result($res);
        mysqli_close($conn);
        return $kimenet;
    }catch (Exception $e){
        mysqli_close($conn);
    }
    return $kimenet;
}
function adatbazis_get_szobakraesofoglalasokszamafekvohelyszerintcsopotositva(){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;
    try{

        $sql = "SELECT szobatipus.fekvohelyek_szama, COUNT(*) AS db 
                FROM foglalas INNER JOIN szoba ON foglalas.szobaszam=szoba.szobaszam
                INNER JOIN szobatipus ON szoba.tipusazonosito=szobatipus.tipusazonosito GROUP BY szobatipus.fekvohelyek_szama";
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)) {
            $kimenet[] = $row;
        }
        mysqli_free_result($res);
        mysqli_close($conn);
        return $kimenet;
    }catch (Exception $e){
        mysqli_close($conn);
    }
    return $kimenet;
}
function adatbazis_get_mavanaszulinapja(){
    $conn=mysqli_connect( 'localhost', 'root', "" ,"szalloda") or die("Connection failed: " . mysqli_connect_error());

    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');
    $kimenet = null;
    try{

        $sql = "SELECT vendeg.email, vendeg.nev, vendeg.szuletesi_datum, TIMESTAMPDIFF(YEAR, vendeg.szuletesi_datum, CURDATE()) AS eletkor, foglalas.szobaszam 
                FROM vendeg LEFT JOIN foglalas ON foglalas.email=vendeg.email
                WHERE MONTH(vendeg.szuletesi_datum)=MONTH(CURRENT_DATE) AND DAY(vendeg.szuletesi_datum)=DAY(CURRENT_DATE) AND foglalas.mettol<=CURDATE() AND foglalas.meddig>=CURDATE()";
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)) {
            $kimenet[] = $row;
        }
        mysqli_free_result($res);
        mysqli_close($conn);
        return $kimenet;
    }catch (Exception $e){
        mysqli_close($conn);
    }
    return $kimenet;
}





