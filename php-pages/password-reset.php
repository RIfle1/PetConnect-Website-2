<?php
include '../php-processes/dbConnection.php';
logoutAndRedirect('../php-pages/password-reset.php');

session_start();
// Security stuff

$languageList = returnLanguageList()[returnLanguage()]['password-reset'];

if((empty($_GET['cltEmail']) || empty($_GET['admEmail'])) && empty($_GET['Token']) && empty($_GET['isInvalid'])) {
    $_SESSION['errorMsg'] = $languageList["We don't know what you want to reset."];
    header("Location: restricted-access.php", true, 303);
    exit();
}

if(!empty($_GET['cltEmail'])) {
    if(!compareEmailAndToken($_GET['cltEmail'], $_GET['Token'], 'client')){
        $_SESSION['errorMsg'] = $languageList['The Link you are using to reset your password has expired or has already been used'];
        header("Location: restricted-access.php", true, 303);
        exit();
    }
    $_SESSION['Token'] = $_GET['Token'];
    $_SESSION['Table'] = 'client';
    $_SESSION['resetPassword'] = true;
    $_SESSION['cltEmail'] = $_GET['cltEmail'];
}
elseif(!empty($_GET['admEmail'])) {
    if(!compareEmailAndToken($_GET['admEmail'], $_GET['Token'], 'admin')){
        $_SESSION['errorMsg'] = $languageList['The Link you are using to reset your password has expired or has already been used'];
        header("Location: restricted-access.php", true, 303);
        exit();
    }
    $_SESSION['Token'] = $_GET['Token'];
    $_SESSION['Table'] = 'admin';
    $_SESSION['resetPassword'] = true;
    $_SESSION['admEmail'] = $_GET['admEmail'];
}

include 'site-header.php';
$languageList = returnLanguageList()[returnLanguage()]['password-reset'];
$commonStringsLanguageList = returnLanguageList()[returnLanguage()]['common-strings'];
$captchaLanguage = strtolower(substr(returnLanguage(), 0, 2));
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/sign-styles.css">
    <title><?php echo $languageList["Password Recovery"]?></title>

    <script type="text/javascript">
        var onloadCallback = function() {
            // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
            // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
            grecaptcha.render('recaptcha-div', {
                'sitekey' : '6Lev8m0jAAAAALf97k2YBnzcl9_a6Pemmr2kf-pW',
                'theme' : 'dark'
            });
        };
    </script>

</head>
<body>

<form id="password-reset-form" name="password-reset-form" action="../php-processes/password-reset-process.php" method="post">
    <div id="sign-form-body" class="text-font-700">
        <div id="sign-form-body-div">
            <div class="sign-form-elem">
                <h1><?php echo $languageList["Reset your password"]?></h1>
            </div>

            <div class="sign-form-elem">
                <label for="newPassword-input"><?php echo $languageList["New Password:"]?></label>
                <input type="password" id="newPassword-input" name="newPassword-input" value="">
            </div>
            <div class="sign-form-elem">
                <label for="newPasswordConfirmation-input"><?php echo $languageList["Enter your new password again:"]?></label>
                <input type="password" id="newPasswordConfirmation-input" name="newPasswordConfirmation-input" value="">
            </div>

            <?php if ($_GET['isInvalid'] ?? ""): ?>
                <div class="sign-form-elem">
                    <span class="form-error-span"><?php echo $languageList["Your new password has to be different from your old password."]?></span>
                </div>
            <?php endif; ?>

            <div class="separation-line-small"></div>

            <div class="sign-form-elem">
                <div id="recaptcha-div" class="g-recaptcha"></div>
            </div>

            <div class="sign-form-elem" id="sign-form-robot">
                <span><?php echo $commonStringsLanguageList["Please verify that you are not a robot."]?></span>
            </div>

            <div class="sign-separation-line-small"></div>
            <div class="sign-form-elem">
                <button type="button" id="submit-password-reset-button"><?php echo $languageList["Change Password"]?></button>
            </div>


        </div>

    </div>

</form>

<script src="../javaScript/validation-functions.js"></script>
<script src="../javaScript/password-reset-validation.js"></script>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    // setMarginTop('sih-main-header', 'id', 'sign-form-body', 'id', -60)

    setToWindowHeight('sign-form-body', 'id', 0)
    setMarginTopFooter('sign-form-body', 'id', 'site-footer-main-div', 'id', 0)
</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=<?php echo $captchaLanguage ?>"
        async defer>
</script>

<script src='../javaScript/recaptcha-functions.js'></script>

</body>
</html>