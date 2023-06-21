<?php
session_start();
include_once '../php-processes/dbConnection.php';
include_once '../php-processes/login-check.php';
include_once '../php-processes/authenticity-check.php';

//header("Content-Type: application/json");

//var_dump(returnProductList('prd1'));

//var_dump(returnDevicesList());

//var_dump(returnMiscImgList());

//var_dump(returnBasketList());

//var_dump(json_decode($_COOKIE['Basket-cookie']));?

//var_dump(returnBasketList());

//print_r(json_decode($_COOKIE['Basket-cookie']));

//echo sizeof($_COOKIE['Basket-cookie']);

//var_dump(returnAssistanceList('', ''));

//var_dump(returnDevicesList('dev1'));

//echo $_SERVER['SCRIPT_NAME'];

//echo $_SERVER['REQUEST_URI'];

//generateDeviceData('dev1', 10);

//echo getPfp('cltID', 'client', $_SESSION['ID']);

var_dump(returnEntityList('client', 'ASC', 'cltUsername'));