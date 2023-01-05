<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['home'];

?>
<!doctype html>
<html lang="en">

<head>

    <link rel="stylesheet" href="../css/home-styles.css">
    <title>PetConnect</title>
</head>

<body>

<main id="home-main-div" class="text-font-700">

    <slogan>
        <div class="fondimage">
            <h1>
                <img src="<?php echo getImage("iCollar_logo.png") ?>"  alt="image"/>
            </h1>
        </div>
        <h2>
            La technologie pour vos animaux
        </h2>
    </slogan>

    <section1>
        <div class="grid reveal fade-bottom">
            <div class="carre black reveal fade-bottom2">
                <p id="pink" class="reveal fade-bottom3">nouveau</p>
                <img class="reveal fade-bottom3" src="<?php echo getImage("iCollar_white.png") ?>" />
                <h3 id="iCollar">iCollar</h3>
                <p id="grey">Le collier connecté pour chien</p>
                <div>
                    <a href="boutique.php" class="espace">En savoir plus &gt;</a>

                    <a href="basket.php">Acheter +</a>
                </div>
            </div>
            <div class="box1">
                <h3>Livraison <br>offerte</h3>
                <p><br>Livraison gratuite en <strong>France Métropolitaine</strong></p>
            </div>
            <div class="box2 black">
                <h3>7 jours <br>d'essai</h3>
                <p><br>Nous acceptons les retours dans les 7 jours après la livraison</p>
            </div>
            <div class="box2 black">
                <h3>Paiements <br>sécurisés</h3>
                <p><br>Paiements 100% cryptés <br>
                    <br>Méthodes de paiement acceptées:<strong> Paypal, Visa,
                        Mastercard ou
                        Apple Pay</strong>
                </p>
            </div>
            <div class="box1">
                <h3>2 ans de <br>garantie</h3>
                <p><br>Nous réparons ou remplaçons votre produit pour tous problème couvert par la
                    garantie pendant les
                    deux années suivant la réception du produit</p>
            </div>
        </div>
    </section1>

    <section2>
        <div class="reveal fade-bottom">
            <h2>Notre communauté</h2>
            <h3>Rejoignez la communauté PetConnect</h3>

            <div class="grid reveal fade-bottom2">
                <div class="chien one"></div>
                <div class="chien two"></div>
                <div class="chien three"></div>
                <div class="chien four"></div>
                <div class="chien five"></div>
                <div class="chien six"></div>
            </div>
        </div>
    </section2>
</main>


<script src="../javaScript/fade-reveal.js"></script>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setTimeout(()=> {
        setMarginTopFooter('home-main-div', 'id', 'site-footer-main-div', 'id', 80)
    }, 10)
</script>



</body>

</html>