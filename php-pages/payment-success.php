<?php
session_start();
include '../php-processes/dbConnection.php';



include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['signup-success'];

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../css/sign-styles.css">

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous">
    </script>

    <title>PetConnect Signup</title>
</head>

<body class="text-font-700">

    <div id="sign-form-body">
        <div id="sign-form-body-div">
            <div class="sign-form-elem">
                <h1>Merci pour votre achat!</h1>
                <p>Vous pouvez retrouver votre numéro de collier dans votre adresse mail pour l'ajouter sur votre compte PetConnect</p>
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