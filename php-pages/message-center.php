<?php
session_start();
include '../php-processes/dbConnection.php';
clientAndAdminPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['message-center'];
$javaScriptLanguageList = returnLanguageList()[returnLanguage()]['message-center-buttons'];
?>
<!doctype html>
<html lang="en">
<head>

    <link rel="stylesheet" href="../css/message-styles.css">

    <title>Message Center</title>
</head>
<body>

<script>
    let javaScriptLanguageList = <?php echo json_encode($javaScriptLanguageList) ?>;
    let getMessagesMessage = <?php echo json_encode(returnLastMessagesList('message')) ?>;
    let getMessagesResolved = <?php echo json_encode(returnLastMessagesList('resolved')) ?>;
</script>

<div id="mc-main-body-div" class="text-font-700">

    <div>
        <h1><?php echo $languageList["Active Messages"]?></h1>
    </div>

    <div class="separation-line-2"></div>

<!--    ACTIVE MESSAGES TABLE-->

    <div class="mc-table-main-class">
        <div class="mc-main-div" id="mc-message-main-div">
            <div class="mc-row-div" id="mc-message-row-div">
                <?php if(isset($adminLoggedIn)): ?>
                    <?php if ($adminLoggedIn): ?>
                        <div class="mc-left-side-menu" id="mc-message-active-div">
                            <div class='mc-title-div' id="mc-message-title-div">
                                <span><?php echo $languageList["Active Messages"]?></span>
                            </div>
                            <div class='mc-user-div' id="mc-message-user-div"></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="mc-text-div" id="mc-message-text-div">
                </div>
            </div>
            <div id="mc-message-input-div">
                <label for="mc-input-message"></label>
                <input type="text" id="mc-input-message" name="mc-input-message" placeholder="<?php echo $languageList['Type a message...']?>">
            </div>
        </div>
        <?php if(isset($adminLoggedIn)): ?>
            <?php if ($adminLoggedIn): ?>
                <!--    ACTIVE MESSAGES BUTTONS-->
                <div class="mc-admin-buttons-div">
                    <div class='mc-title-div'><span><?php echo $languageList["Control Panel"]?></span></div>
                    <button type="button" class="mc-button-1" name="Hide" id="mc-admin-show-message-button"><?php echo $languageList["Hide Active Messages"]?></button>
                    <button type="button" class="mc-button-2" id="mc-admin-mark-resolved-button"><?php echo $languageList["Mark As Resolved"]?></button>
                    <button type="button" class="mc-button-3" id="mc-admin-delete-message-button"><?php echo $languageList["Delete Current Conversation"]?></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php if(isset($adminLoggedIn)): ?>
        <?php if($adminLoggedIn):?>
            <div class="separation-line-2"></div>

            <div>
                <h1><?php echo $languageList["Resolved Messages"]?></h1>
            </div>

            <div class="separation-line-2"></div>

            <div class="mc-table-main-class">
                <!--RESOLVED MESSAGES TABLE-->
                <div class="mc-main-div" id="mc-resolved-main-div">

                    <div class="mc-row-div" id="mc-resolved-row-div">

                        <div class="mc-left-side-menu" id="mc-resolved-active-div">
                            <div class='mc-title-div' id="mc-resolved-title-div">
                                <span><?php echo $languageList["Resolved Messages"]?></span>
                            </div>
                            <div class='mc-user-div' id="mc-resolved-user-div"></div>
                        </div>

                        <div id="mc-resolved-text-div" class="mc-text-div">

                        </div>
                    </div>

                </div>
                <!--    RESOLVED MESSAGES BUTTONS-->
                <div class="mc-admin-buttons-div">
                    <div class='mc-title-div'><span><?php echo $languageList["Control Panel"]?></span></div>
                    <button type="button" class="mc-button-1" name="Hide" id="mc-admin-show-resolved-button"><?php echo $languageList["Hide Resolved Messages"]?></button>
                    <button type="button" class="mc-button-3"  id="mc-admin-delete-resolved-button"><?php echo $languageList["Delete Current Conversation"]?></button>
                    <div class="mc-separation-title-div"><span><?php echo $languageList["Manage Resolved Messages"]?></span></div>
                    <label class="mc-admin-input-label" for="mc-admin-select-date"><?php echo $languageList["Delete Resolved Messages By"]?></label>
                    <div class="mc-select-div">
                        <select name="mc-admin-select-date" id="mc-admin-select-date">
                            <option value="sesMsgStartDate"><?php echo $languageList["Resolved Start Date"]?></option>
                            <option value="sesMsgEndDate"><?php echo $languageList["Resolved End Date"]?></option>
                        </select>
                        <select name="mc-admin-select-interval" id="mc-admin-select-interval">
                            <option value="between"><?php echo $languageList["Between"]?></option>
                            <option value="before"><?php echo $languageList["Before"]?></option>
                            <option value="after"><?php echo $languageList["After"]?></option>
                        </select>
                        <label for="mc-admin-select-interval"></label>
                    </div>
                    <div id="mc-admin-input-div">
                        <label id="mc-admin-input-label-start" class="mc-admin-input-label" for="mc-admin-input-date-start"><?php echo $languageList["Select Start Date:"]?> </label>
                        <input class="mc-admin-input-date" id="mc-admin-input-date-start" type="datetime-local">
                        <label id="mc-admin-input-label-end" class="mc-admin-input-label" for="mc-admin-input-date-end"><?php echo $languageList["Select End Date:"]?> </label>
                        <input class="mc-admin-input-date" id="mc-admin-input-date-end" type="datetime-local">
                    </div>
                    <button type="button" class="mc-button-3" id="mc-admin-delete-interval-button"><?php echo $languageList["Delete Selected Messages"]?></button>
                    <span class="mc-admin-notification-1-span" id="mc-admin-delete-notification-span"></span>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>


<?php include '../php-pages/site-footer.php' ?>

<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'mc-main-body-div', 'id', 0)
    setMarginTopFooter('mc-main-body-div', 'id', 'site-footer-main-div', 'id', 0)
</script>

<script src="../javaScript/message-center-buttons.js"></script>

<?php if(isset($clientLoggedIn)): ?>
    <?php if ($clientLoggedIn): ?>
        <script type="text/javascript">
            displaySessionMessages('<?php echo $_SESSION['ID']?>', 'mc-message-text-div', "mc-current-user-message-div", "mc-foreign-user-message-div");
        </script>
    <?php endif; ?>
<?php endif; ?>

<?php if(isset($adminLoggedIn)): ?>
    <?php if($adminLoggedIn): ?>
        <script>
            updateAdminTextDiv();
            observerFunction(messageMainDivElement, messageTextDivElement, messageActiveDivElement);
            observerFunction(resolvedMainDivElement, resolvedTextDivElement, resolvedActiveDivElement);

            displayActives('message');
            displayActives('resolved');
        </script>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
