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
    <link rel="stylesheet" href="../css/basket-styles.css">
    <!--    Jquery-->

    <title>PetConnectBasket</title>
</head>

<body>
    <div id="bk-form-body" class="text-font-500">
        <main id="basket">
            <section id="group">
                <div id="user">
                    <h3>Connecté en tant que :<p>utilisateur@gmail.com</p>
                    </h3>

                </div>
                <div class="info">
                    <p>Prénom*</p>
                    <input type="text" id="Prénom" name="Prénom" required>
                    <div id="name">
                        <p>Nom*</p>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <p>Numéro de mobile</p>
                    <input type="text" id="phone" name="phone" required>
                </div>

                <div id="adress">
                    <h3>Adresse de livraison</h3>
                    <div class="info">
                        <p>Code Postal*</p>
                        <input type="text" id="postal" name="Postal" required>
                        <div id="town">
                            <p>Ville*</p>
                            <input type="text" id="ville" name="ville" required>
                        </div>
                        <p>Numéro et nom de voie*</p>
                        <input type="text" id="rue" name="rue" required>
                    </div>
                </div>
                <div id="enregistrer">
                    <h4>*Champ obligatoire</h4>
                </div>
            </section>


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
                            <a href="payment.php">Continuer</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>


    <?php include 'site-footer.php' ?>

    <script type="text/javascript">
        setMarginTop('site-header-main-header', 'id', 'bk-form-body', 'id', 40)
    </script>

    <script src="../javaScript/connection-security-buttons.js"></script>

</body>

</html>