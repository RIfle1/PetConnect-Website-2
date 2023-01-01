<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['home'];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/home-styles.css">
    <title>PetConnect</title>
</head>
<body>

<div class="background-dog-div">
    <img id="foreground-img" src="<?php echo getImage('iCollar_logo.png')?>" alt="iCollar_logo">
    <img id="background-img" src="<?php echo getImage('chien.jpg')?>" alt="chien"/>
</div>
<div class="text-font-500" id="slogan">
    <h1><?php echo $languageList["Technology for your animals"] ?></h1>
</div>
<?php include 'site-footer.php' ?>
</body>
</html>