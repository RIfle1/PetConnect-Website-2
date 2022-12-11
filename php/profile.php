<?php
session_start();
include 'dbConnection.php';
include 'site-header.php';

$clientLoggedIn = false;
$adminLoggedIn = false;
$loggedIn = false;
$clientInfo = "";
$adminInfo = "";

if(!empty($_SESSION['loggedIn'])) {
    $loggedIn = $_SESSION['loggedIn'];
    if (isset($_POST['profile-submit-pfp'])) {
        if(!empty($_FILES['profile-upload']['name'])) {
            if(!empty($_SESSION['cltID'])) {
                uploadPfp('profile-upload',"client", 'cltPfpName');
            }
            elseif(!empty($_SESSION['admID'])) {
                uploadPfp('profile-upload',"admin", 'admPfpName');
            }

        }
    }

    if(!empty($_SESSION['cltID']) && $_SESSION['loggedIn'] === true) {
        $sql = "SELECT * FROM Client WHERE cltID = '".$_SESSION["cltID"]."'";
        $result = runSQLResult($sql);
        $clientInfo = $result->fetch_assoc();
        $clientLoggedIn = true;

    } elseif(!empty($_SESSION['admID']) && $_SESSION['loggedIn'] === true){
        $sql = "SELECT * FROM admin WHERE admID = '".$_SESSION["admID"]."'";
        $result = runSQLResult($sql);
        $adminInfo = $result->fetch_assoc();
        $adminLoggedIn = true;
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
                    <?php if(strlen($clientInfo['cltPfpName']) > 0): ?>
                        <img src="../img/pfp/<?php echo getPfp('cltID', 'client', $clientInfo['cltID'])['cltPfpName'] ?>" alt="Profile picture">
                    <?php else: ?>
                        <img src="../img/<?php echo getImage('client.png')['imgCategory'] . "/" . getImage('client.png')['imgPath'] ?>" alt="Client Pfp">
                    <?php endif; ?>
                <?php elseif($adminLoggedIn): ?>
                    <?php if($adminInfo['admPfpName']): ?>
                        <img src="../img/pfp/<?php echo getPfp('admID', 'admin', $adminInfo['admID'])['admPfpName'] ?>" alt="Profile picture">
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
                    <span><?php echo $clientInfo["cltUsername"] ?></span>
                    <span><?php echo $clientInfo["cltFirstName"] . " " . $clientInfo["cltLastName"] ?></span>
                    <span><?php echo $clientInfo["cltEmail"] ?></span>
                <?php elseif ($adminLoggedIn): ?>
                    <span><?php echo $adminInfo["admUsername"] ?></span>
                    <span><?php echo $adminInfo["admEmail"] ?></span>
                <?php endif; ?>
            <?php else: ?>
                <span>Votre Compte</span>
            <?php endif; ?>
        </div>
    </div>
    <div id="profile-bottom-div">
        <a href="<?php returnLink('devices.php') ?>"><span>Gérer mes appareils</span></a>
        <a href="<?php returnLink('order-history.php') ?>"><span>Mon historique de commandes</span></a>
        <a href="<?php returnLink('connection-security.php') ?>"><span>Connexion et sécurité</span></a>
        <a href="<?php returnLink('payment-method.php') ?>"><span>Mode de paiement</span></a>
        <a href="<?php returnLink('message-center.php') ?>"><span>Centre de Messagerie</span></a>
        <a href="<?php returnLink('addresses.php') ?>"><span>Adresses</span></a>
        <?php if ($adminLoggedIn): ?>
            <a href="manage-client.php"><span>Gérer les utilisateurs</span></a>
            <a href="#"><span>Répondre aux questions</span></a>
            <a href="#"><span>Gérer les données</span></a>
        <?php endif; ?>
    </div>
</div>

<?php include 'site-footer.php'?>
<script type="text/javascript">
    setMarginTop('.site-header-main-header', 'profile-main-div', 40)
    window.addEventListener("resize", function(event) {
        setMarginTop('.site-header-main-header', 'profile-main-div', 40)
    })
</script>
<script src="../javaScript/manage-client-buttons.js"></script>

</body>
</html>
