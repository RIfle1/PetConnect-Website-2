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
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">-->
    <link rel="stylesheet" href="../css/sign-styles.css">
    <title>PetConnect Signup</title>

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
            <label for="cltUsername-input"><?php echo $languageList["Username:"]?></label>
            <input type="text" id="cltUsername-input" name="cltUsername-input">
        </div>
        <div class="sign-form-elem">
            <label for="cltFirstName-input"><?php echo $languageList["First Name:"]?></label>
            <input type="text" id="cltFirstName-input" name="cltFirstName-input">
        </div>
        <div class="sign-form-elem">
            <label for="cltLastName-input"><?php echo $languageList["Last Name:"]?></label>
            <input type="text" id="cltLastName-input" name="cltLastName-input">
        </div>
        <div class="sign-form-elem">
            <label for="cltEmail-input"><?php echo $languageList["Email:"]?></label>
            <input type="email" id="cltEmail-input" name="cltEmail-input">
        </div>
        <div class="sign-form-elem">
            <label for="cltPhoneNumber-input"><?php echo $languageList["Phone Number:"]?></label>
            <input type="text" id="cltPhoneNumber-input" name="cltPhoneNumber-input">
        </div>
        <div class="sign-form-elem">
            <label for="cltPassword-input"><?php echo $languageList["Password:"]?></label>
            <input type="password" id="cltPassword-input" name="cltPassword-input">
        </div>
        <div class="sign-form-elem">
            <label for="cltPasswordConfirmation-input"><?php echo $languageList["Enter your password again:"]?></label>
            <input type="password" id="cltPasswordConfirmation-input" name="cltPasswordConfirmation-input">
        </div>
        <div class="sign-separation-line-small"></div>

        <div class="sign-form-elem">
            <div id="recaptcha-div" class="g-recaptcha"></div>
        </div>

        <div class="sign-form-elem" id="sign-form-robot">
            <span><?php echo $commonStringsLanguageList["Please verify that you are not a robot."]?></span>
        </div>

        <div class="sign-separation-line-small"></div>
        <div class="sign-form-elem">
            <button type="button" id="sign-submit-button" name="submit-button"><?php echo $languageList["Create an Account"]?></button>
        </div>
        <div class="sign-form-elem">
            <span><?php echo $languageList["By creating an account, you agree to PetConnect's"]?>
                <a href="#"><?php echo $languageList["Conditions of Use"]?></a>
                <?php echo $languageList["and"]?>
                <a href="#"><?php echo $languageList["Privacy Notice"]?></a>.</span>
        </div>
        <div class="sign-separation-line-small"></div>
        <div class="sign-form-elem">
            <p><?php echo $languageList["Already have an account?"]?> <a href="login.php"><?php echo $languageList["Sign in"]?> &rarr;</a></p>
        </div>
    </div>
</form>

<script src="../javaScript/signup-validation.js"></script>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('site-header-main-header', 'id', 'signup-form', 'id', 10)
</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=<?php echo $captchaLanguage ?>"
        async defer>
</script>

<script src="../javaScript/css-functions.js"></script>
<script src='../javaScript/recaptcha-functions.js'></script>

</body>
</html>