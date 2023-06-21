<?php
include_once '../php-processes/dbConnection.php';
logoutAndRedirect("../php-pages/password-reset-success.php");

if(empty($_GET['success'])) {
    header("Location: ../php-pages/restricted-access.php",true, 303);
    exit();
}

include_once 'site-header.php';
$languageList = returnLanguageList()[returnLanguage()]['password-reset-success'];
?>

<!doctype html>
<html lang="en">
<head>

    <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">-->
    <link rel="stylesheet" href="../css/sign-styles.css">
    <title>Signup</title>
</head>
<body id='sign-form-real-body' class="text-font-700">

<div id="sign-form-body">
    <div id="sign-form-body-div">
        <div class="sign-form-elem">
            <h1><?php echo $languageList["Reset your password"]?></h1>
        </div>
        <div class="sign-form-elem">
            <span>
                <?php
                if(!empty($_GET['success'])){
                    if($_GET['success'] === '1') {
                        echo $languageList['Your account password has been successfully changed.'];
                    }elseif($_GET['success'] === '2') {
                        echo $languageList['Your account password could not be changed.'];
                    }
                }
                ?>
            </span>
        </div>
        <div class="sign-form-elem">
            <span><?php echo $languageList["You can now"]?><a href="login.php"> <?php echo $languageList["login"]?></a>.</span>
        </div>
    </div>
</div>


<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    // setMarginTop('sih-main-header', 'id', 'sign-form-body', 'id', -100)

    setToWindowHeight('sign-form-body', 'id', 0)
    setMarginTopFooter('sign-form-body', 'id', 'site-footer-main-div', 'id', 0)
</script>

</body>
</html>
