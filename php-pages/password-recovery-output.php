<?php
include '../php-processes/dbConnection.php';

session_start();
if(empty($_SESSION['resetPassword']) || empty($_SESSION['message'])) {
    header("Location: ../php-pages/restricted-access.php", true,303);
    exit;
}

include 'site-header.php';
$languageList = returnLanguageList()[returnLanguage()]['password-recovery-output'];

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

    <title>PetConnect Password Recovery</title>
</head>
<body class="text-font-700">

<div id="sign-form-body">
    <div id="sign-form-body-div">
        <div class="sign-form-elem">
            <h1><?php echo $languageList["Password Recovery"]?></h1>
        </div>
        <div class="sign-form-elem">
            <span>
                <?php if (!empty($_SESSION['message'])): ?>
                    <?php echo $_SESSION['message']; ?>
                <?php endif; ?>
            </span>
        </div>
        <div class="sign-form-elem">
            <a href="login.php"><?php echo $languageList["Sign in"]?> &rarr;</a>
        </div>
    </div>
</div>


<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    // setMarginTop('site-header-main-header', 'id', 'sign-form-body', 'id', -60)

    setToWindowHeight('sign-form-body', 'id', 0)
    setMarginTopFooter('sign-form-body', 'id', 'site-footer-main-div', 'id', 0)
</script>

<script src="../javaScript/css-functions.js"></script>
<script src="../javaScript/signup-email-validation.js"></script>
</body>
</html>