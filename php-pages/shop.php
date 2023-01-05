<?php
session_start();
include '../php-processes/dbConnection.php';
onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['shop'];
?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/shop-styles.css">
    <title>Shop</title>
</head>
<body>

<div id="id-main-body-div" class="text-font-700">

    <div>

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
