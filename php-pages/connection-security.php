<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];
$entityInfo = returnEntityInfo();
$entityAttributes = returnEntityAttributes();

$IDLetters = '';
if($clientLoggedIn) {
    $IDLetters = 'clt';
}
elseif($adminLoggedIn) {
    $IDLetters = 'adm';
}

clientPage();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--    Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <!--    Style Sheet-->
    <link rel="stylesheet" href="../css/edit-styles.css">
    <!--    Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous">
    </script>
    <!--    Just Validate-->
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <!--    Css Function-->
    <script src="../javaScript/css-functions.js" defer></script>
    <script src="../javaScript/connection-security-buttons.js"></script>

    <title>PetConnect Connection and Security</title>
</head>
<body>

<div id="cs-form-body" class="text-font-500">
    <div id="cs-form-body-div">
        <div class="cs-form-elem"><h1>Connection and Security</h1></div>
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span id="cs-form-title-span-<?php echo $IDLetters ?>Username">Username :</span>
                <span id="<?php echo $IDLetters ?>Username"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes[1]];} ?></span>
            </div>
            <div class="cs-form-elem-button">
                <button type="button" value="<?php echo $IDLetters ?>Username" class="edit-button" id="edit-username-button">Edit</button>
            </div>
        </div>
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span id="cs-form-title-span-<?php echo $IDLetters ?>FirstName">First Name :</span>
                <span id="<?php echo $IDLetters ?>FirstName"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes[2]];} ?></span>
            </div>
            <div class="cs-form-elem-button">
                <button type="button" value="<?php echo $IDLetters ?>FirstName" class="edit-button" id="edit-firstName-button">Edit</button>
            </div>
        </div>
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span id="cs-form-title-span-<?php echo $IDLetters ?>LastName">Last Name :</span>
                <span id="<?php echo $IDLetters ?>LastName"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes[3]];} ?></span>
            </div>
            <div class="cs-form-elem-button">
                <button type="button" value="<?php echo $IDLetters ?>LastName" class="edit-button" id="edit-lastName-button">Edit</button>
            </div>
        </div>
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span id="cs-form-title-span-<?php echo $IDLetters ?>Email">Email :</span>
                <span id="<?php echo $IDLetters ?>Email"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes[4]];} ?></span>
                <span class="cs-form-email-temporary-element" id="cs-form-email-temporary"></span>
                <span class="cs-form-email-temporary-element">A verification code has been sent to your new email address.</span>
                <span class="cs-form-email-temporary-element">Input the confirmation code :</span>
                <input class="cs-form-email-temporary-element" type='password' id="cs-form-input-Email-verificationCode">
            </div>
            <div class="cs-form-elem-button">
                <button type="button" value="<?php echo $IDLetters ?>Email" class="edit-button" id="edit-email-button">Edit</button>
                <button type="button" value="<?php echo $IDLetters ?>Email" class="cs-form-email-temporary-element" id="edit-confirm-email-button">Confirm Code</button>
                <button class="cs-form-email-temporary-element" type='button' value='' id="cancel-email-button">Cancel</button>
            </div>
        </div>
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span id="cs-form-title-span-<?php echo $IDLetters ?>PhoneNumber">Phone Number:</span>
                <span id="<?php echo $IDLetters ?>PhoneNumber"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes[5]];} ?></span>
            </div>
            <div class="cs-form-elem-button">
                <button type="button" value="<?php echo $IDLetters ?>PhoneNumber" class="edit-button" id="edit-phoneNumber-button">Edit</button>
            </div>
        </div>
        <form name="cs-form-password-form" id="cs-form-password-form" action="" method="post">
            <div class="cs-form-elem">
                <div class="cs-form-elem-content">
                    <span id="cs-form-title-span-<?php echo $IDLetters ?>Password">Password :</span>
                    <span id="<?php echo $IDLetters ?>Password">**********</span>
                    <input class="cs-form-password-temporary-element" type='password' id="cs-form-input-<?php echo $IDLetters ?>Password-old">
                    <span class="cs-form-password-temporary-element">New Password :</span>
                    <input class="cs-form-password-temporary-element" type='password' id="cs-form-input-<?php echo $IDLetters ?>Password-original">
                    <span class="cs-form-password-temporary-element">Repeat New Password :</span>
                    <input class="cs-form-password-temporary-element" type='password' id="cs-form-input-<?php echo $IDLetters ?>Password-repeat">
                </div>
                <div class="cs-form-elem-button">
                    <button type="button" value="<?php echo $IDLetters ?>Password" class="edit-button" id="edit-password-button">Edit</button>
                    <button class="cs-form-password-temporary-element" type='button' value='' id="cancel-password-button">Cancel</button>
                </div>
            </div>
            <div class="" id="cs-form-elem-last">
                <div class="cs-form-elem-a">
                    <a href="profile.php">Done</a>
                </div>
            </div>
        </form>
    </div>
</div>


<?php include 'site-footer.php'?>
<script src="../javaScript/connection-security-buttons.js"></script>
<script type="text/javascript">
    setMarginTop('.site-header-main-header', 'cs-form-body', 40)
    window.addEventListener("resize", function(event) {
        setMarginTop('.site-header-main-header', 'cs-form-body', 40)
    })
</script>


</body>
</html>