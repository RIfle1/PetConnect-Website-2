<?php
//include 'site-header.php';
include '../php/dbConnection.php';
$result = getImage('chien');
$row = $result->fetch_array();
$img = "data:imgData;base64,".base64_encode($row['imgData']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Image retrieve</title>
</head>

<body>
<img id="background-img" src="<?php echo $img; ?>" alt="chien"/>
</body>
</html>