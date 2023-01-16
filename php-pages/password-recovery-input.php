<?php
include '../php-processes/dbConnection.php';
logoutAndRedirect('../php-pages/password-recovery-input.php');
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['password-recovery-input'];
$commonStringsLanguageList = returnLanguageList()[returnLanguage()]['common-strings'];

$captchaLanguage = strtolower(substr(returnLanguage(), 0, 2));

?>
<!doctype html>
<html lang="en">
<head>

    <link rel="stylesheet" href="../css/sign-styles.css">
    <title>Password Recovery</title>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous">
    </script>

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

<form id="password-recovery-input-form" name="password-recovery-input-form" action="../php-processes/password-recovery-process.php" method="post">
    <div id="sign-form-body" class="text-font-700">
        <div id="sign-form-body-div">
            <div class="sign-form-elem"><h1><?php echo $languageList["Password Recovery"]?></h1></div>

            <div class="sign-form-elem">
                <label for="email-input"><?php echo $languageList["Email:"]?></label>
                <input type="email" id="email-input" name="email-input"
                       value="<?= htmlspecialchars($_GET["email-input"] ?? "") ?>" required>
            </div>
            <?php if(!empty($_GET['isInvalid'])): ?>
                <div class="sign-form-elem">
                    <span class="form-error-span"><?php echo 'This email does not have an account';?></span>
                </div>
            <?php endif; ?>
            <div class="separation-line-small"></div>

            <div class="sign-form-elem">
                <div id="recaptcha-div" class="g-recaptcha"></div>
            </div>

            <div class="sign-form-elem" id="sign-form-robot">
                <span><?php echo $commonStringsLanguageList["Please verify that you are not a robot."]?></span>
            </div>

            <div class="separation-line-small"></div>

            <div class="sign-form-elem">
                <button id="submit-password-recovery-button" type="button"><?php echo $languageList["Send Verification Link"]?></button>
            </div>
        </div>
    </div>
</form>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    // setMarginTop('sih-main-header', 'id', 'sign-form-body', 'id', -45)

    setToWindowHeight('sign-form-body', 'id', 0)
    setMarginTopFooter('sign-form-body', 'id', 'site-footer-main-div', 'id', 0)

</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=<?php echo $captchaLanguage ?>"
        async defer>
</script>

<script src='../javaScript/recaptcha-functions.js'></script>
</body>
</html>
