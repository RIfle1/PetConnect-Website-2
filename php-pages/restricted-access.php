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

    <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">-->
    <link rel="stylesheet" href="../css/sign-styles.css">
    <title><?php echo $languageList["An Error has occurred"]?></title>
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
    // setMarginTop('sih-main-header', 'id', 'sign-form-body', 'id', -120)

    setToWindowHeight('sign-form-body', 'id', 0)
    setMarginTopFooter('sign-form-body', 'id', 'site-footer-main-div', 'id', 0)
</script>

</body>
</html>