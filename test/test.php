<?php

include '../php-processes/php-mailer.php';

$serverPort = $_SERVER['SERVER_PORT'];
$serverScriptName = $_SERVER['SCRIPT_NAME'];
//echo $serverScriptName;
// https://localhost:63342/PetConnect-Webiste-2/php-processes/password-recovery.php?cltEmail=philipe.barakat@yahoo.com&cltToken=clt13-0d04bd97856b88c85073df4cd1bafef2
$serverTest = $_SERVER['SERVER_ADDR'];
echo $serverTest;


$cltEmail='philipe.barakat@yahoo.com';
$cltToken = 'wsfgwergergijuergfuiernger';
$url = "https://localhost:".$serverScriptName."/password-recovery.php?cltEmail=".$cltEmail."&cltToken=".$cltToken;


