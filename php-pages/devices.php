<?php
session_start();
include '../php-processes/dbConnection.php';
clientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['connection-security'];

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

    <title>PetConnect Connection and Security</title>
</head>

<body>



    <main>
        <div id="ds-form-body" class="text-font-500">
            <lien><a href="profile.php">Compte</a>><a id="actif" href="">Gérer mes appareils</a></lien>
            <section id="g_appareils">
                <h2>Mes appareils</h2>
                <?php
                if (isset($_GET['login_err'])); {
                    $err = htmlspecialchars($_GET['reg_err']);


                    switch ($err) {
                        case 'success':
                ?>
                            <div class="alert alert-success">
                                <strong>Succès</strong> Appareil ajouté
                            </div>

                        <?php
                            break;

                        case 'already':
                        ?>
                            <div class="alert">
                                <strong>Erreur</strong> appareil déja associé
                            </div>
                        <?php
                            break;
                        case 'suppr':
                        ?>
                            <div class="alert alert-success">
                                <strong>Succès</strong> Appareil supprimé
                            </div>

                <?php
                            break;
                    }
                }
                ?>
                <?php foreach ($dataApp as $app) :
                ?>
                    <div id="appareil">
                        <div id=contour>
                            <div>
                                <p>iCollar Max</p>
                            </div>
                            <ul>
                                <li id="produit">
                                    <img src="images/iCollar_blanc2.png" />

                                </li>
                                <li class="contour">
                                    <img src="images/fonc/heart.png" />
                                    <p>Bon</p>
                                </li>
                                <li class="contour">
                                    <img src="images/fonc/co2.png" />
                                    <p>Bon</p>
                                </li>
                                <li class="contour therm">
                                    <img src="images/fonc/thermo.png" />
                                    <p>Bon</p>
                                </li>
                                <li>
                                    <a href="info_appareil.php">Plus d'informations</a>
                                </li>
                                <form action=" ../controller/gerer_mes_apps_traitement.php" method="post">
                                    <button name="suppr" value="<?php echo $app["appID"] ?>">supprimer</button>
                                </form>
                            </ul>

                        </div>
                    <?php endforeach; ?>
            </section>
            <form action=" ../controller/gerer_mes_apps_traitement.php" method="post">
                <input type="text" name="ajouter" placeholder="Numéro du collier" required>
                <input type="submit" value="Ajouter">
            </form>
            <?php if (!empty($_POST["ajouter"])) {
            ?>


            <?php
            }
            ?>
        </div>
    </main>



    <?php include 'site-footer.php' ?>

    <script type="text/javascript">
        setMarginTop('site-header-main-header', 'id', 'ds-form-body', 'id', 40)
    </script>

    <script src="../javaScript/connection-security-buttons.js"></script>

</body>

</html>