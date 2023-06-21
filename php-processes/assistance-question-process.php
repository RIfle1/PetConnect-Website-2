<?php
include_once '../php-processes/dbConnection.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $astQuestion = $_POST['astQuestion'];
    $astID = autoSetID('ast');

    $insertNewAssistanceSql = "INSERT INTO assistance(astID, astQuestion) VALUES ('".$astID."', '".$astQuestion."')";

    runSQLQuery($insertNewAssistanceSql);
}