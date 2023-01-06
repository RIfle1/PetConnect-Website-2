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

<div id="sh-main-body-div" class="text-font-700">


    <div id="sh-main-header-div" class="container">
        <div id="sh-header-info-div">
            <h1 class="text-font-500">Connected Collars for dogs</h1>
            <span class="text-font-300">GPS Location, Heart sensor, Thermal Sensor, Sound Sensor, CO2 Rate</span>
        </div>
        <div id="sh-header-product-img-div">
            <img src="<?php echo getImage('iCollar_logo.png') ?>" alt="iCollar_logo.png">
        </div>
    </div>

    <div id="sh-shaped-div">
        <div id="sh-shaped-weird-div">
            <div id="sh-weird-shape-1-absolute" class="weird-shape"></div>
            <div id="sh-weird-shape-1" class="weird-shape"></div>
            <div id="sh-weird-shape-2"></div>
        </div>
        <div id="sh-shaped-rest-div"></div>
    </div>

    <div id="sh-main-product-div" class="container text-font-300">
        <div id="sh-image-display-div">
            <img src="<?php echo  getImage('iCollar_v1_white.png')?>" alt="iCollar">
            <div id="sh-image-interaction-div">
                <span>test</span>
            </div>
        </div>
        <div id="sh-info-div">
            <div id="sh-info-description-div">
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
                </p>
            </div>

            <div id="sh-info-price-div">
                <span id="sh-info-price-span-1">499€</span><span id="sh-info-price-span-2">99</span>
            </div>

            <div id="sh-info-interaction-div" class="text-font-700">
                <div id="sh-interaction-color" class="sh-interaction-column">
                    <div id="sh-color-active" class="sh-color sh-select-active">
                        <span>White</span>
                        <div>
                            <svg viewBox="141.487 173.152 12.86 11.627" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path d="M 146.325 -183.555 Q 147.592 -185.862 148.986 -183.555 L 153.817 -175.564 Q 155.211 -173.257 152.55 -173.257 L 143.331 -173.257 Q 140.67 -173.257 141.937 -175.564 Z" style="fill-rule: nonzero; stroke-miterlimit: 1; stroke-width: 0px; paint-order: fill; stroke: rgb(197, 190, 190); fill: rgb(135, 137, 131);" transform="matrix(1, 0, 0, -1, 0, 0)"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="sh-color-hidden" class="sh-color sh-select-hidden" state="hidden">
                        <ul>
<!--                            <li>Black</li>-->
<!--                            <li>Blue</li>-->
<!--                            <li>Green</li>-->
<!--                            <li>Red</li>-->
<!--                            <li>White</li>-->
<!--                            <li>Yellow</li>-->
<!--                            <li>Black</li>-->
                        </ul>
                        <div id="sh-color-custom" class="sh-select-custom">
                        </div>
                    </div>
                </div>

                <div id="sh-interaction-amount" class="sh-interaction-column">
                    <input id="sh-amount-input" class="sh-amount" type="text" max="100" min="1" value="1">
                    <div id="sh-amount-active" class="sh-amount sh-select-active">
                        <span>1</span>
                        <div>
                            <svg viewBox="141.487 173.152 12.86 11.627" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path d="M 146.325 -183.555 Q 147.592 -185.862 148.986 -183.555 L 153.817 -175.564 Q 155.211 -173.257 152.55 -173.257 L 143.331 -173.257 Q 140.67 -173.257 141.937 -175.564 Z" style="fill-rule: nonzero; stroke-miterlimit: 1; stroke-width: 0px; paint-order: fill; stroke: rgb(197, 190, 190); fill: rgb(135, 137, 131);" transform="matrix(1, 0, 0, -1, 0, 0)"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="sh-amount-hidden" class="sh-amount sh-select-hidden" state="hidden">
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
                        <div id="sh-amount-custom" class="sh-select-custom">
                            <span>Custom</span>
                        </div>
                    </div>
                </div>

                <div id="sh-interaction-buttons" class="sh-interaction-row">
                    <button id="sh-interaction-add-button" type="button" value="prd01">Add to basket</button>
                    <button id="sh-interaction-buy-button" type="button" value="prd01">Buy this product</button>
                </div>
            </div>

            <div id="sh-info-delivery-div">
                <div class="sh-delivery-span-div">
                    <span>Ecological Packaging </span>
                    <img src="<?php echo getImage('eco.png') ?>" alt="">
                </div>
                <div class="sh-delivery-span-div">
                    <span>Delivery under 48h </span>
                    <img src="<?php echo getImage('delivery.png') ?>" alt="">
                </div>
                <div class="sh-delivery-span-div">
                    <span>Satisfied or reimbursed</span>
                    <img src="<?php echo getImage('satisfied.png') ?>" alt="">
                </div>
            </div>

        </div>

    </div>
<!--    <div id="sh-main-bottom-div">-->
<!---->
<!--    </div>-->

</div>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('site-header-main-header', 'id', 'sh-main-body-div', 'id', 40)

    // setToWindowHeight('ad-main-body-div', 'id', 0)
    setMarginTopFooter('sh-main-body-div', 'id', 'site-footer-main-div', 'id', 0)
</script>

<script src="../javaScript/shop-buttons.js"></script>

</body>
</html>
