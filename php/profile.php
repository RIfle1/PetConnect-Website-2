<?php
include 'site-header.php';
if($_SESSION) {
    $sql = "SELECT * FROM Client WHERE cltID = '".$_SESSION["cltID"]."'";
    $result = runSQLResult($sql);
    $clientInfo = $result->fetch_assoc();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
</head>
<body>

<div>
    <div>
        <div>
            <img src="#" alt="Profile picture">
        </div>
        <div>
            <?php if ($_SESSION): ?>
                <span><?php echo $clientInfo["cltUsername"] ?></span>
                <span><?php echo $clientInfo["cltFirstName"] . " " . $clientInfo["cltLastName"] ?></span>
                <span><?php echo $clientInfo["cltEmail"] ?></span>
            <?php else: ?>
                <span>Votre Compte</span>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <a href="#">Gérer mes appareils</a>
        <a href="#">Mon historique de commandes</a>
        <a href="#">Connexion et sécurité</a>
        <a href="#">Mode de paiement</a>
        <a href="#">Centre de Messagerie</a>
        <a href="#">Adresses</a>
    </div>
</div>

<?php include 'site-footer.php'?>
</body>
</html>
