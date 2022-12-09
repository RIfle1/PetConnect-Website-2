<?php
session_start();
include 'dbConnection.php';
if(!empty($_SESSION['cltID'])) {
    $sql = "SELECT * FROM Client WHERE cltID= '".$_SESSION["cltID"]."'";
    $result = runSQLResult($sql);
    $clientInfo = $result->fetch_assoc();
}elseif (!empty($_SESSION['admID'])) {
    $sql = "SELECT * FROM admin WHERE admID= '".$_SESSION["admID"]."'";
    $result = runSQLResult($sql);
    $adminInfo = $result->fetch_assoc();
}else {
    $clientInfo = "";
    $adminInfo = "";
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/site-header-styles.css">
    <script src="../javaScript/css-functions.js"></script>
    <title>PetConnect</title>
</head>
<body>
<div class="site-header-main-header">

    <div class="site-header-logo">
        <img src="../img/logos/PetConnect-Logo.png" alt="PetConnect-Logo">
    </div>

    <div class="text-font-500" id="site-header-menu">
        <a href="home.php">Accueil</a>
        <a href="#">Boutique</a>
        <a href="#">Assistance</a>
    </div>

    <div class="site-header-profile">
        <div id="site-header-profile-div-flex">
            <div id="site-header-profile-logo">
                <a href="profile.php">
                    <?php if(!empty($_SESSION['cltID'])): ?>
                        <img src="../img/pfp/<?php echo getPfp('cltID', 'client', $clientInfo['cltID'])['cltPfpName'] ?>" alt="Profile picture">
                    <?php elseif(!empty($_SESSION['admID'])): ?>
                        <img src="../img/pfp/<?php echo getPfp('admID', 'admin', $adminInfo['admID'])['admPfpName'] ?>" alt="Profile picture">
                    <?php else: ?>
                        <img src="../img/<?php echo getImage('client.png')['imgCategory']."/".getImage('client.png')['imgPath']?>" alt="Client-logo">
                    <?php endif; ?>
                </a>
            </div>
            <div id="site-header-dropdown-menu-login" class="text-font-500">
                <?php if(!empty($_SESSION['cltID'])): ?>
                    <p>Bonjour <?php echo $clientInfo["cltFirstName"]." ".$clientInfo["cltLastName"]?></p>
                <?php elseif(!empty($_SESSION['admID'])): ?>
                    <p>Bonjour <?php echo $adminInfo['admUsername']?></p>
                <?php else: ?>
                    <div id="site-header-signup">
                        <a id="site-header-signup-a1" href="login.php">Sign in</a>
                        <p>New Client?<a id="site-header-signup-a2" href="signup.php">Signup.</a></p>
                    </div>
                <?php endif; ?>
                <div class="site-header-dropdown-menu-line"></div>
                <a href="profile.php">Mon Compte</a>
                <a href="#">Mes Commandes</a>
                <a href="#">Mes Appareils</a>
                <div class="site-header-dropdown-menu-line"></div>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div>
            <a href="#"><img src="../img/<?php echo getImage('basket.png')['imgCategory']."/".getImage('basket.png')['imgPath']?>" alt="Basket-logo"></a>
        </div>

    </div>
</div>
</body>
</html>