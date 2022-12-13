<?php

include '../php-processes/php-mailer.php';

$serverPort = $_SERVER['SERVER_PORT'];
$serverScriptName = $_SERVER['SCRIPT_NAME'];




//echo "$serverTest<br>";

$cltEmail='philipe.barakat@yahoo.com';
$cltToken = 'wsfgwergergijuergfuiernger';
//echo 'https://localhost:63342/PetConnect-Website-2/php-pages/password-recovery.php?cltEmail=philipe.barakat@yahoo.com&cltToken=clt13-0d04bd97856b88c85073df4cd1bafef2<br>';

$serverHost= $_SERVER['HTTP_HOST'];
$serverName = explode('/', $_SERVER['SCRIPT_NAME'])[1];

$url = "https://".$serverHost."/".$serverName."/php-pages/password-reset.php?cltEmail=".$cltEmail."&cltToken=".$cltToken;
//echo $url;
$url = "https://".$serverHost."/".$serverName."/php-pages/password-reset.php?cltEmail=".$cltEmail."&cltToken=".$cltToken;
$body = "<div>We got a request from you to reset your Password!. <a href=$url>Please click this link to reset your password</a></div>";

echo $body;

