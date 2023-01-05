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
        <a href="../php-pages/address-add.php?type=&adrID=" id="ad-add-address-div" class="ad-address-div">
            <div class="ad-plus-div">
                <div class="ad-vertical-plus"></div>
                <div class="ad-horizontal-plus"></div>
            </div>
            <h2><?php echo $languageList["Add an address"]?></h2>
        </a>
    </div>

</div>

<?php include '../php-pages/site-footer.php' ?>

<script type="text/javascript">
    setMarginTop('site-header-main-header', 'id', 'ad-main-body-div', 'id', 40)

    // setToWindowHeight('ad-main-body-div', 'id', 0)
    setMarginTopFooter('ad-main-body-div', 'id', 'site-footer-main-div', 'id', 0)

</script>

<script src="../javaScript/address-buttons.js"></script>

</body>
</html>
