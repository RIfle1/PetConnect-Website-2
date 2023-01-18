<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['legal-notice'];

?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/legal-styles.css">
    <title><?php echo $languageList['Legal Notices'] ?></title>
</head>
<body>


<div class="lg-main-body-div text-font-500">

    <h1><?php echo $languageList['Legal Notices'] ?></h1>

    <div class="separation-line-1"></div>

    <div class="lg-main-div">
        <div class="lg-info-div">
            <h3><?php echo $languageList['Site published by PetConnect®'] ?></h3>

            <span><?php echo $languageList['SA with a capital of 420 euros'] ?></span>
            <span>RCS Paris 356,000,000</span>
            <span><?php echo $languageList['Head office'] ?>: 69 RUE DE JOHNNY S. – 420 PARIS</span>
            <span><?php echo $languageList['Intra-community VAT no.'] ?>: FR 420690000420</span>
            <span><?php echo $languageList['Chairmen'] ?>: G4D</span>
        </div>

        <div class="lg-staff-div">
            <div class="lg-staff-info-div">
                <h3><?php echo $languageList['Back end programming manager'] ?></h3>
                <span>Filips Barakats</span>
            </div>

            <div class="lg-staff-info-div">
                <h3><?php echo $languageList['Front end programming manager'] ?></h3>
                <span>Thibaud Barberon</span>
            </div>

            <div class="lg-staff-info-div">
                <h3><?php echo $languageList['Design manager'] ?></h3>
                <span>Guillaume Cappe De Baillon</span>
            </div>

            <div class="lg-staff-info-div">
                <h3><?php echo $languageList['Publication manager'] ?></h3>
                <span>Alec Lemoine</span>
            </div>

            <div class="lg-staff-info-div">
                <h3><?php echo $languageList['Human Ressources manager'] ?></h3>
                <span>Thomas Cabellan</span>
            </div>

            <div class="lg-staff-info-div">
                <h3><?php echo $languageList['Data analyst'] ?></h3>
                <span>Jason Lim</span>
            </div>
        </div>

        <div class="lg-info-div">
            <h3><?php echo $languageList['Headquarters Location'] ?></h3>

            <span>PetConnect</span>
            <span>GHOST TOWN – 420 PARIS</span>
            <span><?php echo $languageList['Tel'] ?>: + 33 7 66 44 22 00</span>
            <span><?php echo $languageList['Fax'] ?>: + 33 7 99 22 44 00</span>
            <span>RCS Paris, 356 000 000</span>
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
