<?php
session_start();
include '../php-processes/dbConnection.php';
//onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['address-add'];
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

<form id="add-form" name="add-address-form" action="../php-processes/address-add-process.php" method="post">

    <div id="add-form-body-div" class="text-font-700">
        <div class="add-form-elem">
            <h1><?php echo $languageList["Add a new address"]?></h1>
        </div>
        <div class="add-form-elem">
            <label for="adrAddress-input"><?php echo $languageList["Address"]?>:</label>
            <input type="text" id="add-form-address" name="adrAddress-input" placeholder="">
            <input type="text" id="add-form-addressOptional" name="adrAddressOptional-input">
        </div>
        
        <div class="add-form-elem">
            <label for="adrPostalCode"><?php echo $languageList["Postal Code"]?>:</label>
            <input type="text" id="add-form-postalCode" name="adrPostalCode">
        </div>
        
        <div class="add-form-elem">
            <label for="adrPostalCode"><?php echo $languageList["City"]?>:</label>
            <input type="text" id="add-form-city" name="adrCity">
        </div>

    </div>
</form>


<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setToWindowHeight('add-form', 'id', 0)
    setMarginTopFooter('add-form', 'id', 'site-footer-main-div', 'id', 0)
</script>

</body>
</html>
