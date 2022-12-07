<?php
session_start();
include 'dbConnection.php';
if($_SESSION) {
    $sql = "SELECT cltFirstName, cltLastName FROM Client WHERE cltID= '".$_SESSION["cltID"]."'";
    $result = runSQLResult($sql);
    $clientInfo = $result->fetch_assoc();
    $cltFirstName = $clientInfo["cltFirstName"];
    $cltLastName = $clientInfo["cltLastName"];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/site-header-styles.css">
    <title>PetConnect</title>
</head>
<body>
<div class="main-header">

    <div class="logo">
        <img src="../img/logos/PetConnect-Logo.png" alt="PetConnect-Logo">
    </div>

    <div class="text-font-500" id="menu">
        <a href="home.php">Accueil</a>
        <a href="#">Boutique</a>
        <a href="#">Assistance</a>
    </div>

    <div class="profile">
        <div id="profile-div-flex">
            <div id="profile-logo"><a href="#"><img id="profile-img-1" src="../img/profile/client.png" alt="Client-logo"></a></div>
            <div id="dropdown-menu-login" class="text-font-500">
                <?php if($_SESSION): ?>
                <p>Bonjour <?php echo $clientInfo["cltFirstName"]." ".$clientInfo["cltLastName"]?></p>
                <?php else: ?>
                <a href="login.php">Sign in</a>
                <p>New Client?<a href="signup.php">Signup.</a></p>
                <?php endif; ?>
                <div class="dropdown-menu-line"></div>
                <a href="profile.php">Mon Compte</a>
                <a href="#">Mes Commandes</a>
                <a href="#">Mes Appareils</a>
                <div class="dropdown-menu-line"></div>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div>
            <a href="#"><img id="profile-img-2" src="../img/profile/basket.png" alt="Basket-logo"></a>
        </div>

    </div>
</div>
</body>
</html>