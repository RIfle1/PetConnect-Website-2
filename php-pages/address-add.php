<?php
session_start();
include '../php-processes/dbConnection.php';
onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['address-add'];

if(empty($_GET['type'])) {
    $type = '';

    $header = $languageList["Add a new address"];
    $button = $languageList["Add new address"];

    $adrID = '';
    $adrAddress = '';
    $adrAddressOptional = '';
    $adrPostalCode = '';
    $adrCity = '';
}
else {
    $type = $_GET['type'];

    $header = $languageList["Modify Address"];
    $button = $languageList["Submit Changes"];

    $addressInfo = returnAddressInfo($_GET['adrID']);
    $adrID = $_GET['adrID'];
    $adrAddress = $addressInfo[0]["adrAddress"];
    $adrAddressOptional = $addressInfo[0]["adrAddressOptional"];
    $adrPostalCode = $addressInfo[0]["adrPostalCode"];
    $adrCity = $addressInfo[0]["adrCity"];
}
?>

<!doctype html>
<html lang="en">
<head>


    <link rel="stylesheet" href="../css/address-add-styles.css">

    <title><?php echo $languageList["Address"]?></title>
</head>
<body>

<form id="add-form" name="add-form" action="../php-processes/address-add-process.php?type=<?php echo $type?>&adrID=<?php echo $adrID?>" method="post">
    <div id="add-form-body-div" class="text-font-700">
        <div class="add-form-elem">
            <h1><?php echo $header?></h1>
        </div>
        <div class="add-form-elem">
            <label for="adrAddress-input"><?php echo $languageList["Address"]?>:</label>
            <input type="text" id="add-form-address" name="adrAddress-input" value="<?php echo $adrAddress ?>" placeholder="<?php echo $languageList['Street address or P.O. Box'] ?>">
            <input type="text" id="add-form-addressOptional" name="adrAddressOptional-input" value="<?php echo $adrAddressOptional ?>" placeholder="<?php echo $languageList['Apt, suit, unit, building, floor, etc.'] ?>">
        </div>

        <div class="add-form-elem">
            <label for="adrPostalCode"><?php echo $languageList["Postal Code"]?>:</label>
            <input type="text" id="add-form-postalCode" name="adrPostalCode-input" value="<?php echo $adrPostalCode ?>">
        </div>

        <div class="add-form-elem">
            <label for="adrPostalCode"><?php echo $languageList["City"]?>:</label>
            <input type="text" id="add-form-city" name="adrCity-input" value="<?php echo $adrCity ?>">
        </div>

        <div class="separation-line-small"></div>

        <div class="add-form-elem">
            <button type="button" id="add-form-submit-button"><?php echo $button?></button>
        </div>

    </div>
</form>


<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setToWindowHeight('add-form', 'id', 0)
    setMarginTopFooter('add-form', 'id', 'site-footer-main-div', 'id', 0)
</script>
<script src="../javaScript/validation-functions.js"></script>
<script src="../javaScript/address-add-validation.js"></script>

</body>
</html>
