<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">-->
    <link rel="stylesheet" href="../css/sign-styles.css">
    <title>PetConnect Signup</title>
</head>
<body class="text-font-700">

<div id="sign-form-body">
    <div id="sign-form-body-div"><h1>An error has occurred</h1>
        <div class="sign-form-elem">
        <?php
        if(!empty($_SESSION['errorMsg'])) {
            echo $_SESSION['errorMsg'];
        } else {
            echo 'Unknown Error Message.';
        }
        ?>
        </div>
        <div class="sign-form-elem">
            <span>Try to<a href="login.php"> login</a>.</span>
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

</body>
</html>