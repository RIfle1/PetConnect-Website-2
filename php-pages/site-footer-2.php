<?php

$languageList = returnLanguageList()[returnLanguage()]['site-footer'];

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/site-footer-style.css">
    <title>Site-footer</title>
</head>

<body>
    <footer>
        <div class="gridfooter">
            <div class="column">
                <div class="maj size">
                    <a href=""><?php echo $languageList["FIND A STORE"] ?></a><br>
                    <a href=""><?php echo $languageList["PetConnect Journal"] ?></a><br>
                    <a href=""><?php echo $languageList["BECOME A MEMBER"] ?></a><br>
                    <a href=""><?php echo $languageList["GIFT CARDS"] ?></a><br>
                    <a href=""><?php echo $languageList["PROMO CODES"] ?></a><br>
                    <a href=""><?php echo $languageList["STUDENT DISCOUNT"] ?></a><br>
                    <a href=""><?php echo $languageList["COMMENTS"] ?></a><br>

                </div>
            </div>

            <div class="column">
                <div class="maj">
                    <a href=""><?php echo $languageList["HELP"] ?></a><br>
                </div>
                <a href=""><?php echo $languageList["Order Status"] ?></a><br>
                <a href=""><?php echo $languageList["Shipping and deliveries"] ?></a><br>
                <a href=""><?php echo $languageList["Returns"] ?></a><br>
                <a href=""><?php echo $languageList["Payment methods"] ?></a><br>
                <a href=""><?php echo $languageList["Contact us"] ?></a><br>
            </div>
            <div class="column">
                <div class="maj">
                    <a href=""><?php echo $languageList["ABOUT US"] ?></a><br>
                </div>
                <a href=""><?php echo $languageList["News"] ?></a><br>
                <a href="quiz.php">Quiz</a><br>
                <a href=""><?php echo $languageList["Investors"] ?></a><br>
                <a href=""><?php echo $languageList["Sustainable development"] ?></a><br>
                <a href=""><?php echo $languageList["Mobile app"] ?></a><br>
            </div>
        </div>
        <div id="bas">
            <p>
            <div id="white">Paris, France</div><?php echo $languageList["Copyright ⓒ 2022 PetConnect - All rights reserved."] ?></p>
        </div>
        <img src="<?php echo getImage("PetConnect-Logo.png") ?>" />
    </footer>
</body>

</html>