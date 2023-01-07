<?php
include 'dbConnection.php';
session_start();
$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

onlyAdminPage();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if($_POST['buttonName'] === 'delete-button') {
        $sql = "DELETE FROM ".$_POST['entity']." WHERE ".$_POST['entityIDAttribute']." = '".$_POST['entityID']."'";
        runSQLResult($sql);
    }elseif($_POST['buttonName'] === 'promote-button' && $_POST['entity'] === 'client') {
        $sql='';
        if(isModerator($_POST['entityID'])) {
            $sql = "UPDATE client SET cltIsModerator = 0 WHERE cltID = '".$_POST['entityID']."'";
        }elseif(!isModerator($_POST['entityID'])) {
            $sql = "UPDATE client SET cltIsModerator = 1 WHERE cltID = '".$_POST['entityID']."'";
        }
        runSQLResult($sql);
    }
//    elseif(!empty($_POST['submit-button'])) {
//
//    }
}
