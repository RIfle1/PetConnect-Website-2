<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['home'];



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/home-styles.css">
    <title>PetConnect</title>
</head>

<body>

    <main>

        <slogan>
            <div class="fondimage">
                <h1>
                    <img src="<?php echo getImage("iCollar_logo.png") ?>" />
                </h1>
            </div>
            <h2>
            <?php echo $languageList["Technology for your animals"]?> 
            </h2>
        </slogan>

        <section1>
            <div class="grid reveal fade-bottom">
                <div class="carre black reveal fade-bottom2">
                    <p id="pink" class="reveal fade-bottom3"><?php echo $languageList["new"]?> </p>
                    <img class="reveal fade-bottom3" src="<?php echo getImage("iCollar_blanc2.png") ?>" />
                    <h3 id="iCollar">iCollar</h3>
                    <p id="grey"><?php echo $languageList["The connected dog collar"]?> </p>
                    <div>
                        <a href="boutique.php" class="espace"><?php echo $languageList["See more"]?>  &gt;</a>

                        <a href="basket.php"><?php echo $languageList["Buy"]?>  +</a>
                    </div>
                </div>
                <div class="box1">
                    <h3><?php echo $languageList["Free"]?> <br><?php echo $languageList["delivery"]?></h3>
                    <p><br><?php echo $languageList["Free delivery in Metropolitan France"]?></p>
                </div>
                <div class="box2 black">
                    <h3><?php echo $languageList["7-day trial"]?></h3>
                    <p><br><?php echo $languageList["We accept returns within 7 days of delivery"]?></p>
                </div>
                <div class="box2 black">
                    <h3><?php echo $languageList["Secure payments"]?></h3>
                    <p><br><?php echo $languageList["100% encrypted payments"]?><br>
                        <br><?php echo $languageList["Accepted payment methods: Paypal, Visa, Mastercard or Apple Pay"]?>
                    </p>
                </div>
                <div class="box1">
                    <h3><?php echo $languageList["2 year warranty"]?></h3>
                    <p><br><?php echo $languageList["We will repair or replace your product for any issues covered by the warranty for the two years following the receipt of the product"]?></p>
                </div>
            </div>
        </section1>

        <section2>
            <div class="reveal fade-bottom">
                <h2><?php echo $languageList["Our community"]?></h2>
                <h3><?php echo $languageList["Join the PetConnect community"]?></h3>

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
        <script src="../javaScript/fade-reveal.js"></script>
        </div>
        <?php include 'site-footer.php' ?>
</body>

</html>