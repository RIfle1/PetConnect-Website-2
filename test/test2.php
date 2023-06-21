<?php
include '../php-processes/dbConnection.php';

$json = file_get_contents("../php-processes/address-process.php");
$addressInfo = json_decode($json);
echo $addressInfo;

