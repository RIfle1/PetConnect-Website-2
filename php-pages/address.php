<?php
session_start();
include '../php-processes/dbConnection.php';
onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['address'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../css/address-styles.css">

    <title>Addresses</title>
</head>
<body>

<div id="ad-main-body-div" class="text-font-700">

    <div>
        <h1><?php echo $languageList["Addresses"]?></h1>
    </div>

    <div class="separation-line-2"></div>

    <div id="ad-main-div">

        <a href="#" id="ad-add-address-div" class="ad-address-div">
            <div class="ad-plus-div">
                <div class="ad-vertical-plus"></div>
                <div class="ad-horizontal-plus"></div>
            </div>
            <h2><?php echo $languageList["Add an address"]?></h2>
        </a>

<!--        DEFAULT ADDRESS -->
        <div class="ad-address-div">
            <div class="ad-default-div">
                <span class="text-font-500">Default Address</span>
            </div>
            <div class="ad-info-div-default">
                <span class="text-font-700">Test</span>
                <span class="text-font-500">Test</span>
                <span class="text-font-500">Test</span>
                <span class="text-font-500">Test</span>
                <span class="text-font-500">Test</span>
            </div>

            <div class="ad-href-div">
                <a class="text-font-500" href="#">Modify</a>
                <div class="ad-vertical-line-small"></div>
                <a class="text-font-500" href="#">Delete</a>
                <div class="ad-vertical-line-small"></div>
                <a class="text-font-500" href="#">Set as default</a>
            </div>
        </div>

<!--        NOT DEFAULT ADDRESS -->
        <div class="ad-address-div">

            <div class="ad-info-div-no-default">
                <span class="text-font-700">Test</span>
                <span class="text-font-500">Test</span>
                <span class="text-font-500">Test</span>
                <span class="text-font-500">Test</span>
                <span class="text-font-500">Test</span>
            </div>

            <div class="ad-href-div">
                <a class="text-font-500" href="#">Modify</a>
                <div class="ad-vertical-line-small"></div>
                <a class="text-font-500" href="#">Delete</a>
                <div class="ad-vertical-line-small"></div>
                <a class="text-font-500" href="#">Set as default</a>
            </div>

        </div>

    </div>

</div>

<?php include '../php-pages/site-footer.php' ?>

<script type="text/javascript">
    setMarginTop('site-header-main-header', 'id', 'ad-main-body-div', 'id', 40)

    // setToWindowHeight('ad-main-body-div', 'id', 0)
    setMarginTopFooter('ad-main-body-div', 'id', 'site-footer-main-div', 'id', 0)

</script>

</body>
</html>
