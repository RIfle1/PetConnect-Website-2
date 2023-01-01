<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$commonStringsLanguageList = returnLanguageList()[returnLanguage()]['common-strings'];
$languageList = returnLanguageList()[returnLanguage()]['restricted-access'];

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
    <title>PetConnect Restricted Access</title>
</head>
<body class="text-font-700">

<div id="sign-form-body">
    <div id="sign-form-body-div">
        <div class="sign-form-elem">
            <h1><?php echo $languageList["An Error has occurred"]?></h1>
        </div>
        <div class="sign-form-elem">
            <span>
                <?php
                if(!empty($_SESSION['errorMsg'])) {
                    echo $_SESSION['errorMsg'];
                } else {
                    echo $commonStringsLanguageList["You do not have access to this page, if you think this is a mistake contact the web developer"];
                }
                ?>
            </span>
        </div>
        <div class="sign-form-elem">
            <span><?php echo $languageList["Try to"]?><a href="../php-pages/login.php"> <?php echo $languageList["login"]?></a>.</span>
        </div>
    </div>
</div>


<?php include '../php-pages/site-footer.php' ?>
<script type="text/javascript">
    setMarginTop('site-header-main-header', 'id', 'sign-form-body', 'id', 50)
</script>

</body>
</html>