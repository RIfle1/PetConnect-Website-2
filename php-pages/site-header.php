<?php
include '../php-processes/authenticity-check.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--    Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
<!--    Style Sheet-->
    <link rel="stylesheet" href="../css/site-header-styles.css">
<!--    Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous">
    </script>
<!--    Css Function-->
    <script src="../javaScript/css-functions.js"></script>
    <title>PetConnect</title>
</head>
<body>
<div class="site-header-main-header">

    <div class="site-header-logo">
        <a href="home.php"><img src="../img/<?php echo getImage('PetConnect-Logo.png')['imgCategory']."/".getImage('PetConnect-Logo.png')['imgPath']?>" alt="PetConnect-Logo"></a>
    </div>

    <div class="text-font-500" id="site-header-menu">
        <a href="home.php">Accueil</a>
        <a href="shop.php">Boutique</a>
        <a href="assistance.php">Assistance</a>
    </div>

    <div class="site-header-profile">
        <div id="site-header-profile-div-flex">
            <div id="site-header-profile-logo">
                <a href="profile.php">
                    <?php if($clientLoggedIn && strlen($clientInfo['cltPfpName']) > 0): ?>
                        <img src="../img/pfp/<?php echo getPfp('cltID', 'client', $clientInfo['cltID'])['cltPfpName'] ?>" alt="Profile picture">
                    <?php elseif($adminLoggedIn && strlen($adminInfo['admPfpName']) > 0): ?>
                        <img src="../img/pfp/<?php echo getPfp('admID', 'admin', $adminInfo['admID'])['admPfpName'] ?>" alt="Profile picture">
                    <?php else: ?>
                        <img src="../img/<?php echo getImage('client.png')['imgCategory']."/".getImage('client.png')['imgPath']?>" alt="Client-logo">
                    <?php endif; ?>
                </a>
            </div>
            <div id="site-header-dropdown-menu-login" class="text-font-500">
                <?php if($clientLoggedIn): ?>
                    <p>Bonjour <?php echo $clientInfo["cltFirstName"]." ".$clientInfo["cltLastName"]?></p>
                <?php elseif($adminLoggedIn): ?>
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
                <?php if($clientLoggedIn || $adminLoggedIn): ?>
                <div class="site-header-dropdown-menu-line"></div>
                <a href="logout.php">Logout</a>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <a href="#"><img src="../img/<?php echo getImage('basket.png')['imgCategory']."/".getImage('basket.png')['imgPath']?>" alt="Basket-logo"></a>
        </div>

    </div>
</div>

<script type="text/javascript">
    setMarginTop('#site-header-profile-logo', 'site-header-dropdown-menu-login', 10)
    window.addEventListener("resize", function(event) {
        setMarginTop('#site-header-profile-logo', 'site-header-dropdown-menu-login', 10)
    })
</script>
</body>
</html>