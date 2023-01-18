<?php
session_start();
include '../php-processes/dbConnection.php';
onlyAdminPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['assistance-manage'];
//$javaScriptLanguageList = returnLanguageList()[returnLanguage()]['assistance-validate-buttons'];

?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/assistance-manage-styles.css">
    <title><?php echo $languageList['Manage Questions'] ?></title>
</head>
<body>

<script>
    let assistanceList = <?php echo json_encode(returnAssistanceList('', '', 'object')) ?>;
</script>

<div class="am-main-body-div text-font-500">

    <h1><?php echo $languageList['Answer Questions'] ?></h1>

    <div class="separation-line-1"></div>

    <div class="am-main-div">

        <div id="am-disapproved-question-div" class="am-question-div">
<!--            MESSAGES WILL BE DISPLAYED HERE-->
        </div>

        <div id="am-disapproved-control-div" class="am-control-div">
            <div class="am-title-div">
                <span><?php echo $languageList['Control Panel']?></span>
            </div>

            <div class="am-edit-div">
                <button id="am-disapproved-save-button" class="am-control-button am-control-button-1" type="button"><?php echo $languageList['Save Changes']?></button>
                <button id="am-disapproved-switch-button" class="am-control-button am-control-button-2" type="button"><?php echo $languageList['Approve Question']?></button>
                <button id="am-disapproved-delete-button" class="am-control-button am-control-button-3" type="button"><?php echo $languageList['Delete Selected Question']?></button>
            </div>

            <div class="am-title-div-2">
                <span><?php echo $languageList['Edit Question']?></span>
            </div>

            <div class="am-edit-div">
                <textarea id="am-disapproved-question-textarea" class="am-edit-textarea" cols="30" rows="10" maxlength="255"></textarea>
            </div>

            <div class="am-title-div-2">
                <span><?php echo $languageList['Answer to the question']?></span>
            </div>

            <div class="am-edit-div">
                <textarea id="am-disapproved-answer-textarea" class="am-edit-textarea" cols="30" rows="10" maxlength="255"></textarea>
            </div>

        </div>

    </div>

    <h1><?php echo $languageList['Manage Questions'] ?></h1>

    <div class="separation-line-1"></div>

    <div class="am-main-div">

        <div id="am-approved-question-div" class="am-question-div">
            <!--            MESSAGES WILL BE DISPLAYED HERE-->
        </div>

        <div id="am-approved-control-div" class="am-control-div">
            <div class="am-title-div">
                <span><?php echo $languageList['Control Panel']?></span>
            </div>

            <div class="am-edit-div">
                <button id="am-approved-save-button" class="am-control-button am-control-button-1" type="button"><?php echo $languageList['Save Changes']?></button>
                <button id="am-approved-switch-button" class="am-control-button am-control-button-2" type="button"><?php echo $languageList['Disapprove Question']?></button>
                <button id="am-approved-delete-button" class="am-control-button am-control-button-3" type="button"><?php echo $languageList['Delete Selected Question']?></button>
            </div>

            <div class="am-title-div-2">
                <span><?php echo $languageList['Edit Question']?></span>
            </div>

            <div class="am-edit-div">
                <textarea id="am-approved-question-textarea" class="am-edit-textarea" cols="30" rows="10" maxlength="255"></textarea>
            </div>

            <div class="am-title-div-2">
                <span><?php echo $languageList['Answer to the question']?></span>
            </div>

            <div class="am-edit-div">
                <textarea id="am-approved-answer-textarea" class="am-edit-textarea" cols="30" rows="10" maxlength="255"></textarea>
            </div>

        </div>

    </div>

</div>

<?php include '../php-pages/site-footer.php' ?>

<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'am-main-body-div', 'class', 10)
    setMarginTopFooter('am-main-body-div', 'class', 'site-footer-main-div', 'id', 0)
</script>

<script src="../javaScript/assistance-manage-buttons.js"></script>

</body>
</html>
