<?php
include_once '../php-processes/dbConnection.php';
include '../php-processes/login-check.php';
include '../php-processes/authenticity-check.php';

// CHECK WHO'S LOGGED IN
$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];
$entityInfo = returnEntityInfo();
$entityAttributes = returnEntityAttributes();


$language = returnLanguage();
$languageList = returnLanguageList()[$language]['site-header'];
$languageListKeys = array_keys(returnLanguageList());

$basketList = returnBasketList();
?>
<!doctype html>
<html lang="en">

<head>
    <!--    META-->
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--    ICON-->
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
    <!--    Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;500;700&display=swap" rel="stylesheet">

    <!--    Style Sheet-->
    <link rel="stylesheet" href="../css/site-header-styles.css">
    <link rel="stylesheet" href="../css/common-styles.css">
    <!--    Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous">
    </script>
    <!--    Css Function-->
    <script src="../javaScript/css-functions.js"></script>
</head>

<body>

<script>
    let trashImagePath = '<?php echo getImage('trash.png') ?>';
    let basketList = <?php echo json_encode($basketList) ?>;
</script>

<div id="sih-main-header">

    <div id="sih-logo">
        <a href="home.php"><img src="<?php echo getImage('PetConnect-Logo.png') ?>" alt="PetConnect-Logo"></a>
    </div>

    <div id="sih-menu" class="text-font-500">
        <a href="home.php"><?php echo $languageList['Home Page'] ?></a>
        <a href="shop.php"><?php echo $languageList['Shop'] ?></a>
        <a href="assistance.php"><?php echo $languageList['Assistance'] ?></a>
    </div>

    <div id="sih-interaction-main-div">
        <form id="sih-language-selector" class="text-font-500 sih-interaction-sub-div" method="POST" name="language-form"
              action="../php-processes/language-process.php?page=<?php echo $_SERVER['REQUEST_URI']?>">
            <div id="sih-language-selector-current-div">
                <span><?php echo strtoupper(substr($language, 0, 2)) ?></span>
                <img class="sih-interaction-img-2" src="<?php echo getImage($language . 'Flag.png') ?>" alt="EnglishFlag">
            </div>
            <div id="sih-language-selector-button-div">

                <?php for ($i = 0; $i < sizeof($languageListKeys); $i++) : ?>
                    <?php if ($languageListKeys[$i] !== $language) : ?>
                        <button type="submit" class="text-font-500" name="language-button" value="<?php echo $languageListKeys[$i] ?>">
                            <span><?php echo strtoupper(substr($languageListKeys[$i], 0, 2)) ?></span>
                            <img class="sih-interaction-img-2" src="<?php echo getImage($languageListKeys[$i] . 'Flag.png') ?>" alt="Flag">
                        </button>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </form>
        <div id="sih-profile-div" class="sih-interaction-sub-div">
            <div id="sih-profile-logo">
                <a href="<?php restrictedNoUserPage('../php-pages/profile.php') ?>">
                    <img class="sih-interaction-img-1" src="<?php echo getPfp($entityAttributes['ID'], $_SESSION['Table'], $_SESSION['ID'])?>" alt="Profile picture">
                </a>
            </div>
            <div id="sih-dropdown-menu-login" class="sih-dropdown-menu text-font-300">
                <?php if ($loggedIn) : ?>
                    <span><?php echo $languageList['Hello'] ?> <?php echo $entityInfo[$entityAttributes["FirstName"]] . " " . $entityInfo[$entityAttributes["LastName"]] ?></span>
                    <div class="separation-line-1"></div>
                    <a href="profile.php"><?php echo $languageList['My Account'] ?></a>
                    <?php if($clientLoggedIn): ?>
                        <a href="../php-pages/devices.php"><?php echo $languageList['My Devices'] ?></a>
                        <a href="../php-pages/order-history.php"><?php echo $languageList['My Order History'] ?></a>
                        <a href="../php-pages/payment-method.php"><?php echo $languageList['My Payment Methods'] ?></a>
                        <a href="../php-pages/address.php"><?php echo $languageList['My Addresses'] ?></a>

                        <a href="../php-pages/connection-security.php"><?php echo $languageList['Connection And Security'] ?></a>
                        <a href="../php-pages/message-center.php"><?php echo $languageList['Message Center'] ?></a>
                    <?php elseif($adminLoggedIn): ?>
                        <a href="../php-pages/manage-user.php"><?php echo $languageList['Manage Users'] ?></a>
                        <a href="../php-pages/assistance-manage.php"><?php echo $languageList['Answer Questions'] ?></a>

                        <a href="../php-pages/connection-security.php"><?php echo $languageList['Connection And Security'] ?></a>
                        <a href="../php-pages/message-center.php"><?php echo $languageList['Message Center'] ?></a>
                    <?php endif; ?>
                    <div class="separation-line-1"></div>
                    <a href="../php-processes/logout.php"><?php echo $languageList['Logout'] ?></a>
                <?php else: ?>
                    <div id="sih-signup">
                        <a id="sih-signup-a1" href="login.php"><?php echo $languageList['Sign in'] ?></a>
                        <span><?php echo $languageList['New Client?'] ?><a id="sih-signup-a2" href="signup.php"><?php echo $languageList['Signup.'] ?></a></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div id="sih-basket-div" class="sih-interaction-sub-div">
            <div id="sih-basket-logo" class="text-font-500">
                <a href="../php-pages/shop.php"><img class="sih-interaction-img-1" src="<?php echo getImage('basket.png') ?>" alt="Basket-logo"></a>
                <span id="sih-basket-count-span"></span>
            </div>
            <?php if(!$loggedIn || $clientLoggedIn): ?>
                <div id="sih-dropdown-menu-basket" class="sih-dropdown-menu text-font-300">
                    <div id="sih-basket-product-div">
<!--                    BASKET ITEMS WILL APPEAR HERE-->
                    </div>
                    <div id="sih-basket-separation-line" class="separation-line-1"></div>
                    <div id='sih-basket-total-div' class="text-font-700">
                        <span id="sih-basket-price-span" class="sih-basket-price-span-normal"><?php echo $languageList["Your Total is"] ?>:</span>
                    </div>
                    <div id="sih-basket-empty-div" class="text-font-700">
                        <span><?php echo $languageList["Start adding items to your basket"] ?>!</span>
                    </div>
                    <div class="sih-basket-button-div">
                        <button id="sih-basket-delete-all-button"><?php echo $languageList["Delete all items"] ?></button>
                        <a href="../php-pages/checkout.php"><button id="sih-basket-checkout-page-button"><?php echo $languageList["Go to Checkout Page"] ?></button></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    setMarginTop('sih-profile-logo', 'id', 'sih-dropdown-menu-login', 'id', 10)
    setMarginTop('sih-basket-logo', 'id', 'sih-dropdown-menu-basket', 'id', 10)

    setMarginTop('sih-language-selector', 'id', 'sih-language-selector-button-div', 'id', 10)
    // setWidth('language-selector-current-div', 'id', 'sih-language-selector-button-div', 'id', 0)
</script>

<script src="../javaScript/site-header-basket.js"></script>

</body>

</html>