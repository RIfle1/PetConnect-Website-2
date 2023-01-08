<?php
session_start();

if(empty($_GET['prdID'])) {
    header("Location: ../php-pages/restricted-access.php", true, 303);
    exit;
}

include '../php-processes/dbConnection.php';
clientAndNoUserPage();

$product = returnProductList('')[$_GET['prdID']];

if($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['getProduct'])) {
    header("Content-Type: application/json");
    echo json_encode(['productJson' => $product]);
    exit;
}

include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['shop'];



$productPriceInt = returnProductIntPrice($product['prdPrice']);
$productPriceDecimal = returnProductDecimalPrice($product['prdPrice']);
?>

<script>
    // JSON VARIABLES
    let productJson = <?php echo json_encode($product) ?>;
</script>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/product-styles.css">
    <title>Shop</title>
</head>
<body>

<div id="pr-main-body-div" class="text-font-700">


    <div id="pr-main-header-div" class="pr-container">
        <div id="pr-header-info-div">
            <h1 class="text-font-500"><?php echo $product['prdName'] ?></h1>
            <span class="text-font-300">GPS Location, Heart sensor, Thermal Sensor, Sound Sensor, CO2 Rate (ADD TO DB)</span>
        </div>
        <div id="pr-header-product-img-div">
            <img src="<?php echo getImage('iCollar_logo.png') ?>" alt="iCollar_logo.png">
        </div>
    </div>

    <div id="pr-shaped-div">
        <div id="pr-shaped-weird-div">
            <div id="pr-weird-shape-1-absolute" class="weird-shape"></div>
            <div id="pr-weird-shape-1" class="weird-shape"></div>
            <div id="pr-weird-shape-2"></div>
        </div>
        <div id="pr-shaped-rest-div"></div>
    </div>

    <div id="pr-main-product-div" class="pr-container text-font-300">
        <div id="pr-image-display-div">
            <div id="pr-current-image-div">
                <!--            <img src="--><?php //echo getImage('iCollar_v1_white.png')?><!--" alt="iCollar">-->
            </div>
            <div id="pr-image-interaction-div">
<!--                <img src="--><?php //echo getImage('iCollar_v1_white.png')?><!--" alt="iCollar">-->
<!--                <img src="--><?php //echo getImage('iCollar_v1_black.png')?><!--" alt="iCollar">-->
<!--                <img src="--><?php //echo getImage('iCollar_v1_blue.png')?><!--" alt="iCollar">-->
<!--                <img src="--><?php //echo getImage('iCollar_v1_green.png')?><!--" alt="iCollar">-->
<!--                <img src="--><?php //echo getImage('iCollar_v1_red.png')?><!--" alt="iCollar">-->
<!--                <img src="--><?php //echo getImage('iCollar_v1_yellow.png')?><!--" alt="iCollar">-->
            </div>
        </div>
        <div id="pr-info-div">
            <div id="pr-info-description-div">
                <p>
                    Our smart dog collar is the ultimate tool for keeping your furry friend safe and healthy.
                    With GPS location tracking, you'll always know where your dog is, even when they're off the leash.
                    Plus, the built-in heart sensor allows you to monitor your dog's vital signs.
                    <br>
                    The collar also has a thermal sensor that can detect your dog's body temperature,
                    alerting you if they're running a fever or experiencing other health issues.
                    The sound sensor can detect barking and other noises, alerting you if your dog is in distress.
                    <br>
                    But that's not all – the collar can also calculate the CO2 density around your dog,
                    ensuring they're always breathing fresh air.
                    <br>
                    Durable and water-resistant, this collar is built to withstand the elements and go wherever your dog goes.
                    With a long-lasting battery life, you won't have to worry about constantly recharging it.
                    (ADD TO DB)
                </p>
            </div>

            <div id="pr-info-price-div">
                <span id="pr-info-price-span-1"><?php echo $productPriceInt ?>€</span><span id="pr-info-price-span-2"><?php echo $productPriceDecimal ?></span>
            </div>

            <div id="pr-info-interaction-div" class="text-font-700">
                <div id="pr-interaction-color" class="pr-interaction-column">
                    <div id="pr-color-active" class="pr-color pr-select-active">
                        <span id="pr-active-selected-color-span">White</span>
                        <div>
                            <svg viewBox="141.487 173.152 12.86 11.627" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path d="M 146.325 -183.555 Q 147.592 -185.862 148.986 -183.555 L 153.817 -175.564 Q 155.211 -173.257 152.55 -173.257 L 143.331 -173.257 Q 140.67 -173.257 141.937 -175.564 Z" style="fill-rule: nonzero; stroke-miterlimit: 1; stroke-width: 0px; paint-order: fill; stroke: rgb(197, 190, 190); fill: rgb(135, 137, 131);" transform="matrix(1, 0, 0, -1, 0, 0)"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="pr-color-hidden" class="pr-color pr-select-hidden" state="hidden">
                        <ul>
<!--                            <li>Black</li>-->
<!--                            <li>Blue</li>-->
<!--                            <li>Green</li>-->
<!--                            <li>Red</li>-->
<!--                            <li>White</li>-->
<!--                            <li>Yellow</li>-->
<!--                            <li>Black</li>-->
                        </ul>
                        <div id="pr-color-custom" class="pr-select-custom">
                        </div>
                    </div>
                </div>

                <div id="pr-interaction-amount" class="pr-interaction-column">
                    <input id="pr-amount-input" class="pr-amount" type="text" max="100" min="1" value="1">
                    <div id="pr-amount-active" class="pr-amount pr-select-active">
                        <span id="pr-active-selected-amount-span">1</span>
                        <div>
                            <svg viewBox="141.487 173.152 12.86 11.627" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path d="M 146.325 -183.555 Q 147.592 -185.862 148.986 -183.555 L 153.817 -175.564 Q 155.211 -173.257 152.55 -173.257 L 143.331 -173.257 Q 140.67 -173.257 141.937 -175.564 Z" style="fill-rule: nonzero; stroke-miterlimit: 1; stroke-width: 0px; paint-order: fill; stroke: rgb(197, 190, 190); fill: rgb(135, 137, 131);" transform="matrix(1, 0, 0, -1, 0, 0)"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="pr-amount-hidden" class="pr-amount pr-select-hidden" state="hidden">
                        <ul>
<!--                            <li>1</li>-->
<!--                            <li>2</li>-->
<!--                            <li>3</li>-->
<!--                            <li>4</li>-->
<!--                            <li>5</li>-->
<!--                            <li>6</li>-->
<!--                            <li>7</li>-->
<!--                            <li>8</li>-->
<!--                            <li>9</li>-->
                        </ul>
                        <div id="pr-amount-custom" class="pr-select-custom">
                            <span>Custom</span>
                        </div>
                    </div>
                </div>

                <div id="pr-interaction-buttons" class="pr-interaction-row">
                    <button id="pr-interaction-add-button" type="button" value="prd01">Add to basket</button>
                    <button id="pr-interaction-buy-button" type="button" value="prd01">Buy this product</button>
                </div>
            </div>

            <div id="pr-info-delivery-div">
                <div class="pr-delivery-span-div">
                    <span>Ecological Packaging </span>
                    <img src="<?php echo getImage('eco.png') ?>" alt="">
                </div>
                <div class="pr-delivery-span-div">
                    <span>Delivery under 48h </span>
                    <img src="<?php echo getImage('delivery.png') ?>" alt="">
                </div>
                <div class="pr-delivery-span-div">
                    <span>Satisfied or reimbursed</span>
                    <img src="<?php echo getImage('satisfied.png') ?>" alt="">
                </div>
            </div>

        </div>

    </div>
<!--    <div id="pr-main-bottom-div">-->
<!---->
<!--    </div>-->

</div>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'pr-main-body-div', 'id', 40)

    setToWindowHeight('ad-main-body-div', 'id', 0)
    setMarginTopFooter('pr-main-body-div', 'id', 'site-footer-main-div', 'id', 0)
</script>

<script src="../javaScript/product-buttons.js"></script>

</body>
</html>
