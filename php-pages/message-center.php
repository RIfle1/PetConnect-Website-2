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

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous">
    </script>

    <script src="../javaScript/css-functions.js"></script>
    <script src="../javaScript/message-center-buttons.js"></script>

    <title>MESSAGE</title>
</head>
<body>

<div id="mc-main-div" class="text-font-700">

    <div id="mc-header-1-div">
        <h1>Centre de Messagerie</h1>
    </div>

    <div class="mc-separation-line"></div>
    <div id="mc-message-main-div">
        <div id="mc-message-row-div">
            <?php if($adminLoggedIn):?>
                <div id="mc-message-active-div">
                    <div id="mc-message-title-div">
                        <span>Active Messages</span>
                    </div>
                    <div id="mc-message-user-div">
                        <script>
                            displayActiveMessages();
                        </script>
                    </div>
                </div>
            <?php endif; ?>
            <div id="mc-message-exchange-div">
                <div id="mc-message-text-div">
                    <?php if($clientLoggedIn): ?>
                        <script type="text/javascript">
                            displaySessionMessages('')
                        </script>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div id="mc-message-input-div">
            <label for="mc-input-message"></label>
            <input type="text" id="mc-input-message" name="mc-input-message" placeholder="Type a message...">
        </div>
    </div>
    <?php if($adminLoggedIn):?>
        <div id="mc-admin-buttons-div">
            <button type="button" name="mc-admin-show-active-button" id="mc-admin-show-active-button">Hide Active Messages</button>
            <button type="button" name="mc-admin-mark-resolved-button" id="mc-admin-mark-resolved-button">Mark as resolved</button>
            <button type="button" name="mc-admin-delete-conversation-button" id="mc-admin-delete-conversation-button">Delete Conversation</button>
        </div>
    <?php endif; ?>
</div>


<?php include "site-footer.php";?>

<script type="text/javascript">
    setMarginTop('.site-header-main-header', 'mc-main-div', 40)
    window.addEventListener("resize", function(event) {
        setMarginTop('.site-header-main-header', 'mc-main-div', 40)
    })
</script>

<?php if($adminLoggedIn): ?>
    <script>adminMessageExchangeDiv();</script>
<?php endif; ?>
<script src="../javaScript/message-center-buttons.js"></script>
</body>
</html>
