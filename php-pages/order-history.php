<?php
session_start();
include '../php-processes/dbConnection.php';
clientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['order-history'];

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--    Style Sheet-->
    <link rel="stylesheet" href="../css/order-history-style.css">
    <!--    Jquery-->

    <title>PetConnect Connection and Security</title>
</head>

<body>

    <main>
        <div id="oh-form-body" class="text-font-500">
            <lien><a href="profile.php"><?php echo $languageList["Account"] ?></a>><a id="actif" href=""><?php echo $languageList["Order History"] ?></a></lien>
            <section id="historique">
                <h2><?php echo $languageList["Order History"] ?></h2>
                <div id="commande">
                    <hr>
                    <div>
                        <p><?php echo $languageList["Purchase date"] ?>: XX/XX/XXXX</p>
                    </div>
                    <img src="<?php echo getImage("iCollar_blanc2.png") ?>" />
                    <div id="specific">
                        <div>
                            <h4>1 × iCollar <br><?php echo $languageList["Color"] ?></h4>
                        </div>

                        <div class="droite">
                            <p><?php echo $languageList["Price"] ?> TTC:<strong>499,99€</strong></p>
                        </div>

                        <div class="droite">
                            <p><?php echo $languageList["Status: <strong>In transit</strong> "] ?>
                            </p>
                        </div>
                    </div>
                    <div id="fin">
                        <hr>
                    </div>

                </div>
            </section>
        </div>
    </main>

    <?php include 'site-footer.php' ?>

    <script type="text/javascript">
        setMarginTop('site-header-main-header', 'id', 'oh-form-body', 'id', 40)
    </script>

    <script src="../javaScript/connection-security-buttons.js"></script>

</body>

</html>