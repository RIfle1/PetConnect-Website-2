<?php
include '../php-processes/dbConnection.php';
logoutAndRedirect("../php-pages/login.php");
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['login'];
$commonStringsLanguageList = returnLanguageList()[returnLanguage()]['common-strings'];

$captchaLanguage = strtolower(substr(returnLanguage(), 0, 2));

?>
<!doctype html>
<html lang="en">
<head>

    <link rel="stylesheet" href="../css/sign-styles.css">
    <title>Login</title>

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

<form id = "login-form" name="login-form" action="../php-processes/login-process.php" method="post">
    <div id="sign-form-body" class="text-font-700">
        <div id="sign-form-body-div">
            <div class="sign-form-elem"><h1><?php echo $languageList["Sign in"]?></h1></div>
            <div id="login-Invalid">
                <?php if ($_GET['isInvalid'] ?? ""): ?>
                    <em><?php echo $languageList['Invalid Login']?></em>
                <?php endif; ?>
            </div>
            <div class="sign-form-elem">
                <label for="lgEmail-input"><?php echo $languageList["Email"]?>:</label>
                <input type="email" id="lgEmail-input" name="lgEmail-input"
                       value="<?= htmlspecialchars($_GET["lgEmail-input"] ?? "") ?>" required>
            </div>
            <div class="sign-form-elem">
                <label for="lgPassword-input"><?php echo $languageList["Password"]?>:</label>
                <input type="password" id="lgPassword-input" name="lgPassword-input" required>
            </div>
            <div class="separation-line-small"></div>

            <div class="sign-form-elem">
                    <div id="recaptcha-div" class="g-recaptcha"></div>
            </div>

            <div class="sign-form-elem" id="sign-form-robot">
                <span><?php echo $commonStringsLanguageList["Please verify that you are not a robot."]?></span>
            </div>

            <div class="separation-line-small"></div>

            <div class="sign-form-elem">
                <button id="submit-login-button" type="button"><?php echo $languageList["Login"]?></button>
            </div>

            <div class="separation-line-small"></div>
            <div class="sign-form-elem">
                <a href="password-recovery-input.php"><?php echo $languageList["Forgot Password"]?></a>
            </div>
            <div class="sign-form-elem">
                <a href="signup.php"><span><?php echo $languageList["Don't have an account?"]?></span> <?php echo $languageList["Signup"]?></a>
            </div>
        </div>
    </div>
</form>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'sign-form-body', 'id', -50)

    setToWindowHeight('sign-form-body', 'id', 0)
    setMarginTopFooter('sign-form-body', 'id', 'site-footer-main-div', 'id', 0)

</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=<?php echo $captchaLanguage ?>"
        async defer>
</script>

<script src='../javaScript/recaptcha-functions.js'></script>
</body>
</html>
