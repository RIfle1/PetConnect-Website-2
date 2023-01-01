<?php

$languageList = returnLanguageList()[returnLanguage()]['site-footer'];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/site-footer-styles.css">
    <title>Site-footer</title>
</head>
<body>
<div id="site-footer-main-div">
    <div class="site-footer-top-div">
        <div id="site-footer-first-colum" class="text-font-200">
            <a href="#"><?php echo $languageList["GIFT CARDS"]?></a>
            <a href="#"><?php echo $languageList["FIND A STORE"]?></a>
            <a href="#"><?php echo $languageList["PetConnect Journal"]?></a>
            <a href="#"><?php echo $languageList["BECOME A MEMBER"]?></a>
            <a href="#"><?php echo $languageList["STUDENT DISCOUNT"]?></a>
            <a href="#"><?php echo $languageList["COMMENTS"]?></a>
            <a href="#"><?php echo $languageList["PROMO CODES"]?></a>
        </div>
        <div id="site-footer-second-colum" class="text-font-200">
            <p><?php echo $languageList["HELP"]?></p>
            <a href="#"><?php echo $languageList["Order Status"]?></a>
            <a href="#"><?php echo $languageList["Shipping and deliveries"]?></a>
            <a href="#"><?php echo $languageList["Returns"]?></a>
            <a href="#"><?php echo $languageList["Payment methods"]?></a>
            <a href="#"><?php echo $languageList["Contact us"]?></a>
            <a href="#"><?php echo $languageList["Help - Promo codes"]?></a>
        </div>
        <div id="site-footer-third-colum" class="text-font-200">
            <p><?php echo $languageList["ABOUT US"]?></p>
            <a href="#"><?php echo $languageList["News"]?></a>
            <a href="#"><?php echo $languageList["Careers"]?></a>
            <a href="#"><?php echo $languageList["Investors"]?></a>
            <a href="#"><?php echo $languageList["Sustainable development"]?></a>
            <a href="#"><?php echo $languageList["Mobile app"]?></a>
            <a href="#"><?php echo $languageList["Informative quiz"]?></a>
        </div>
        <div id="site-footer-fourth-column">
            <div class="site-footer-img-div-1">
                <a href="#"><img src="<?php echo getImage('twitter.png')?>" alt="Twitter logo"></a>
                <a href="#"><img src="<?php echo getImage('facebook.png')?>" alt="Facebook logo"></a>
                <a href="#"><img src="<?php echo getImage('instagram.png')?>" alt="Instagram logo"></a>
            </div>
            <div class="site-footer-img-div-2">
                <a href="#"><img src="<?php echo getImage('petconnect_logo_transparent.png')?>" alt="PetConnect Logo"></a>
            </div>
        </div>
    </div>
    <div id="site-footer-bottom-div" class="text-font-200">
        <div id="site-footer-first-row">
            <a href="#"><?php echo $languageList["Guides"]?></a>
            <a href="#"><?php echo $languageList["Terms of Use"]?></a>
            <a href="#"><?php echo $languageList["General conditions of sale"]?></a>
            <a href="#"><?php echo $languageList["Legal notices"]?></a>
        </div>
        <div id="site-footer-second-row">
            <div id="site-footer-second-row-1">
                <p><?php echo $languageList["Paris, France"]?></p>
                <p><?php echo $languageList["© 2022 PetConnect, Inc. All rights reserved"]?></p>
            </div>
            <div id="site-footer-second-row-2">
                <a href="#"><?php echo $languageList["Privacy and Cookies Policy"]?></a>
                <a href="#"><?php echo $languageList["Cookie settings"]?></a>
            </div>
        </div>
    </div>
    <div>

    </div>
</div>


</body>

</html>
