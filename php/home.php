<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/home-styles.css">
    <link rel="stylesheet" href="../css/global-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <title>PetConnect</title>
</head>
<body>
<div class="main-header">

    <div class="logo">
        <img src="../img/logos/PetConnect-Logo.png" alt="PetConnect-Logo">
    </div>

    <div class="header-font" id="menu">
        <a href="home.php">Accueil</a>
        <a href="#">Boutique</a>
        <a href="#">Assistance</a>
    </div>

    <div class="profile">
        <div id="profile-div-flex">
            <div id="profile-logo"><a href="#"><img id="profile-img-1" src="../img/profile/client.png" alt="Client-logo"></a></div>
            <div id="dropdown-menu" class="text-font">
                <p>Bonjour XXXXX</p>
                <div class="dropdown-menu-line"></div>
                <a href="#">Mon Compte</a>
                <a href="#">Mes Commandes</a>
                <a href="#">Mes Appareils</a>
                <div class="dropdown-menu-line"></div>
                <a href="#">Logout</a>
            </div>
        </div>
        <div>
            <a href="#"><img id="profile-img-2" src="../img/profile/basket.png" alt="Basket-logo"></a>
        </div>

    </div>

</div>

<div class="background-dog-div">
    <img id="background-img" src="../img/dogs/chien.jpg" alt="Main-Dog">
    <img id="foreground-img" src="../img/logos/iCollar_logo.png" alt="iCollar_logo">
</div>

<div class="header-font" id="slogan">
    <h1>La technologie pour vos animaux</h1>
</div>

<div>
    <?php

    include 'dbConnection.php';
    $conn = OpenCon();

    $test_query = 'SELECT cltID, cltFirstName, cltLastName FROM Client';
    $result = mysqli_query($conn, $test_query);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["cltID"]. " - Name: " . $row["cltFirstName"]. " - LastName: " . $row["cltLastName"]. "<br>";
        }
    } else {
        echo "0 results";
    }

    CloseCon($conn);
    ?>


</div>

<div>
</div>

</body>
</html>