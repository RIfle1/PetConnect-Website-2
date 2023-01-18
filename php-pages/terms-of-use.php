<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['terms-of-use'];

?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/legal-styles.css">
    <title><?php echo $languageList['Terms of use'] ?></title>
</head>
<body>


<div class="lg-main-body-div text-font-500">

    <h1><?php echo $languageList['Terms of use'] ?></h1>

    <div class="separation-line-1"></div>

    <div class="lg-main-div">
        <div class="lg-info-div">
            <p><?php echo $languageList["Welcome to the PetConnect website (the 'Site'). The Site is operated by PetConnect, LLC ('PetConnect,' 'we,' or 'us'). These Terms of Use (these 'Terms') govern your access to and use of the Site, including any content, functionality, and services offered on or through the Site."] ?></p>
            <p><?php echo $languageList["By accessing or using the Site, you are accepting these Terms and agreeing to be bound by them. If you do not agree to these Terms, you must not access or use the Site."]?></p>
        </div>

        <div class="lg-info-div">
            <h3><?php echo $languageList["Use of the Site"] ?></h3>
            <p><?php echo $languageList["You may use the Site only for lawful purposes and in accordance with these Terms. You may not use the Site"] ?>:</p>
            <span><?php echo $languageList["In any way that violates any applicable federal, state, local, or international law or regulation."] ?></span>
            <span><?php echo $languageList["For the purpose of exploiting, harming, or attempting to exploit or harm minors in any way by exposing them to inappropriate content, asking for personally identifiable information, or otherwise."] ?></span>
            <span><?php echo $languageList["To transmit, or procure the sending of, any advertising or promotional material, including any 'junk mail,' 'chain letter,' 'spam,' or any other similar solicitation."] ?></span>
            <span><?php echo $languageList["To impersonate or attempt to impersonate PetConnect, a PetConnect employee, another user, or any other person or entity."] ?></span>
            <span><?php echo $languageList["To engage in any other conduct that restricts or inhibits anyone's use or enjoyment of the Site, or which, as determined by PetConnect, may harm PetConnect or users of the Site or expose them to liability."] ?></span>
        </div>

        <div class="lg-info-div">
            <h3><?php echo $languageList["Product Sales"] ?></h3>
            <p><?php echo $languageList["The Site may offer for sale certain smart collars for dogs ('Products'). By placing an order for a Product, you are offering to purchase the Product on and subject to these Terms. All orders are subject to availability and confirmation of the order price."] ?></p>
        </div>

        <div class="lg-info-div">
            <h3><?php echo $languageList["Warranty Disclaimer"] ?></h3>
            <p><?php echo $languageList["The Site, including all content, functionality, and services offered on or through the Site, are provided 'as is,' 'as available,' and 'with all faults.' PetConnect makes no representations or warranties of any kind, express or implied, as to the operation of the Site or the information, content, materials, or products included on the Site."] ?></p>
        </div>

        <div class="lg-info-div">
            <h3><?php echo $languageList["Limitation of Liability"] ?></h3>
            <p><?php echo $languageList["In no event shall PetConnect, its directors, officers, employees, agents, partners, or suppliers be liable for any damages whatsoever, including without limitation, direct, indirect, special, incidental, or consequential damages, arising out of or in connection with the use, inability to use, or performance of the Site or the products offered on the Site."] ?></p>
        </div>

        <div class="lg-info-div">
            <h3><?php echo $languageList["Changes to These Terms"] ?></h3>
            <p><?php echo $languageList["PetConnect reserves the right to make changes to these Terms at any time. Your continued use of the Site following the posting of any changes to these Terms will mean you accept those changes."] ?></p>
        </div>

        <div class="lg-info-div">
            <h3><?php echo $languageList["Contact Us"] ?></h3>
            <p><?php echo $languageList["If you have any questions about these Terms, please contact us at petconnecttech@gmail.com."] ?></p>
        </div>

    </div>

</div>



<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'lg-main-body-div', 'class', 0)

    // setToWindowHeight('as-main-body-div', 'id', 0)
    setMarginTopFooter('lg-main-body-div', 'class', 'site-footer-main-div', 'id', 0)
</script>

<script src="../javaScript/assistance-buttons.js"></script>

</body>
</html>
