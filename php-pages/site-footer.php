<?php
include_once '../php-processes/dbConnection.php';

$languageList = returnLanguageList()[returnLanguage()]['site-footer'];

?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/common-styles.css">
    <link rel="stylesheet" href="../css/site-footer-styles.css">
</head>
<body>
<div id="site-footer-main-div" class="text-font-300">
    <div id="site-footer-top-div">
        <div id="site-footer-first-column" class="site-footer-column">
            <a href="#"><?php echo $languageList["GIFT CARDS"]?></a>
            <a href="#"><?php echo $languageList["FIND A STORE"]?></a>
            <a href="#"><?php echo $languageList["PetConnect Journal"]?></a>
            <a href="#"><?php echo $languageList["BECOME A MEMBER"]?></a>
            <a href="#"><?php echo $languageList["STUDENT DISCOUNT"]?></a>
            <a href="#"><?php echo $languageList["COMMENTS"]?></a>
            <a href="#"><?php echo $languageList["PROMO CODES"]?></a>
        </div>
        <div class="site-footer-column">
            <span><?php echo $languageList["HELP"]?></span>
            <a href="#"><?php echo $languageList["Order Status"]?></a>
            <a href="#"><?php echo $languageList["Shipping and deliveries"]?></a>
            <a href="#"><?php echo $languageList["Returns"]?></a>
            <a href="#"><?php echo $languageList["Payment methods"]?></a>
            <a href="#"><?php echo $languageList["Contact us"]?></a>
            <a href="#"><?php echo $languageList["Help - Promo codes"]?></a>
        </div>
        <div class="site-footer-column">
            <span><?php echo $languageList["ABOUT US"]?></span>
            <a href="#"><?php echo $languageList["News"]?></a>
            <a href="#"><?php echo $languageList["Careers"]?></a>
            <a href="#"><?php echo $languageList["Investors"]?></a>
            <a href="#"><?php echo $languageList["Sustainable development"]?></a>
            <a href="#"><?php echo $languageList["Mobile app"]?></a>
            <a href="quiz.php"><?php echo $languageList["Informative quiz"]?></a>
        </div>
        <div id="site-footer-last-column" class="site-footer-column">
            <div id="site-footer-img-div-1">
                <a href="#"><img src="<?php echo getImage('twitter.png')?>" alt="Twitter logo"></a>
                <a href="#"><img src="<?php echo getImage('facebook.png')?>" alt="Facebook logo"></a>
                <a href="#"><img src="<?php echo getImage('instagram.png')?>" alt="Instagram logo"></a>
            </div>
            <div id="site-footer-img-div-2">
                <a href="#"><img src="<?php echo getImage('PetConnect-Logo.png')?>" alt="PetConnect Logo"></a>
            </div>
        </div>
    </div>
    <div id="site-footer-bottom-div">
        <div id="site-footer-row-1" class="site-footer-row">
            <a href="#"><?php echo $languageList["Guides"]?></a>
            <a href="terms-of-use.php"><?php echo $languageList["Terms of Use"]?></a>
<!--            <a href="#">--><?php //echo $languageList["General conditions of sale"]?><!--</a>-->
            <a href="legal-notices.php"><?php echo $languageList["Legal notices"]?></a>
        </div>
        <div id="site-footer-row-2" class="site-footer-row">
            <div class="columns" id="column-1">
                <span><?php echo $languageList["Paris, France"]?></span>
                <span><?php echo $languageList["© 2022 PetConnect, Inc. All rights reserved"]?></span>
            </div>
            <div class="columns" id="column-2">
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
