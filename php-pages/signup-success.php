<?php
include '../php-processes/dbConnection.php';

session_start();

$commonStringsLanguageList = returnLanguageList()[returnLanguage()]['common-strings'];
if(empty($_SESSION['newCltID']) || empty($_SESSION['verificationCode']) || empty($_SESSION['Token'])) {
    $_SESSION['errorMsg'] = $commonStringsLanguageList["You do not have access to this page, if you think this is a mistake contact the web developer"];
    header("Location: ../php-pages/restricted-access.php");
    exit;
}

include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['signup-success'];

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
        <div class="sign-form-elem">
            <h1><?php echo $languageList["Validate your email"]?></h1>
        </div>
        <div class="sign-form-elem">
            <span id="sign-form-message">
                <?php if (!empty($_SESSION['message'])): ?>
                    <?php echo $_SESSION['message']; ?>
                <?php endif; ?>
            </span>
            <span id="sign-form-message-success">
                <?php echo $languageList['Your email has been validated. You can now']?><a href="../php-pages/login.php"> <?php echo $languageList['Login']?></a>
            </span>
        </div>
        <div class="sign-form-elem" id="sign-form-input-div">
            <label for="verificationCode-input"><?php echo $languageList["Verification Code:"]?></label>
            <input type="text" id="verificationCode-input" name="verificationCode-input">
        </div>
        <div class="sign-form-elem" id="sign-form-validate-error">
            <span><?php echo $languageList["The verification code is incorrect."]?></span>
        </div>
        <div class="sign-form-elem" id="submit-button-div">
            <button id="submit-button" type="button" name="submit-button"><?php echo $languageList["Validate Email"]?></button>
        </div>
    </div>
</div>


<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('site-header-main-header', 'id', 'sign-form-body', 'id', 50)
</script>

<script src="../javaScript/css-functions.js"></script>
<script src="../javaScript/signup-email-validation.js"></script>
</body>
</html>