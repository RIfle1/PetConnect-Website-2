<?php
session_start();
include '../php-processes/dbConnection.php';
onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['devices'];

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--    Style Sheet-->
    <link rel="stylesheet" href="../css/devices-styles.css">
    <!--    Jquery-->

    <title>Devices</title>
</head>

<body>



    <main>
        <div id="ds-form-body" class="text-font-500">
            <lien><a href="profile.php"><?php echo $languageList["Account"] ?></a>><a id="actif" href=""><?php echo $languageList["My devices"] ?></a></lien>
            <section id="g_appareils">
                <h2><?php echo $languageList["My devices"] ?></h2>
                <?php
                if (isset($_GET['reg_err'])); {
                    $err = htmlspecialchars($_GET['reg_err']);
                    switch ($err) {
                        case 'success':
                ?>
                            <div class="alert alert-success">
                                <strong><?php echo $languageList["Success "] ?></strong> <?php echo $languageList["Device added"] ?>
                            </div>

                        <?php
                            break;

                        case 'already':
                        ?>
                            <div class="alert">
                                <strong><?php echo $languageList["Error "] ?></strong> <?php echo $languageList["Device already associated"] ?>
                            </div>
                        <?php
                            break;


                        case 'wrong':
                        ?>
                            <div class="alert">
                                <strong><?php echo $languageList["Error "] ?></strong> <?php echo $languageList["Wrong number"] ?>
                            </div>
                        <?php
                            break;
                        case 'suppr':
                        ?>
                            <div class="alert alert-success">
                                <strong><?php echo $languageList["Success "] ?></strong><?php echo $languageList["Deleted device"] ?>
                            </div>

                <?php
                            break;
                    }
                }
                ?>
                <?php
                $cltID = $_SESSION["ID"];
                $selectCheckDevices = runSQLResult("SELECT * FROM Device WHERE Client_cltID ='" . $cltID . "' AND devAdd = 1");
                while ($check = $selectCheckDevices->fetch_assoc()) {
                ?>
                    <div id="appareil">
                        <div id=contour>
                            <div>
                                <p>iCollar</p>
                            </div>
                            <ul>
                                <li id="produit" class="contour">
                                    <img src="<?php echo getImage("iCollar_blanc2.png") ?>" />

                                </li>
                                <li class="contour">
                                    <img src="<?php echo getImage("heart.png") ?>" />
                                    <p><?php echo $languageList["Good"] ?></p>
                                </li>
                                <li class="contour">
                                    <img src="<?php echo getImage("co2.png") ?>" />
                                    <p><?php echo $languageList["Good"]  ?></p>
                                </li>
                                <li class="contour">
                                    <img src="<?php echo getImage("thermo.png") ?>" />
                                    <p><?php echo $languageList["Good"]  ?></p>
                                </li>
                                <li>
                                    <a href="info-device.php"><?php echo $languageList["See more"]  ?></a>
                                </li>
                                <form action=" ../php-processes/devices-process.php" method="post">
                                    <button name="deleteDevice" value="<?php echo $check["devID"] ?>"><?php echo $languageList["delete"]  ?></button>
                                </form>
                            </ul>

                        </div>

                    <?php } ?>
            </section>
            <form action=" ../php-processes/devices-process.php" method="post">
                <input type="text" name="deviceNumber" placeholder="<?php echo $languageList["Collar number"]  ?>" required>
                <input type="submit" value="<?php echo $languageList["Add"]  ?>" name="addDevice">
            </form>

        </div>
    </main>



    <?php include 'site-footer.php' ?>

    <script type="text/javascript">
        setMarginTop('site-header-main-header', 'id', 'ds-form-body', 'id', 40)
    </script>

    <script src="../javaScript/connection-security-buttons.js"></script>

</body>

</html>