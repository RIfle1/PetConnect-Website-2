<?php

session_start();
include '../php-processes/dbConnection.php';
clientAndNoUserPage();

include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['checkout'];
$basketList = returnBasketList();

?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/checkout-styles.css">
    <title>Checkout</title>
</head>
<body>

<div id="ch-main-body-div" class="text-font-500">

    <h1><?php echo $languageList['Checkout'] ?></h1>

    <div class="separation-line-1"></div>

    <div id="ch-main-div">

        <div id="ch-checkout-product-div">
            <!--        BASKET WILL BE DISPLAYED HERE-->
        </div>

        <div id="ch-checkout-total-div">
            <span>Your Total is:</span>
        </div>

        <div id="ch-checkout-buttons-div">

        </div>

    </div>
</div>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'ch-main-body-div', 'id', 40)

    // setToWindowHeight('ad-main-body-div', 'id', 0)
    setMarginTopFooter('ch-main-body-div', 'id', 'site-footer-main-div', 'id', 0)

    // IMG STUFF
    // setHeightAndWidth('ch-product-image', 'class', 'ch-product-image-background', 'class', 0)
    // setMargin('ch-product-image', 'class', 'ch-product-image-background', 'class', 0)
</script>

<script src="../javaScript/checkout-buttons.js"></script>

</body>
</html>
