<?php
session_start();
include_once '../php-processes/dbConnection.php';
include_once '../php-processes/login-check.php';
include_once '../php-processes/authenticity-check.php';

clientAndNoUserPage();

if(isset($clientLoggedIn) || isset($loggedIn)) {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $prdID = $_POST['prdID'];
        $prcColor = $_POST['prcColor'];
        $buyAmount = $_POST['buyAmount'];
        $prdLstIDList = $_POST['prdLstIDList'];

        for($index = 0; $index <  $buyAmount; $index++) {
            $prdLstID = $prdLstIDList[$index];

            if($clientLoggedIn) {
                $cltID = $_SESSION['ID'];

                $insertNewBasketSql = "INSERT IGNORE INTO basket(basID, Client_cltID) 
                                   VALUES ('".$cltID."', '".$cltID."')";
                runSQLQuery($insertNewBasketSql);

                $insertProductSql = "INSERT INTO product_list(prdLstID, prcColor, Product_prdID, Basket_basID) 
                                 VALUES ('".$prdLstID."', '".$prcColor."', '".$prdID."', '".$cltID."')";
                runSQLQuery($insertProductSql);
            }
        }

        if(!$loggedIn) {
            for($index = 0; $index <  $buyAmount; $index++) {
                $addedBasketProductList[] = array($prdID, $prcColor);
            }
            if(!isset($_COOKIE['Basket-cookie'])) {
                setcookie("Basket-cookie", json_encode($addedBasketProductList),
                    [
                        'expires' => time() + (86400 * 30),
                        'path' => '/',
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'None',
                    ]);
            }
            else {
                $previousBasketList = json_decode($_COOKIE['Basket-cookie']);
                foreach ($previousBasketList as $previousBasketListItem) {
                    $newBasketList[] = $previousBasketListItem;
                }
                foreach ($addedBasketProductList as $addedBasketProductListItem) {
                    $newBasketList[] = $addedBasketProductListItem;
                }

                setcookie("Basket-cookie", json_encode($newBasketList),
                    [
                        'expires' => time() + (86400 * 30),
                        'path' => '/',
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'None',
                    ]);
            }
        }
    }
}
