<?php
session_start();
include '../php-processes/dbConnection.php';
clientAndNoUserPage();

include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['shop'];

$productList = deObjectifyList(returnProductList(''));

?>

<script>
    // JSON VARIABLES
    let productList = <?php echo json_encode($productList) ?>;
</script>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/shop-styles.css">
    <title>Shop</title>
</head>
<body>

<div id="sh-main-body-div" class="text-font-500">

    <h1><?php echo $languageList['Shop'] ?></h1>

    <div class="separation-line-1"></div>

    <div id="sh-main-div">
<!--        PRODUCTS WILL BE DISPLAYED HERE-->
    </div>

</div>

<?php include '../php-pages/site-footer.php' ?>

<script src="../javaScript/shop-buttons.js"></script>

<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'sh-main-body-div', 'id', 40)

    // setToWindowHeight('ad-main-body-div', 'id', 0)
    setMarginTopFooter('sh-main-body-div', 'id', 'site-footer-main-div', 'id', 0)

    // IMG STUFF
    setHeightAndWidth('sh-product-image', 'class', 'sh-product-image-background', 'class', 0)
    setMargin('sh-product-image', 'class', 'sh-product-image-background', 'class', 0)
</script>


</body>
</html>
