<?php
include 'dbConnection.php';
session_start();
$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

if($clientLoggedIn || !$loggedIn || !$adminLoggedIn) {
    $_SESSION['errorMsg'] = 'You do not have access to this page, if you think this is a mistake contact the web developer';
    header("Location: ../php-pages/restricted-access.php", true,303);
}
elseif ($_SERVER["REQUEST_METHOD"] === "POST") {

    if($_POST['buttonClass'] === 'delete-button-id') {
        $sql = "DELETE FROM client WHERE cltID = '".$_POST['cltID']."'";
        runSQLResult($sql);
    }elseif($_POST['buttonClass'] === 'promote-button-id') {
        $sql='';
        if(isModerator($_POST['cltID'])) {
            $sql = "UPDATE client SET cltIsModerator = 0 WHERE cltID = '".$_POST['cltID']."'";
        }elseif(!isModerator($_POST['cltID'])) {
            $sql = "UPDATE client SET cltIsModerator = 1 WHERE cltID = '".$_POST['cltID']."'";
        }
        runSQLResult($sql);
    }
//    elseif(!empty($_POST['submit-button'])) {
//
//    }
}
