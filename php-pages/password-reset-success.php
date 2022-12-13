<?php
session_start();
session_destroy();
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
<body id='sign-form-real-body' class="text-font-700">

<div id="sign-form-body">
    <div id="sign-form-body-div"><h1>Reset your password</h1>
        <div class="sign-form-elem">
            <span>
                <?php
                if(!empty($_GET['success'])){
                    if($_GET['success'] === '1') {
                        echo 'Your account password has been successfully changed.';
                    }elseif($_GET['success'] === '2') {
                        echo 'Your account password could not be changed.';
                    }
                }
                else {
                    echo 'You do not have access to this page. If you think this is an error, please contact a web developer.';
                }
                ?>
            </span>
        </div>
        <div class="sign-form-elem">
            <span>You can now<a href="login.php"> login</a>.</span>
        </div>
    </div>
</div>


<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('.site-header-main-header', 'sign-form-body', 50)
    window.addEventListener("resize", function(event) {
        setMarginTop('.site-header-main-header', 'sign-form-body', 50)
    })

    // window.addEventListener("resize", function(event) {
    //     setMarginTopInt('site-footer-main-div', 600, window.innerHeight);
    //     const val1 = $('.site-header-main-header').css('height').replace("px", "");
    //     const val2 = $('#sign-form-body').css("margin-top").replace("px", "");
    //     const valTotal = parseInt($(window).height()) - parseInt(val1) - parseInt(val2);
    //     console.log(parseInt($(window).height()));
    //
    //     $('#site-footer-main-div').css('margin-top', valTotal+"px");
    // })
</script>

</body>
</html>
