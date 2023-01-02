<?php
include_once "../php-processes/dbConnection.php";

$languageList = returnLanguageList()[returnLanguage()]['site-footer'];

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/common-styles.css">
    <link rel="stylesheet" href="../css/site-footer-style-2.css">
    <title>Site-footer</title>
</head>

<body>
    <footer class="text-font-300">
        <div class="gridfooter">
            <div class="column">
                <div class="maj size">
                    <a href="">trouver un magasin</a><br>
                    <a href="">Petconnect journal</a><br>
                    <a href="">devenir membre</a><br>
                    <a href="">Retours</a><br>
                    <a href="">Espace administrateur</a><br>
                    <a href="">commentaires</a><br>
                    <a href="">code promo</a><br>
                </div>
            </div>

            <div class="column">
                <div class="maj">
                    <a href="">Aide</a><br>
                </div>
                <a href="">Statut de commande</a><br>
                <a href="">Expédition et livraison</a><br>
                <a href="">Retours</a><br>
                <a href="">Mode de paiement</a><br>
                <a href="">Nous contacter</a><br>
            </div>
            <div class="column">
                <div class="maj">
                    <a href="">à propos de petconnect</a><br>
                </div>
                <a href="">Actualités</a><br>
                <a href="quiz.php">Quiz</a><br>
                <a href="">Investisseurs</a><br>
                <a href="">Développement durable</a><br>
                <a href="">Apllication mobile</a><br>
            </div>
        </div>
        <div id="bas">
            <p>
            <div id="white">Paris, France</div>Copyright ⓒ 2022 PetConnect - Tous droits réservés.</p>
        </div>
        <img src="<?php echo getImage("PetConnect-Logo.png") ?>"  alt="logo"/>
    </footer>
</body>

</html>