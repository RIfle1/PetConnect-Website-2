<?php
session_start();
session_destroy();
include '../php-processes/dbConnection.php';
include 'site-header.php'
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
    <link rel="stylesheet" href="../css/sign-styles.css">
    <title>PetConnect Login</title>

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
            <div class="sign-form-elem"><h1>Password Recovery</h1></div>

            <div class="sign-form-elem">
                <label for="cltEmail-input">Email:</label>
                <input type="email" id="cltEmail-input" name="cltEmail-input"
                       value="<?= htmlspecialchars($_GET["cltEmail-input"] ?? "") ?>" required>
            </div>
            <?php if(!empty($_GET['isInvalid'])): ?>
                <div class="sign-form-elem">
                    <span class="sign-form-error-span"><?php echo 'This email does not have an account';?></span>
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
                <button id="submit-password-recovery-button" type="button">Send verification link</button>
            </div>

            <div class="sign-separation-line-small"></div>

<!--            <div class="sign-form-elem">-->
<!--                <a href="login.php">Login</a>-->
<!--            </div>-->

        </div>
    </div>
</form>

<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('.site-header-main-header', 'sign-form-body', 50)
    window.addEventListener("resize", function(event) {
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
