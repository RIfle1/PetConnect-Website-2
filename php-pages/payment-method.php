<?php
session_start();
include '../php-processes/dbConnection.php';
onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['payment-method'];

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--    Style Sheet-->
    <link rel="stylesheet" href="../css/payment-method-style.css">
    <!--    Jquery-->

    <title>Payment method</title>
</head>

<body>
    <main>
        <div id="pm-form-body" class="text-font-500">
<!--            <lien><a href="profile.php">--><?php //echo $languageList["Account"] ?><!--</a>><a id="actif" href="">--><?php //echo $languageList["Payment method"] ?><!--</a></lien>-->
            <form>
                <h2><?php echo $languageList["Add payment method"] ?></h2>
                <div>
                    <ul id="pay">
                        <li><a href="#"><?php echo $languageList["Bank card"] ?></a></li>
                        <li><a href="#">PAYPAL</a></li>
                        <li><a href="#">Apple Pay</a></li>
                    </ul>
                </div>
            </form>
        </div>
    </main>


    <?php include 'site-footer.php' ?>

    <script type="text/javascript">
        setMarginTop('sih-main-header', 'id', 'pm-form-body', 'id', 20)

        // setToWindowHeight('profile-main-div', 'id', 0)
        setMarginTopFooter('pm-form-body', 'id', 'site-footer-main-div', 'id', 0)
    </script>

</body>

</html>