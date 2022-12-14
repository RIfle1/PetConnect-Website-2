<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

if(empty($_SESSION['resetPassword'])) {
    header("Location: ../php-pages/restricted-access.php", true,303);
    exit;
}
elseif($_SESSION['resetPassword'] === false) {
    header("Location: ../php-pages/restricted-access.php", true,303);
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

    <title>PetConnect Password Recovery</title>
</head>
<body class="text-font-700">

<div id="sign-form-body">
    <div id="sign-form-body-div">
        <h1 id="sign-form-header">Password Recovery</h1>
        <div class="sign-form-elem">
            <span>
                <?php if (!empty($_SESSION['message'])): ?>
                    <?php echo $_SESSION['message']; ?>
                <?php endif; ?>
            </span>
        </div>
        <div class="sign-form-elem">
            <a href="login.php">Sign in &rarr;</a>
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