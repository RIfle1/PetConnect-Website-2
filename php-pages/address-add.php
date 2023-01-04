<?php
session_start();
include '../php-processes/dbConnection.php';
onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['address-add'];
$header = '';
$addressInfo = '';
$adrAddress = '';
$adrAddressOptional = '';
$adrPostalCode = '';
$adrCity = '';


if(empty($_GET['type'])) {
    $header = $languageList["Add a new address"];
    $button = $languageList["Add new address"];
}
else {
    $header = $languageList["Modify Address"];
    $button = $languageList["Submit Changes"];

    $addressInfo = returnAddressInfo($_GET['adrID']);
    $adrAddress = $addressInfo[0]["adrAddress"];
    $adrAddressOptional = $addressInfo[0]["adrAddressOptional"];
    $adrPostalCode = $addressInfo[0]["adrPostalCode"];
    $adrCity = $addressInfo[0]["adrCity"];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../css/address-add-styles.css">

    <title>Address Add</title>
</head>
<body>

<form id="add-form" name="add-form" action="../php-processes/address-add-process.php?type=<?php echo $_GET['type']?>&adrID=<?php echo $_GET['adrID']?>" method="post">
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
