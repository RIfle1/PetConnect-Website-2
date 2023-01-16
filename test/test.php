<?php

$prdID = 'prd1';
$prcColor = 'white';

$cookieBasketList = json_decode($_COOKIE['Basket-cookie']);
$removeProduct = true;

$prdID = 'prd1';
$prdColor = 'black';
$buyAmount = 2;

for($index = 0; $index <  $buyAmount; $index++) {
    $addedBasketProductList[] = array($prdID, $prcColor);
}
if(!isset($_COOKIE['Basket-cookie'])) {
    setcookie("Basket-cookie", json_encode(array($addedBasketProductList)),
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


var_dump(json_decode($_COOKIE['Basket-cookie']));