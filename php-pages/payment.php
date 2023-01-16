<?php
session_start();
include '../php-processes/dbConnection.php';
clientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['connection-security'];

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--    Style Sheet-->
    <link rel="stylesheet" href="../css/payment-method-style.css">
    <link rel="stylesheet" href="../css/basket-styles.css">
    <!--    Jquery-->

    <title>PetConnect Connection and Security</title>
</head>

<body>
    <div id="py-form-body" class="text-font-500">
        <main>
            <section>
                <div class="container">
                    <div class="text">
                        <h2>Total TCT:</h2>
                        <hr>
                        <hr>
                        <div class="prix">
                            <h2>499€</h2>
                        </div>

                        <p>Total HT:</p>
                        <div class="prix2">
                            <p>499,99€</p>
                        </div>

                        <p>Taxe:</p>
                        <div class="prix2">
                            <p>499,99€</p>
                        </div>
                        <hr id="trait">
                        <h3>Récapitulatif de ma commande</h3>
                        <input type="submit" id="mod" value="Modifier">
                        <img src="<?php echo getImage("iCollar_blanc2.png") ?>" />
                        <h4>1 × iCollar <br>Couleur</h4>
                        <h3 class="prix3">499€</h3>

                        <hr id="trait2">
                        <div id="livraison">
                            <p>Livraison gratuite en France <br> métropolitaine</p>
                        </div>
                        <div id="continue">
                            <form action="../php-processes/shop-process.php" method="post">
                                <button type="submit" name="pay">
                                    <a>Payer</a>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <form>
                <h2>Mode de paiement</h2>
                <div>
                    <ul id="pay">
                        <li><a href="#">Carte Bancaire</a></li>
                        <li><a href="#">PAYPAL</a></li>
                        <li><a href="#">Apple Pay</a></li>
                    </ul>
                </div>
            </form>
        </main>
    </div>



    <script type="text/javascript">
        setMarginTop('site-header-main-header', 'id', 'py-form-body', 'id', 40)
    </script>

    <script src="../javaScript/connection-security-buttons.js"></script>

</body>

</html>