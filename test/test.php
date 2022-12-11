<?php
session_start();

echo $_SESSION['cltToken'];

$hostPort = $_SERVER['SERVER_PORT'];
$cltEmail = "aaaa";
$cltToken = "bbbbb";

$href = "http://localhost:".$hostPort."/password-recovery.php?cltEmail=".$cltEmail."&cltToken=".$cltToken;

$body = "We got a request from you to reset your Password!
            <a href=".$href.">Reset password</a>";

echo $body;
$serverName = $_SERVER['SERVER_PORT'];
echo $serverName;
?>