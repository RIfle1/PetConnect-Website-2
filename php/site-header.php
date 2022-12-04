<?php
session_start();
include 'dbConnection.php';
$cltFirstName = "";
$cltLastName = "";
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
    <link rel="stylesheet" href="../css/home-styles.css">
    <link rel="stylesheet" href="../css/site-header-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <title>PetConnect</title>
</head>
<body>
<div class="main-header">

    <div class="logo">
        <img src="../img/logos/PetConnect-Logo.png" alt="PetConnect-Logo">
    </div>

    <div class="header-font" id="menu">
        <a href="home.php">Accueil</a>
        <a href="#">Boutique</a>
        <a href="#">Assistance</a>
    </div>

    <div class="profile">
        <div id="profile-div-flex">
            <div id="profile-logo"><a href="#"><img id="profile-img-1" src="../img/profile/client.png" alt="Client-logo"></a></div>
            <?php if($cltFirstName || $cltLastName): ?>
            <div id="dropdown-menu-login" class="text-font">
                <?php echo "<p>Bonjour $cltFirstName $cltLastName</p>"; ?>
                <div class="dropdown-menu-line"></div>
                <a href="#">Mon Compte</a>
                <a href="#">Mes Commandes</a>
                <a href="#">Mes Appareils</a>
                <div class="dropdown-menu-line"></div>
                <a href="logout.php">Logout</a>
            </div>
            <?php else: ?>
                <div id="dropdown-menu-login" class="text-font">
                    <a href="login.php">Sign in</a>
                    <p>New Client?<a href="signup.php">Signup.</a></p>
                    <div class="dropdown-menu-line"></div>
                    <a href="#">Mon Compte</a>
                    <a href="#">Mes Commandes</a>
                    <a href="#">Mes Appareils</a>
                    <div class="dropdown-menu-line"></div>
                    <a href="logout.php">Logout</a>
                </div>
            <?php endif; ?>
        </div>
        <div>
            <a href="#"><img id="profile-img-2" src="../img/profile/basket.png" alt="Basket-logo"></a>
        </div>

    </div>

</div>
</body>
</html>