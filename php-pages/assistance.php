<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['assistance'];

?>
<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/assistance-styles.css">
    <title><?php echo $languageList['Assistance'] ?></title>
</head>

<body>

    <script>
        let assistanceList = <?php echo json_encode(returnAssistanceList('', 1, 'list')) ?>;
    </script>

    <div class="as-main-body-div text-font-500">

        <h1><?php echo $languageList['Assistance'] ?></h1>
        <h2 class="as-assistance-h2-sub"><?php echo $languageList['Need help?'] ?></h2>

        <div class="separation-line-1"></div>

        <div class="as-main-div">
            <input id="as-assistance-question-input" type="text" placeholder="<?php echo $languageList['Find the answer to all of your questions'] ?>">

            <span id="as-assistance-question-help-span">
                <?php echo $languageList["Can't find your question?"] ?>
                <?php echo $languageList["Click"] ?>
                <a href="../php-pages/assistance-question.php"><?php echo $languageList["here"] ?></a>
                <?php echo $languageList["to ask a new question"] ?>
            </span>

            <div class="separation-line-small"></div>

            <h2 class="as-assistance-h2-main"><?php echo $languageList['Frequent Questions'] ?></h2>

            <div id="as-assistance-question-div">
                <!--            QUESTIONS WILL BE DISPLAYED HERE-->
                <span id="as-assistance-no-question-span"><?php echo $languageList['No questions have been found.'] ?></span>
            </div>

        </div>

    </div>

    <?php include '../php-pages/site-footer.php' ?>
    <script type="text/javascript">
        setMarginTop('sih-main-header', 'id', 'as-main-body-div', 'class', 0)

        // setToWindowHeight('as-main-body-div', 'id', 0)
        setMarginTopFooter('as-main-body-div', 'class', 'site-footer-main-div', 'id', 0)
    </script>

    <script src="../javaScript/assistance-buttons.js"></script>

</body>

</html>