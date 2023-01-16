<?php
session_start();
include '../php-processes/dbConnection.php';
onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['devices'];

?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/devices-styles.css">
    <title>Devices</title>
</head>
<body>

<script>
    let devicesList = <?php echo json_encode(returnDevicesList()) ?>;
    let miscImgList = <?php echo json_encode(returnMiscImgList()) ?>;
    console.log(devicesList);
</script>

<div id="dv-main-body-div" class="text-font-500">

    <h1><?php echo $languageList['My devices'] ?></h1>

    <div class="separation-line-1"></div>

    <div id="dv-main-div">

        <div id="dv-devices-product-div" class="text-font-500">
<!--            DEVICES WILL BE DISPLAYED HERE-->

<!--            <div class='dv-devices-product'>-->
<!--                <div class='dv-product-image-div'>-->
<!--                    <div class='dv-image-name-div'>-->
<!--                        <span class='dv-name-span'>iCollar v1</span>-->
<!--                        <input class='dv-name-input' type='text'>-->
<!--                        <img class='dv-name-edit-img dv-name-img' src='--><?php //echo getImage('edit.png') ?><!--' alt='edit'>-->
<!--                        <img class='dv-name-cancel-img dv-name-img' src='--><?php //echo getImage('cancel.png') ?><!--' alt='edit'>-->
<!--                    </div>-->
<!--                    <img class='div-image-device' src='--><?php //echo getImage('iCollar_v1_black.png') ?><!--' alt='device img'>-->
<!--                </div>-->
<!---->
<!--                <div class='dv-product-info-div'>-->
<!--                    <div class='dv-info-container'>-->
<!--                        <img class='dv-container-image' src='--><?php //echo getImage('heart.png') ?><!--' alt='heart img'>-->
<!--                        <span class='dv-container-span'>Something</span>-->
<!--                    </div>-->
<!--                    <div class='dv-info-container'>-->
<!--                        <img class='dv-container-image' src='--><?php //echo getImage('co2.png') ?><!--' alt='heart img'>-->
<!--                        <span class='dv-container-span'>Something</span>-->
<!--                    </div>-->
<!--                    <div class='dv-info-container'>-->
<!--                        <img class='dv-container-image' src='--><?php //echo getImage('thermo.png') ?><!--' alt='heart img'>-->
<!--                        <span class='dv-container-span'>Something</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class='dv-product-button-div'>-->
<!--                    <button class='dv-more-info-button' type='button'>More information</button>-->
<!--                </div>-->
<!--            </div>-->


        </div>

        <div id="dv-devices-input-div" class="text-font-700">

        </div>

    </div>
</div>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'dv-main-body-div', 'id', 40)

    // setToWindowHeight('dv-main-body-div', 'id', 0)
    setMarginTopFooter('dv-main-body-div', 'id', 'site-footer-main-div', 'id', 0)
</script>

<script src="../javaScript/devices-buttons.js"></script>

</body>
</html>