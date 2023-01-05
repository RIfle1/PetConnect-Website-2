<?php
session_start();
include '../php-processes/dbConnection.php';
clientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['shop'];

?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../css/shop-styles.css">

    <title>SHOP</title>
</head>

<body>
    <main>
        <div id="sh-form-body" class="text-font">
            <section id="shop">
                <h1><?php echo $languageList["Connected dog collar"] ?></h1>
                <h2>iCollar - (<?php echo $languageList["Color"] ?>)</h2>
                <h3>499€</h3>


                <div class="mainbox">
                    <img id="chose-color" src="<?php echo  getImage("Collier_blanc.png") ?>" />
                </div>

                <div class="grid2">

                    <button class="box" name="white" onclick="white()">
                        <figure role="figure">
                            <figcaption><?php echo $languageList["White"] ?><br><span><?php echo $languageList["In stock"] ?></span></figcaption>
                            <img src="<?php echo getImage("Collier_blanc.png") ?>" />
                        </figure>
                    </button>
                    <button class="box" name="pink" onclick="pink()">
                        <figure role="figure">
                            <figcaption><?php echo $languageList["Pink"] ?><br><span><?php echo $languageList["In stock"] ?></span></figcaption>
                            <img src="<?php echo getImage("Collier_Rose.png") ?>" />
                        </figure>
                    </button>
                    <button class="box" name="blue" onclick="blue()">
                        <figure role="figure">
                            <figcaption><?php echo $languageList["Blue"] ?><br><span><?php echo $languageList["In stock"] ?></span></figcaption>
                            <img src="<?php echo getImage("Collier_bleu.png") ?>" />
                        </figure>
                    </button>
                    <form action="../php-processes/shop-process.php" method="POST">
                        <div>
                            <button type="submit" id="basket" name="addBasket" value="white"><?php echo $languageList["Add to cart"] ?></button>
                        </div>
                    </form>
                    <button class="box" name="black" onclick="black()">
                        <figure role="figure">
                            <figcaption><?php echo $languageList["Black"] ?><br><span><?php echo $languageList["In stock"] ?></span></figcaption>
                            <img src="<?php echo getImage("Collier_noir.png") ?>" />
                        </figure>
                    </button>
                    <button class="box" name="green" onclick="green()">
                        <figure role="figure">
                            <figcaption><?php echo $languageList["Green"] ?><br><span><?php echo $languageList["In stock"] ?></span></figcaption>
                            <img src="<?php echo getImage("Collier_vert.png") ?>" />
                        </figure>
                    </button>
                    <button class="box" name="yellow" onclick="yellow()">
                        <figure role="figure">
                            <figcaption><?php echo $languageList["Yellow"] ?><br><span><?php echo $languageList["In stock"] ?></span></figcaption>
                            <img src="<?php echo getImage("Collier_jaune.png") ?>" />
                        </figure>
                    </button>
                    <div>
                        <button type=" submit" id="buy" name="buy"><?php echo $languageList["Buy now"] ?></button>
                    </div>
                    <p id="deo"></p>
                </div>

                <ul>
                    <li><?php echo $languageList["GPS localisation"] ?></li>
                    <li><?php echo $languageList["Heart rate sensor"] ?></li>
                    <li><?php echo $languageList["Thermal sensor"] ?></li>
                    <li><?php echo $languageList["Sound sensor"] ?></li>
                    <li><?php echo $languageList["CO2 concentration"] ?></li>
                </ul>



            </section>
        </div>
    </main>
    <?php include 'site-footer.php' ?>
    <script type="text/javascript">
        setMarginTop('site-header-main-header', 'id', 'sh-form-body', 'id', 40)
    </script>

    <script>
        function yellow() {
            document.getElementById("chose-color").src = "../img/products/Collier_jaune.png";
            document.getElementById("basket").value = "yellow";
        }

        function white() {
            document.getElementById("chose-color").src = "../img/products/Collier_blanc.png";
            document.getElementById("basket").value = "white";
        }

        function green() {
            document.getElementById("chose-color").src = "../img/products/Collier_vert.png";
            document.getElementById("basket").value = "green";
        }


        function pink() {
            document.getElementById("chose-color").src = "../img/products/Collier_Rose.png";
            document.getElementById("basket").value = "pink";
        }

        function black() {
            document.getElementById("chose-color").src = "../img/products/Collier_noir.png";
            document.getElementById("basket").value = "black";
        }

        function blue() {
            document.getElementById("chose-color").src = "../img/products/Collier_bleu.png";
            document.getElementById("basket").value = "blue";
        }
    </script>




</body>

</html>