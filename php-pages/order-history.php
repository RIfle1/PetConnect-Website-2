<?php
session_start();
include '../php-processes/dbConnection.php';
onlyClientPage();
include 'site-header.php';

$languageList = returnLanguageList()[returnLanguage()]['order-history'];

?>

<!doctype html>
<html lang="en">

<head>
    <!--    Style Sheet-->
    <link rel="stylesheet" href="../css/order-history-style.css">
    <!--    Jquery-->
    <title>Order History</title>
</head>

<body>

    <main>
        <div id="oh-form-body" class="text-font-500">
<!--            <lien><a href="profile.php">--><?php //echo $languageList["Account"] ?><!--</a>><a id="actif" href="">--><?php //echo $languageList["Order History"] ?><!--</a></lien>-->
            <section id="historique">
                <h2><?php echo $languageList["Order History"] ?></h2>
                <div id="commande">
                    <hr>
                    <div>
                        <p><?php echo $languageList["Purchase date"] ?>: XX/XX/XXXX</p>
                    </div>
                    <img src="<?php echo getImage("iCollar_v1_white.png") ?>" />
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
        setMarginTop('sih-main-header', 'id', 'oh-form-body', 'id', 20)

        // setToWindowHeight('profile-main-div', 'id', 0)
        setMarginTopFooter('oh-form-body', 'id', 'site-footer-main-div', 'id', 0)
    </script>


</body>

</html>