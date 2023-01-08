<?php
session_start();
include_once '../php-processes/dbConnection.php';
include_once '../php-processes/login-check.php';
include_once '../php-processes/authenticity-check.php';

//header("Content-Type: application/json");


//var_dump(deObjectifyList(returnProductList('')));


//var_dump(returnBasketList());

var_dump(json_decode($_COOKIE['Basket-cookie']));

//var_dump(returnBasketList());

//print_r(json_decode($_COOKIE['Basket-cookie']));

//echo sizeof($_COOKIE['Basket-cookie']);

