<?php
include 'dbConnection.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if($_POST['buttonClass'] === 'delete-button-id') {
        $sql = "DELETE FROM client WHERE cltID = '".$_POST['cltID']."'";
        runSQLResult($sql);
    }elseif($_POST['buttonClass'] === 'promote-button-id') {
        if(isModerator($_POST['cltID'])) {
            $sql = "UPDATE client SET cltIsModerator = 0 WHERE cltID = '".$_POST['cltID']."'";
        }elseif(!isModerator($_POST['cltID'])) {
            $sql = "UPDATE client SET cltIsModerator = 1 WHERE cltID = '".$_POST['cltID']."'";
        }
        runSQLResult($sql);
    }elseif(!empty($_POST['submit-button'])) {

    }
}
