<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

if (!empty($_SESSION['cltToken'])) {
    $cltToken = $_SESSION['cltToken'];
}
elseif(empty($_SESSION['newCltID']) || empty($_SESSION['verificationCode'])) {
    $_SESSION['errorMsg'] = 'You do not have access to this page. If you think this is an error, contact a web developper.';
    header("Location: restricted-access.php-pages");
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

    <link rel="stylesheet" href="../css/sign-styles.css">

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous">
    </script>

  <title>PetConnect Signup</title>
</head>
<body class="text-font-700">

<div id="sign-form-body">
    <div id="sign-form-body-div">
        <h1 id="sign-form-header">Validate your email</h1>
        <div class="sign-form-elem">
            <p id="sign-form-message">
                <?php if (!empty($_SESSION['message'])): ?>
                    <?php echo $_SESSION['message']; ?>
                <?php endif; ?>
            </p>
        </div>
        <div class="sign-form-elem" id="sign-form-input-div">
            <label for="verificationCode-input">Verification Code:</label>
            <input type="text" id="verificationCode-input" name="verificationCode-input">
        </div>
        <div class="sign-form-elem" id="sign-form-validate-error">
            <span>The verification code is incorrect.</span>
        </div>
        <div class="sign-form-elem" id="submit-button-div">
            <button id="submit-button" type="button" name="submit-button">Validate Email</button>
        </div>
    </div>
</div>


<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('.site-header-main-header', 'sign-form-body', 50)
    window.addEventListener("resize", function(event) {
        setMarginTop('.site-header-main-header', 'sign-form-body', 50)
    })
</script>

<script src="../javaScript/css-functions.js"></script>
<script src="../javaScript/signup-email-validation.js"></script>
</body>
</html>