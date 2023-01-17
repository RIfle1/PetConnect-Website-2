<?php
include '../php-processes/dbConnection.php';
logoutAndRedirect('../php-pages/signup.php');
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['signup'];
$commonStringsLanguageList = returnLanguageList()[returnLanguage()]['common-strings'];
$captchaLanguage = strtolower(substr(returnLanguage(), 0, 2));

?>
<!doctype html>
<html lang="en">
<head>

<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">-->
    <link rel="stylesheet" href="../css/sign-styles.css">
    <title><?php echo $languageList["Create an account"]?></title>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        var onloadCallback = function() {
            // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
            // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
            widgetId1 = grecaptcha.render('recaptcha-div', {
                'sitekey' : '6Lev8m0jAAAAALf97k2YBnzcl9_a6Pemmr2kf-pW',
                'theme' : 'dark'
            });
        };
    </script>

</head>
<body>

<form id="signup-form" name="signup-form" action="../php-processes/signup-process.php" method="post">
    <div id="sign-form-body-div" class="text-font-700">
        <div class="sign-form-elem">
            <h1><?php echo $languageList["Create an account"]?></h1>
        </div>
        <div class="sign-form-elem">
            <label for="username-input"><?php echo $languageList["Username:"]?></label>
            <input type="text" id="username-input" name="username-input">
        </div>
        <div class="sign-form-elem">
            <label for="firstName-input"><?php echo $languageList["First Name:"]?></label>
            <input type="text" id="firstName-input" name="firstName-input">
        </div>
        <div class="sign-form-elem">
            <label for="lastName-input"><?php echo $languageList["Last Name:"]?></label>
            <input type="text" id="lastName-input" name="lastName-input">
        </div>
        <div class="sign-form-elem">
            <label for="email-input"><?php echo $languageList["Email:"]?></label>
            <input type="email" id="email-input" name="email-input">
        </div>
        <div class="sign-form-elem">
            <label for="phoneNumber-input"><?php echo $languageList["Phone Number:"]?></label>
            <input type="text" id="phoneNumber-input" name="phoneNumber-input">
        </div>
        <div class="sign-form-elem">
            <label for="password-input"><?php echo $languageList["Password:"]?></label>
            <input type="password" id="password-input" name="password-input">
        </div>
        <div class="sign-form-elem">
            <label for="passwordConfirmation-input"><?php echo $languageList["Enter your password again:"]?></label>
            <input type="password" id="passwordConfirmation-input" name="passwordConfirmation-input">
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
            <button type="button" id="sign-submit-button" name="submit-button"><?php echo $languageList["Create an Account"]?></button>
        </div>
        <div class="sign-form-elem">
            <span><?php echo $languageList["By creating an account, you agree to PetConnect's"]?>
                <a href="#"><?php echo $languageList["Conditions of Use"]?></a>
                <?php echo $languageList["and"]?>
                <a href="#"><?php echo $languageList["Privacy Notice"]?></a>.</span>
        </div>
        <div class="separation-line-small"></div>
        <div class="sign-form-elem">
            <p><?php echo $languageList["Already have an account?"]?> <a href="login.php"><?php echo $languageList["Sign in"]?> &rarr;</a></p>
        </div>
    </div>
</form>

<script src="../javaScript/validation-functions.js"></script>
<script src="../javaScript/signup-validation.js"></script>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('sih-main-header', 'id', 'signup-form', 'id', 20)

    setTimeout(() => {
        setMarginTopFooter('signup-form', 'id', 'site-footer-main-div', 'id', 200)
        // NEEDS TO BE FIXED => WHEN ERRORS APPEAR, FOOTER HAS WRONG MARGIN
    }, 1);

</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=<?php echo $captchaLanguage ?>"
        async defer>
</script>

<script src='../javaScript/recaptcha-functions.js'></script>

</body>
</html>