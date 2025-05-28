<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>fejlec</title>
    <link rel="stylesheet" href="../style/fejlec.css">
</head>
<?php
error_reporting(0);
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="fejlec_div">
    <form action="../view/hulyesegek_view.php" method="POST">
        <button class="fejlec_button <?php echo ($current_page == 'hulyesegek_view.php') ? 'active' : ''; ?>" type="submit">Csupa csoda lekérdezések</button>
    </form>
    <form action="../view/vendegek_view.php" method="POST">
        <button class="fejlec_button <?php echo ($current_page == 'vendegek_view.php') ? 'active' : ''; ?>" type="submit">Vendégek kezelése</button>
    </form>
    <form action="../view/foglalasok_view.php" method="POST">
        <button class="fejlec_button <?php echo ($current_page == 'foglalasok_view.php') ? 'active' : ''; ?>" type="submit">Foglalások</button>
    </form>
    <form action="../view/szobak_view.php" method="POST">
        <button class="fejlec_button <?php echo ($current_page == 'szobak_view.php') ? 'active' : ''; ?>" type="submit">Szobák kezelése</button>
    </form>
    <form action="../view/regist_view.php" method="POST">
        <button class="fejlec_button <?php echo ($current_page == 'regist_view.php') ? 'active' : ''; ?>" type="submit">Regisztráció</button>
    </form>
    <form action="../view/login_view.php" method="POST">
        <button class="fejlec_button <?php echo ($current_page == 'login_view.php') ? 'active' : ''; ?>" type="submit">Bejelentkezés</button>
    </form>
    <form action="../do/logout_do.php" method="POST">
        <button class="fejlec_button" type="submit">Kijelentkezés</button>
    </form>
</div>
</html>