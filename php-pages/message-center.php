<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];
$clientInfo = "";
$adminInfo = "";

clientPage();
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
    <link rel="stylesheet" href="../css/message-styles.css">

<!--    <script src="https://code.jquery.com/jquery-3.6.1.min.js"-->
<!--            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="-->
<!--            crossorigin="anonymous">-->
<!--    </script>-->

    <script src="../javaScript/css-functions.js"></script>

    <title>MESSAGE</title>
</head>
<body>

<div id="mc-main-div" class="text-font-700">

    <div id="mc-header-1-div">
        <h1>Centre de Messagerie</h1>
    </div>

    <div class="mc-separation-line"></div>

<!--    ACTIVE MESSAGES TABLE-->

    <div class="mc-table-main-class">
        <div class="mc-main-div" id="mc-message-main-div">
            <div class="mc-row-div" id="mc-message-row-div">
                <?php if ($adminLoggedIn): ?>
                    <div class="mc-left-side-menu" id="mc-message-active-div">
                        <div class='mc-title-div' id="mc-message-title-div">
                            <span>Active Messages</span>
                        </div>
                        <div class='mc-user-div' id="mc-message-user-div"></div>
                    </div>
                <?php endif; ?>
                <div class="mc-text-div" id="mc-message-text-div">
                </div>
            </div>
            <div id="mc-message-input-div">
                <label for="mc-input-message"></label>
                <input type="text" id="mc-input-message" name="mc-input-message" placeholder="Type a message...">
            </div>
        </div>

        <?php if ($adminLoggedIn): ?>
            <!--    ACTIVE MESSAGES BUTTONS-->
            <div class="mc-admin-buttons-div">
                <div class='mc-title-div'><span>Control Panel</span></div>
                <button type="button" class="mc-button-1" name="mc-admin-show-active-button" id="mc-admin-show-message-button">Hide Active Messages</button>
                <button type="button" class="mc-button-2" name="mc-admin-mark-resolved-button" id="mc-admin-mark-resolved-button">Mark as resolved</button>
                <button type="button" class="mc-button-3" name="mc-admin-delete-conversation-button" id="mc-admin-delete-message-button">Delete Conversation</button>
            </div>
        <?php endif; ?>
    </div>





    <?php if($adminLoggedIn):?>
        <div class="mc-separation-line"></div>

        <div id="mc-header-1-div">
            <h1>Resolved Messages</h1>
        </div>

        <div class="mc-separation-line"></div>

        <div class="mc-table-main-class">
            <!--RESOLVED MESSAGES TABLE-->
            <div class="mc-main-div" id="mc-resolved-main-div">

                <div class="mc-row-div" id="mc-resolved-row-div">

                    <div class="mc-left-side-menu" id="mc-resolved-active-div">
                        <div class='mc-title-div' id="mc-resolved-title-div">
                            <span>Resolved Messages</span>
                        </div>
                        <div class='mc-user-div' id="mc-resolved-user-div"></div>
                    </div>

                    <div class="mc-text-div" id="mc-resolved-text-div">

                    </div>
                </div>

            </div>
            <!--    RESOLVED MESSAGES BUTTONS-->
            <div class="mc-admin-buttons-div">
                <div class='mc-title-div'><span>Control panel</span></div>
                <button type="button" class="mc-button-1" name="mc-admin-show-resolved-button" id="mc-admin-show-resolved-button">Hide Resolved Messages</button>
                <button type="button" class="mc-button-3" name="mc-admin-delete-conversation-button" id="mc-admin-delete-resolved-button">Delete Conversation</button>
                <div class="mc-separation-title-div"><span>Manage Resolved Messages</span></div>
                <div class="mc-select-div">
                    <label for="mc-admin-select-interval">Delete all resolved messages</label>
                    <select name="mc-admin-select-interval" id="mc-admin-select-interval">
                        <option value="before">Before</option>
                        <option value="after">After</option>
                        <option value="between">Between</option>
                    </select>
                </div>
                <div id="mc-admin-input-div">
                    <label class="mc-admin-input-label" for="mc-admin-input-date-start">Select Start Date: </label>
                    <input class="mc-admin-input-date" id="mc-admin-input-date-start" type="date" placeholder="Select a date...">
                    <label class="mc-admin-input-label" for="mc-admin-input-date-end">Select End Date: </label>
                    <input class="mc-admin-input-date" id="mc-admin-input-date-end" type="date" placeholder="Select a date...">
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>


<?php include "site-footer.php";?>

<script type="text/javascript">
    setMarginTop('.site-header-main-header', 'mc-main-div', 40)
    window.addEventListener("resize", function() {
        setMarginTop('.site-header-main-header', 'mc-main-div', 40)
    })
</script>

<script src="../javaScript/message-center-buttons.js"></script>

<?php if ($clientLoggedIn): ?>
    <script type="text/javascript">
        displaySessionMessages('<?php echo $_SESSION['cltID']?>', 'mc-message-text-div', "mc-current-user-message-div", "mc-foreign-user-message-div");
    </script>
<?php endif; ?>

<?php if($adminLoggedIn): ?>
    <script>
        updateAdminTextDiv();
        displayActives('message');
        displayActives('resolved');
    </script>
<?php endif; ?>

</body>
</html>
