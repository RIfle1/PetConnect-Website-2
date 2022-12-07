<?php
//include 'site-header.php';
include 'dbConnection.php';
$result = getImage('chien');
$row = $result->fetch_array();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../css/home-styles.css">
    <title>PetConnect</title>
</head>
<body>
<div class="background-dog-div">


    <img id="foreground-img" src="../img/logos/iCollar_logo.png" alt="iCollar_logo">
    <img id="background-img" src="../img/<?php echo $row['imgCategory']."/".$row['imgPath']?>" alt="chien"/>
</div>

<div class="header-font" id="slogan">
    <h1>La technologie pour vos animaux</h1>
</div>

</body>
</html>