<?php
include_once '../php-processes/dbConnection.php';
include '../php-processes/login-check.php';
include '../php-processes/authenticity-check.php';

$language = returnLanguage();
$languageList = returnLanguageList()[$language]['site-header'];
$languageListKeys = array_keys(returnLanguageList());
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;500;700&display=swap" rel="stylesheet">

<!--    Style Sheet-->
    <link rel="stylesheet" href="../css/site-header-styles.css">
    <link rel="stylesheet" href="../css/common-styles.css">
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
<div id="site-header-main-header">

    <div class="site-header-logo">
        <a href="home.php"><img src="<?php echo getImage('PetConnect-Logo.png')?>" alt="PetConnect-Logo"></a>
    </div>

    <div class="text-font-500" id="site-header-menu">
        <a href="home.php"><?php echo $languageList['Home Page']?></a>
        <a href=<?php restrictedAdminPage("shop.php") ?>><?php echo $languageList['Shop'] ?></a>
        <a href="assistance.php"><?php echo $languageList['Assistance'] ?></a>
    </div>

    <div class="site-header-profile">
        <form method="POST" name="language-form" action="../php-processes/language-process.php" class="text-font-500" id="site-header-language-selector">
            <div id="language-selector-current-div">
                <span><?php echo strtoupper(substr($language, 0, 2)) ?></span>
                <img class="site-header-profile-img-2" src="<?php echo getImage($language.'Flag.png')?>" alt="EnglishFlag">
            </div>
            <div id="language-selector-button-div">

                <?php for ($i = 0; $i < sizeof($languageListKeys); $i++): ?>
                    <?php if($languageListKeys[$i] !== $language): ?>
                    <button type="submit" class="text-font-500" name="language-button" value="<?php echo $languageListKeys[$i] ?>">
                        <span><?php echo strtoupper(substr($languageListKeys[$i], 0, 2)) ?></span>
                        <img class="site-header-profile-img-2" src="<?php echo getImage($languageListKeys[$i].'Flag.png')?>" alt="Flag">
                    </button>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </form>
        <div id="site-header-profile-div-flex">
            <div id="site-header-profile-logo">
                <a href="<?php restrictedNoUserPage('../php-pages/profile.php') ?>">
                    <?php if(isset($loggedIn) && isset($entityInfo) && isset($entityAttributes)): ?>
                        <?php if($loggedIn && strlen($entityInfo[$entityAttributes["PfpName"]]) > 0): ?>
                            <img class="site-header-profile-img-1" src="../img/pfp/<?php echo getPfp($entityAttributes['ID'], $entityAttributes['Table'], $entityInfo[$entityAttributes['ID']])[$entityAttributes["PfpName"]] ?>" alt="Profile picture">
                        <?php endif; ?>
                    <?php else: ?>
                        <img class="site-header-profile-img-1" src="<?php echo getImage('client.png')?>" alt="Client-logo">
                    <?php endif; ?>

                </a>
            </div>
            <div id="site-header-dropdown-menu-login" class="text-font-300">
                <?php if(isset($loggedIn) && isset($entityInfo) && isset($entityAttributes)): ?>
                    <?php if($loggedIn): ?>
                        <p><?php echo $languageList['Hello'] ?> <?php echo $entityInfo[$entityAttributes["FirstName"]]." ".$entityInfo[$entityAttributes["LastName"]]?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <div id="site-header-signup">
                        <a id="site-header-signup-a1" href="login.php"><?php echo $languageList['Sign in'] ?></a>
                        <p><?php echo $languageList['New Client?'] ?><a id="site-header-signup-a2" href="signup.php"><?php echo $languageList['Signup.'] ?></a></p>
                    </div>
                <?php endif; ?>
                <?php if(isset($loggedIn)): ?>
                    <?php if($loggedIn): ?>
                        <div class="separation-line-1"></div>
                        <a href="profile.php"><?php echo $languageList['My Account'] ?></a>
                        <a href="#"><?php echo $languageList['My Orders'] ?></a>
                        <a href="#"><?php echo $languageList['My Devices'] ?></a>
                        <div class="separation-line-1"></div>
                        <a href="../php-processes/logout.php"><?php echo $languageList['Logout'] ?></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <a href="#"><img class="site-header-profile-img-1" src="<?php echo getImage('basket.png')?>" alt="Basket-logo"></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    setMarginTop('site-header-profile-logo', 'id', 'site-header-dropdown-menu-login', 'id', 10)
    setMarginTop('site-header-language-selector', 'id', 'language-selector-button-div', 'id', 3)
    setWidth('language-selector-current-div', 'id', 'language-selector-button-div', 'id', 0)
</script>
</body>
</html>