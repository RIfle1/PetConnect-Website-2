<?php
session_start();
include '../php-processes/dbConnection.php';
include 'site-header.php';

// CHECK WHO'S LOGGED IN
$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];
$entityInfo = returnEntityInfo();


// CHANGE PROFILE PICTURE FUNCTION
if (isset($_POST['profile-submit-pfp'])) {
    if (!empty($_FILES['profile-upload']['name'])) {
        if ($clientLoggedIn) {
            uploadPfp('profile-upload', "client", 'cltPfpName');
        } elseif ($adminLoggedIn) {
            uploadPfp('profile-upload', "admin", 'admPfpName');
        }
    }
}

$languageList = returnLanguageList()[returnLanguage()]['profile'];

?>

<!doctype html>
<html lang="en">

<head>

    <link rel="stylesheet" href="../css/profile-styles.css">
    <title>Profile</title>
</head>

<body>
    <div id="profile-main-div" class="text-font-700">
        <div id="background-image"></div>
        <div id="profile-top-div">
            <div id="profile-top-div-column-1">
                <?php if ($loggedIn) : ?>
                    <?php if ($clientLoggedIn) : ?>
                        <?php if (strlen($entityInfo['cltPfpName']) > 0) : ?>
                            <img src="../img/pfp/<?php echo getPfp('cltID', 'client', $entityInfo['cltID'])['cltPfpName'] ?>" alt="Profile picture">
                        <?php else : ?>
                            <img src="<?php echo getImage('client.png') ?>" alt="Client Pfp">
                        <?php endif; ?>
                    <?php elseif ($adminLoggedIn) : ?>
                        <?php if (strlen($entityInfo['admPfpName']) > 0) : ?>
                            <img src="../img/pfp/<?php echo getPfp('admID', 'admin', $entityInfo['admID'])['admPfpName'] ?>" alt="Profile picture">
                        <?php else : ?>
                            <img src="<?php echo getImage('client.png') ?>" alt="Client Pfp">
                        <?php endif; ?>
                    <?php endif; ?>
                    <div id="profile-pfp-overlay">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div id="profile-pfp-overlay-div">
                                <label for="profile-upload-pfp-input"><?php echo $languageList["Select Image"] ?>
                                    <input id="profile-upload-pfp-input" type="file" name="profile-upload" value="" />
                                </label>
                                <label for="profile-submit-pfp-input"><?php echo $languageList["Upload Image"] ?>
                                    <input id="profile-submit-pfp-input" type="submit" name="profile-submit-pfp">
                                </label>
                            </div>
                        </form>
                    </div>
                <?php else : ?>
                    <img src="<?php echo getImage('client.png') ?>" alt="Profile picture">
                <?php endif; ?>
            </div>
            <div id="profile-top-div-column-2">
                <?php if ($loggedIn) : ?>
                    <?php if ($clientLoggedIn) : ?>
                        <span><?php echo $entityInfo["cltUsername"] ?></span>
                        <span><?php echo $entityInfo["cltFirstName"] . " " . $entityInfo["cltLastName"] ?></span>
                        <span><?php echo $entityInfo["cltEmail"] ?></span>
                    <?php elseif ($adminLoggedIn) : ?>
                        <span><?php echo $entityInfo["admUsername"] ?></span>
                        <?php if (strlen($entityInfo['admFirstName'] && strlen($entityInfo['admLastName']))) : ?>
                            <span><?php echo $entityInfo["admFirstName"] . " " . $entityInfo["admLastName"] ?></span>
                        <?php endif; ?>
                        <span><?php echo $entityInfo["admEmail"] ?></span>
                    <?php endif; ?>
                <?php else : ?>
                    <span><?php echo $languageList["Your account"] ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div id="profile-bottom-div">
            <?php if ($clientLoggedIn || !$loggedIn) : ?>
                <a href="<?php restrictedAdminPage('../php-pages/devices.php') ?>"><span><?php echo $languageList["Devices"] ?></span></a>
                <a href="<?php restrictedAdminPage('../php-pages/order-history.php') ?>"><span><?php echo $languageList["Order History"] ?></span></a>
                <a href="<?php restrictedAdminPage('../php-pages/payment-method.php') ?>"><span><?php echo $languageList["Payment Method"] ?></span></a>
                <a href="<?php restrictedAdminPage('../php-pages/address.php') ?>"><span><?php echo $languageList["Addresses"] ?></span></a>
            <?php elseif ($adminLoggedIn) : ?>
                <a href="../php-pages/manage-user.php"><span><?php echo $languageList["Manage Users"] ?></span></a>
                <a href="assistance-manage.php"><span><?php echo $languageList["Answer Questions"] ?></span></a>
                <!--            <a href="#"><span>Gérer les données</span></a>-->
            <?php endif; ?>
            <a href="<?php restrictedNoUserPage('../php-pages/connection-security.php') ?>"><span><?php echo $languageList["Connection And Security"] ?></span></a>
            <a href="<?php restrictedNoUserPage('../php-pages/message-center.php') ?>"><span><?php echo $languageList["Message Center"] ?></span></a>
        </div>
    </div>

    <?php include '../php-pages/site-footer.php' ?>
    <script type="text/javascript">
        setMarginTop('sih-main-header', 'id', 'profile-main-div', 'id', 20)

        // setToWindowHeight('profile-main-div', 'id', 0)
        setMarginTopFooter('profile-main-div', 'id', 'site-footer-main-div', 'id', 0)
    </script>

</body>

</html>