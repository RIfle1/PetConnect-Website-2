<?php
include '../php-processes/dbConnection.php';

include 'php-mailer.php';

clientPage();
if (isset($_POST["addBasket"]) or isset($_POST["buy"])) {

    $cltID = $_SESSION["ID"];
    $newBasID = autoSetID($IDLetters . 'Bas');

    $insertBasket = "INSERT INTO Basket(basID, Client_cltID) VALUES('" . $newBasID . "', '" . $cltID . "')";
    echo $insertBasket;

    runSQLResult($insertBasket);

    $newLstID = autoSetID($IDLetters . 'Lst');

    $color = $_POST["addBasket"];
    echo $color;
    if ($color == "white") {
        $PrdID = "PRD_1";
    } elseif ($color == "black") {
        $PrdID = "PRD_2";
    } elseif ($color == "yellow") {
        $PrdID = "PRD_3";
    } elseif ($color == "pink") {
        $PrdID = "PRD_4";
    } elseif ($color == "green") {
        $PrdID = "PRD_5";
    } else {
        $PrdID = "PRD_6";
    }

    $insertList = "INSERT INTO Product_List(prdLstID, Product_prdID, Basket_basID) VALUES('" . $newLstID . "', '" . $PrdID . "','" . $newBasID . "')";
    echo $insertList;

    runSQLResult($insertList);

    if (isset($_POST["addBasket"])) {
        header('Location:../php-pages/shop.php');
        die();
    } else {
        header('Location:../php-pages/payment.php');
    }
}

if (isset($_POST["suppr"])) {

    $cltID = $_SESSION["ID"];


    $deleteBasket = " DELETE Product_list,Basket FROM Basket INNER JOIN Product_List ON (Basket.basID = Product_List.Basket_basID) WHERE Client_cltID ='" . $cltID . "'";

    // echo $deleteBasket;
    runSQLResult($deleteBasket);

    header('Location:../php-pages/shop.php');
    exit;
}




if (isset($_POST["pay"])) {
    $cltID = $_SESSION["ID"];
    $deviceCode = generateVerificationCode();
    $entityInfo = returnEntityInfo();
    $cltEmail = $entityInfo["cltEmail"];
    $cltFirstName = $entityInfo["cltFirstName"];
    $body = returnEmailCodeDeviceStructure($deviceCode)["body"];
    $subject = returnEmailCodeDeviceStructure($deviceCode)["subject"];
    echo "pay";



    if (sendGmail($cltEmail, $cltFirstName, $body, $subject)) {
        echo "payme";

        $insertDevice = "INSERT INTO Device(devID, Client_cltID) VALUES('" . $deviceCode . "', '" . $cltID . "')";
        echo $insertDevice;
        runSQLResult($insertDevice);

        header('Location:../php-pages/payment-success.php');
        die();
    }
}
