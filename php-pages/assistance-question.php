<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['assistance-question'];
?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/assistance-styles.css">
    <title>Assistance Question</title>
</head>
<body>



<div class="as-main-body-div text-font-500">

    <h1><?php echo $languageList['Ask a new question'] ?></h1>

    <div class="separation-line-1"></div>

    <div class="as-main-div">
        <label id="as-question-new-question-label" for="as-question-new-question-input" ><?php echo $languageList['Write your question here'] ?>:</label>
        <input id="as-question-new-question-input" name="as-question-new-question-input" type="text" placeholder="<?php echo $languageList['New question'] ?>...">
        <span id="as-question-success-span" class="as-question-result-span"><?php echo $languageList['Your question has been successfully sent and will be reviewed soon'] ?>.</span>
        <span id="as-question-fail-span" class="as-question-result-span"><?php echo $languageList['Your question could not be processed'] ?>.</span>
        <button id="as-question-new-question-button" type="button"><?php echo $languageList['Ask question'] ?></button>
    </div>


</div>



<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'as-main-body-div', 'class', 0)

    // setToWindowHeight('as-main-body-div', 'id', 0)
    setMarginTopFooter('as-main-body-div', 'class', 'site-footer-main-div', 'id', 0)
</script>

<script src="../javaScript/assistance-question-buttons.js"></script>

</body>
</html>

