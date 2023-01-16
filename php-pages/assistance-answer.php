<?php
session_start();
include '../php-processes/dbConnection.php';
if (empty($_GET['astID'])) {
    header('Location: ../php-pages/restricted-access.php');
}
include 'site-header.php';

$astID = $_GET['astID'];
//$astID = 'ast1';
$languageList = returnLanguageList()[returnLanguage()]['assistance-answer'];

$assistanceItem = returnAssistanceList($astID, 1, 'list');
?>

<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/assistance-styles.css">
    <title>Assistance Answer</title>
</head>

<body>



    <div class="as-main-body-div text-font-500">

        <h1><?php echo $languageList['Assistance Answer'] ?></h1>

        <div class="separation-line-1"></div>
        <div class="fondgris">
            <div class="as-main-div">

                <h1 class="as-answer-question-span"><?php echo $assistanceItem['astQuestion'] ?></h1>
                <h2 class="as-answer-answer-span"><?php echo $assistanceItem['astAnswer'] ?></h2>

            </div>
        </div>

    </div>



    <?php include '../php-pages/site-footer.php' ?>
    <script type="text/javascript">
        setMarginTop('sih-main-header', 'id', 'as-main-body-div', 'class', 0)

        // setToWindowHeight('as-main-body-div', 'id', 0)
        setMarginTopFooter('as-main-body-div', 'class', 'site-footer-main-div', 'id', 0)
    </script>


</body>

</html>