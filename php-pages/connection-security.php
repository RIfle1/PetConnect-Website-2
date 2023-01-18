<?php
session_start();
include '../php-processes/dbConnection.php';
clientAndAdminPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['connection-security'];
$javaScriptLanguageList = returnLanguageList()[returnLanguage()]['connection-security-buttons'];

?>

<!doctype html>
<html lang="en">
<head>


    <!--    Style Sheet-->
    <link rel="stylesheet" href="../css/edit-styles.css">
    <!--    Jquery-->

    <title>Connection and Security</title>
</head>
<body>

<script>
    let javaScriptLanguageList = <?php echo json_encode($javaScriptLanguageList) ?>
</script>

<div id="cs-form-body" class="text-font-500">
    <div id="cs-form-body-div">
        <div class="cs-form-elem"><h1><?php echo $languageList["Connection and Security"]?></h1></div>
<!--        Username-->
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span id="cs-form-title-span-username"><?php echo $languageList["Username :"]?></span>
                <?php if(isset($loggedIn) && isset($entityAttributes) && isset($entityInfo)): ?>
                    <span id="cs-form-info-span-username"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes['Username']];} ?></span>
                <?php endif; ?>
                <input class="cs-form-temp-input-username" id="cs-form-input-username" type="text">
            </div>
            <div class="cs-form-elem-button">
                <?php if(isset($IDLetters)): ?>
                    <button id="cs-form-edit-button-username" type="button" value="<?php echo $IDLetters ?>Username" name="Edit"><?php echo $languageList["Edit"]?></button>
                    <button class="cs-form-temp-button-username" id="cs-form-cancel-button-username" type="button" value="<?php echo $IDLetters ?>Username"><?php echo $languageList["Cancel"]?></button>
                <?php endif; ?>
            </div>
        </div>
<!--        First Name-->
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span id="cs-form-title-span-firstName"><?php echo $languageList["First Name :"]?></span>
                <?php if(isset($loggedIn) && isset($entityAttributes) && isset($entityInfo)): ?>
                    <span id="cs-form-info-span-firstName"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes["FirstName"]];} ?></span>
                <?php endif; ?>
                <input class="cs-form-temp-input-firstName" id="cs-form-input-firstName" type="text">
            </div>
            <div class="cs-form-elem-button">
                <?php if(isset($IDLetters)): ?>
                    <button id="cs-form-edit-button-firstName" type="button" value="<?php echo $IDLetters ?>FirstName" name="Edit"><?php echo $languageList["Edit"]?></button>
                    <button class="cs-form-temp-button-firstName" id="cs-form-cancel-button-firstName" type="button" value="<?php echo $IDLetters ?>FirstName"><?php echo $languageList["Cancel"]?></button>
                <?php endif; ?>
            </div>
        </div>
<!--        Last Name-->
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span id="cs-form-title-span-lastName"><?php echo $languageList["Last Name :"]?></span>
                <?php if(isset($loggedIn) && isset($entityAttributes) && isset($entityInfo)): ?>
                    <span id="cs-form-info-span-lastName"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes['LastName']];} ?></span>
                <?php endif; ?>
                <input class="cs-form-temp-input-lastName" id="cs-form-input-lastName" type="text">
            </div>
            <div class="cs-form-elem-button">
                <?php if(isset($IDLetters)): ?>
                    <button id="cs-form-edit-button-lastName" type="button" value="<?php echo $IDLetters ?>LastName" name="Edit"><?php echo $languageList["Edit"]?></button>
                    <button class="cs-form-temp-button-lastName" id="cs-form-cancel-button-lastName" type="button" value="<?php echo $IDLetters ?>LastName" ><?php echo $languageList["Cancel"]?></button>
                <?php endif; ?>
            </div>
        </div>
<!--        Phone Number-->
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span id="cs-form-title-span-phoneNumber"><?php echo $languageList["Phone Number :"]?></span>
                <?php if(isset($loggedIn) && isset($entityAttributes) && isset($entityInfo)): ?>
                    <span id="cs-form-info-span-phoneNumber"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes["PhoneNumber"]];} ?></span>
                <?php endif; ?>
                <input class="cs-form-temp-input-phoneNumber" id="cs-form-input-phoneNumber" type="text">
            </div>
            <div class="cs-form-elem-button">
                <?php if(isset($IDLetters)): ?>
                    <button id="cs-form-edit-button-phoneNumber" type="button" value="<?php echo $IDLetters ?>PhoneNumber" name="Edit"><?php echo $languageList["Edit"]?></button>
                    <button class="cs-form-temp-button-phoneNumber" id="cs-form-cancel-button-phoneNumber" type="button" value="<?php echo $IDLetters ?>PhoneNumber" ><?php echo $languageList["Cancel"]?></button>
                <?php endif; ?>
            </div>
        </div>
<!--        Email-->
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span id="cs-form-title-span-email"><?php echo $languageList["Email :"]?></span>
                <?php if(isset($loggedIn) && isset($entityAttributes) && isset($entityInfo)): ?>
                    <span id="cs-form-info-span-email"><?php if ($loggedIn) {echo $entityInfo[$entityAttributes["Email"]];} ?></span>
                <?php endif; ?>
                <span class="cs-form-temp-span2-email" id="cs-form-info-span2-email"></span>

                <span id="cs-form-temp-span" class="cs-form-temp-span2-email"><?php echo $languageList["A verification code has been sent to your new email address."]?></span>
                <span class="cs-form-temp-span2-email"><?php echo $languageList["Input the confirmation code :"]?></span>

                <input class="cs-form-temp-input-email" id="cs-form-input-email" type="text">
            </div>
            <div class="cs-form-elem-button">
                <?php if(isset($IDLetters)): ?>
                    <button id="cs-form-edit-button-email" type="button" value="<?php echo $IDLetters ?>Email" name="Edit"><?php echo $languageList["Edit"]?></button>
                    <button class="cs-form-temp-button-email" id="cs-form-cancel-button-email" type="button" value="<?php echo $IDLetters ?>Email" ><?php echo $languageList["Cancel"]?></button>
                <?php endif; ?>
            </div>
        </div>
<!--        Password-->
        <div class="cs-form-elem">
            <div class="cs-form-elem-content">
                <span  class="cs-form-temp-span-password"><?php echo $languageList["Old Password :"]?></span>
                <input class="cs-form-temp-input-password" type='password' id="cs-form-input-password-old">

                <span id="cs-form-title-span-password"><?php echo $languageList["Password :"]?></span>
                <span id="cs-form-info-span-password">**********</span>

                <input class="cs-form-temp-input-password" type='password' id="cs-form-input-password">
                <span  class="cs-form-temp-span-password"><?php echo $languageList["Repeat New Password :"]?></span>
                <input class="cs-form-temp-input-password" type='password' id="cs-form-input-password-repeat">

            </div>
            <div class="cs-form-elem-button">
                <?php if(isset($IDLetters)): ?>
                    <button id="cs-form-edit-button-password" type="button" value="<?php echo $IDLetters ?>Password" name="Edit"><?php echo $languageList["Edit"]?></button>
                    <button class="cs-form-temp-button-password" id="cs-form-cancel-button-password" type="button" value="<?php echo $IDLetters ?>Password" ><?php echo $languageList["Cancel"]?></button>
                <?php endif; ?>
            </div>
        </div>

<!--            Done Button-->
        <div id="cs-form-elem-last">
            <div class="cs-form-elem-a">
                <a href="profile.php"><?php echo $languageList["Done"]?></a>
            </div>
        </div>
    </div>
</div>


<?php include '../php-pages/site-footer.php' ?>

<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'cs-form-body', 'id', -40)

    setToWindowHeight('cs-form-body', 'id', 0)
    setMarginTopFooter('cs-form-body', 'id', 'site-footer-main-div', 'id', 0)
</script>

<script src="../javaScript/validation-functions.js"></script>
<script src="../javaScript/connection-security-buttons.js"></script>

</body>
</html>