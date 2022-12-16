<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

// CHECK WHO'S LOGGED IN
$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];
$entityInfo = returnEntityInfo();

//if($clientLoggedIn){
//    $sql = "SELECT * FROM Client WHERE cltID = '".$_SESSION["cltID"]."'";
//    $result = runSQLResult($sql);
//    $clientInfo = $result->fetch_assoc();
//}
//elseif($adminLoggedIn) {
//    $sql = "SELECT * FROM admin WHERE admID = '".$_SESSION["admID"]."'";
//    $result = runSQLResult($sql);
//    $adminInfo = $result->fetch_assoc();
//}

// CHANGE PROFILE PICTURE FUNCTION
if (isset($_POST['profile-submit-pfp'])) {
    if(!empty($_FILES['profile-upload']['name'])) {
        if($clientLoggedIn) {
            uploadPfp('profile-upload',"client", 'cltPfpName');
        }
        elseif($adminLoggedIn) {
            uploadPfp('profile-upload',"admin", 'admPfpName');
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile-styles.css">
    <title>Profile</title>
</head>
<body>

<div id="profile-main-div" class="text-font-700">
    <div id="profile-top-div">
        <div id="profile-top-div-column-1">
            <?php if ($loggedIn): ?>
                <?php if($clientLoggedIn): ?>
                    <?php if(strlen($entityInfo['cltPfpName']) > 0): ?>
                        <img src="../img/pfp/<?php echo getPfp('cltID', 'client', $entityInfo['cltID'])['cltPfpName'] ?>" alt="Profile picture">
                    <?php else: ?>
                        <img src="../img/<?php echo getImage('client.png')['imgCategory'] . "/" . getImage('client.png')['imgPath'] ?>" alt="Client Pfp">
                    <?php endif; ?>
                <?php elseif($adminLoggedIn): ?>
                    <?php if(strlen($entityInfo['admPfpName']) > 0): ?>
                        <img src="../img/pfp/<?php echo getPfp('admID', 'admin', $entityInfo['admID'])['admPfpName'] ?>" alt="Profile picture">
                    <?php else: ?>
                        <img src="../img/<?php echo getImage('client.png')['imgCategory'] . "/" . getImage('client.png')['imgPath'] ?>" alt="Client Pfp">
                    <?php endif; ?>
                <?php endif; ?>
                <div id="profile-pfp-overlay">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div id="profile-pfp-overlay-div">
                            <label for="profile-upload-pfp-input">Select Image
                                <input id="profile-upload-pfp-input" type="file" name="profile-upload" value=""/>
                            </label>
                            <label for="profile-submit-pfp-input">Upload Image
                                <input id="profile-submit-pfp-input" type="submit" name="profile-submit-pfp">
                            </label>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <img src="../img/<?php echo getImage('client.png')['imgCategory'] . "/" . getImage('client.png')['imgPath'] ?>" alt="Profile picture">
            <?php endif; ?>
        </div>
        <div id="profile-top-div-column-2">
            <?php if ($loggedIn): ?>
                <?php if ($clientLoggedIn): ?>
                    <span><?php echo $entityInfo["cltUsername"] ?></span>
                    <span><?php echo $entityInfo["cltFirstName"] . " " . $entityInfo["cltLastName"] ?></span>
                    <span><?php echo $entityInfo["cltEmail"] ?></span>
                <?php elseif ($adminLoggedIn): ?>
                    <span><?php echo $entityInfo["admUsername"] ?></span>
                    <?php if(strlen($entityInfo['admFirstName'] && strlen($entityInfo['admLastName']))): ?>
                    <span><?php echo $entityInfo["admFirstName"] . " " . $entityInfo["admLastName"] ?></span>
                    <?php endif; ?>
                    <span><?php echo $entityInfo["admEmail"] ?></span>
                <?php endif; ?>
            <?php else: ?>
                <span>Votre Compte</span>
            <?php endif; ?>
        </div>
    </div>
    <div id="profile-bottom-div">
        <a href="<?php returnToHomePage('../php-pages/devices.php') ?>"><span>Gérer mes appareils</span></a>
        <a href="<?php returnToHomePage('../php-pages/order-history.php') ?>"><span>Mon historique de commandes</span></a>
        <a href="<?php returnToHomePage('../php-pages/connection-security.php') ?>"><span>Connexion et sécurité</span></a>
        <a href="<?php returnToHomePage('../php-pages/payment-method.php') ?>"><span>Mode de paiement</span></a>
        <a href="<?php returnToHomePage('../php-pages/message-center.php') ?>"><span>Centre de Messagerie</span></a>
        <a href="<?php returnToHomePage('../php-pages/addresses.php') ?>"><span>Adresses</span></a>
        <?php if ($adminLoggedIn): ?>
            <a href="manage-user.php"><span>Gérer les utilisateurs</span></a>
            <a href="#"><span>Répondre aux questions</span></a>
            <a href="#"><span>Gérer les données</span></a>
        <?php endif; ?>
    </div>
</div>

<?php include 'site-footer.php'?>
<script type="text/javascript">
    setMarginTop('.site-header-main-header', 'profile-main-div', 30)
    window.addEventListener("resize", function(event) {
        setMarginTop('.site-header-main-header', 'profile-main-div', 30)
    })
</script>
<script src="../javaScript/manage-user-buttons.js"></script>

</body>
</html>
