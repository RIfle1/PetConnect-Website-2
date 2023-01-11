<?php

session_start();
include_once '../php-processes/dbConnection.php';
include_once '../php-processes/login-check.php';
include_once '../php-processes/authenticity-check.php';

clientAndNoUserPage();

if(isset($clientLoggedIn) || isset($loggedIn)) {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        if($_POST['type'] === 'delete') {
            $prdID = $_POST['prdID'];
            $prcColor = $_POST['prcColor'];

            if($clientLoggedIn) {
                $cltID = $_SESSION['ID'];
                $prdLstID = $_POST["prdLstID"];

                // DELETE THE PRODUCT FROM PRODUCT LIST
                $deleteProductSql = "DELETE FROM product_list WHERE prdLstID = '".$prdLstID."'";
                runSQLResult($deleteProductSql);

                // CHECK IF THERE ARE ANY PRODUCTS LEFT IN PRODUCT LIST
                $checkProductListSql = "SELECT * FROM product_list WHERE Basket_basID = '".$cltID."'";

                if(mysqli_num_rows(runSQLResult($checkProductListSql)) === 0) {
                    $removeBasketSql = "DELETE FROM basket WHERE basID = '".$cltID."'";
                    runSQLResult($removeBasketSql);
                }

            }
            else if(!$loggedIn) {
                $cookieBasketList = json_decode($_COOKIE['Basket-cookie']);
                $removeProduct = true;

                foreach ($cookieBasketList as $cookieBasketListItem) {
                    if($cookieBasketListItem[0] === $prdID && $cookieBasketListItem[1] === $prcColor && $removeProduct) {
                        $removeProduct= false;
                    }
                    else {
                        $newBasketList[] = $cookieBasketListItem;
                    }
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
        else if($_POST['type'] === 'deleteAll') {
            if($clientLoggedIn) {
                $cltID = $_SESSION['ID'];

                // DELETE THE BASKET
                $deleteBasketSql = "DELETE FROM basket WHERE basID = '".$cltID."'";
                runSQLResult($deleteBasketSql);
            }
            else if(!$loggedIn) {
                setcookie("Basket-cookie", "", [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'None',
                ]);
            }
        }


    }
}
