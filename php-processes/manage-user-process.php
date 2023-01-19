<?php
include 'dbConnection.php';
session_start();
onlyAdminPage();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if($_POST['type'] === 'delete') {
        $sql = "DELETE FROM ".$_POST['table']." WHERE ".$_POST['entityIDAttribute']." = '".$_POST['entityID']."'";
        runSQLQuery($sql);
    }
    elseif($_POST['type'] === 'promote') {
        $sql = '';
        if(isModerator($_POST['entityID'])) {
            $sql = "UPDATE client SET cltIsModerator = 0 WHERE cltID = '".$_POST['entityID']."'";
        }elseif(!isModerator($_POST['entityID'])) {
            $sql = "UPDATE client SET cltIsModerator = 1 WHERE cltID = '".$_POST['entityID']."'";
        }
        runSQLQuery($sql);
    }
}

