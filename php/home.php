<?php
include 'site-header.php';
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

    <img id="foreground-img" src="../img/<?php echo getImage('iCollar_logo.png')['imgCategory']."/".getImage('iCollar_logo.png')['imgPath']?>" alt="iCollar_logo">
    <img id="background-img" src="../img/<?php echo getImage('chien.jpg')['imgCategory']."/".getImage('chien.jpg')['imgPath']?>" alt="chien"/>
</div>
<div class="text-font-500" id="slogan">
    <h1>La technologie pour vos animaux</h1>
</div>
<?php include 'site-footer.php' ?>
</body>
</html>