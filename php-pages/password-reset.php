<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

// Security stuff
if(empty($_SESSION['Token']) || empty($_SESSION['resetPassword'])) {
    header("Location: restricted-access.php", true, 303);
    exit;
}
if($_SESSION['Token'] !== $_GET['Token']) {
    header("Location: restricted-access.php", true, 303);
    exit;
}

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
    <title>PetConnect Password Recovery</title>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous">
    </script>

    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="../javaScript/password-reset-validation.js" defer></script>

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
            <div class="sign-form-elem"><h1>Reset your password</h1></div>

            <div class="sign-form-elem">
                <label for="newPassword-input">New Password:</label>
                <input type="password" id="newPassword-input" name="newPassword-input" value="">
            </div>
            <div class="sign-form-elem">
                <label for="newPasswordConfirmation-input">Enter your new password again:</label>
                <input type="password" id="newPasswordConfirmation-input" name="newPasswordConfirmation-input" value="">
            </div>

            <?php if ($_GET['isInvalid'] ?? ""): ?>
                <div class="sign-form-elem">
                    <span>Your new password has to be different from your old password.</span>
                </div>
            <?php endif; ?>

            <div class="sign-separation-line-small"></div>

            <div class="sign-form-elem">
                <div id="recaptcha-div" class="g-recaptcha"></div>
            </div>

            <div class="sign-form-elem" id="sign-form-robot">
                <span>Please verify that you are not a robot.</span>
            </div>

            <div class="sign-separation-line-small"></div>
            <div class="sign-form-elem">
                <button type="submit" id="submit-password-reset-button">Change Password</button>
            </div>


        </div>

    </div>

</form>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('.site-header-main-header', 'sign-form-body', 50)
    window.addEventListener("resize", function() {
        setMarginTop('.site-header-main-header', 'sign-form-body', 50)
    })
</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
</script>
<script src="../javaScript/css-functions.js"></script>
<script src='../javaScript/recaptcha-functions.js'></script>

</body>
</html>