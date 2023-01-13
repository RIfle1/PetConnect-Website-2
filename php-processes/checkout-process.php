<?php
session_start();
include_once '../php-processes/dbConnection.php';
include_once '../php-processes/php-mailer.php';
clientAndNoUserPage();

$languageList = returnLanguageList()[returnLanguage()]['checkout-process'];

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $basketList = returnBasketList();
    $entityInfo = returnEntityInfo();
    $cltEmail = $entityInfo['cltEmail'];
    $cltFirstName = $entityInfo['cltFirstName'];
    $cltID = $_SESSION['ID'];
    $productTotal = 0;

    $subject = $languageList['Thank you for buying our products'];
    $body = '';

    foreach($basketList as $basketItemIndex => $basketItem) {
        $prdID = $basketItem['prdID'];
        $prdName = $basketItem['prdName'];
        $prcColor = $basketItem['prcColor'];
        $prdPrice = $basketItem['prdPrice'];
        $devCode = generateRandomString(3, 'upper');
        $devID = autoSetID('dev');

        $productTotal += floatval($basketItem['prdPrice']);

        $body .= "Product: ".$basketItemIndex."<br>"
            ."&emsp;"."Product Name: ".$prdName."<br>"
            ."&emsp;"."Product Color: ".$prcColor."<br>"
            ."&emsp;"."Product Price: ".$prdPrice."<br>"
            ."&emsp;"."Device Code: ".$devCode."<br>";

        $insertDeviceSql = "INSERT INTO device(devID, devCode, prdID, prcColor, Client_cltID) 
VALUES ('".$devID."', '".$devCode."', '".$prdID."', '".$prcColor."' , '".$cltID."')";
        runSQLResult($insertDeviceSql);
//        echo $insertDeviceSql."<br>";
    }

    $body .= "Your Total is: ".$productTotal."<br>";

//    echo $body;

    sendGmail($cltEmail, $cltFirstName, $body, $subject);
}


