<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/home-styles.css">
    <title>PetConnect</title>
</head>
<body>
<?php
include 'site-header.php';
?>
<div class="background-dog-div">
    <img id="background-img" src="../img/dogs/chien.jpg" alt="Main-Dog">
    <img id="foreground-img" src="../img/logos/iCollar_logo.png" alt="iCollar_logo">
</div>

<div class="header-font" id="slogan">
    <h1>La technologie pour vos animaux</h1>
</div>

<?php
include 'entities.php';
//require __DIR__ . 'entities.php';
$client1 = new Client("","test","test"  , "test", "test", 123, "test");
$client1->autoSetCltID();
echo $client1->getCltID();
//echo "<hr>";
//echo returnLastIDInt("cltID", "Client", "clt");
//echo "<hr>";
//echo returnLastIDString("cltID", "Client", "clt");
//echo "<hr>";
//echo autoSetID("appID", "appareil", "asjhdasjk");
//echo "<hr>";
//echo idToInt("clt1_app3_adp4_wer66_sjfnsjf67", "clt");
?>
</body>
</html>