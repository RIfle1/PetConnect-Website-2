<?php
include_once '../php-processes/dbConnection.php';
onlyClientPage();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['devID']) && !empty($_POST['newDevName'])) {
        $devID = $_POST['devID'];
        $newDevName = $_POST['newDevName'];

        $changeDevNameSql = "UPDATE device SET devName = '".$newDevName."' WHERE devID = '".$devID."'";
        runSQLQuery($changeDevNameSql);
    }
}

