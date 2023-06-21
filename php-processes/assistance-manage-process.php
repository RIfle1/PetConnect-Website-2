<?php
include 'dbConnection.php';
session_start();
onlyAdminPage();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $astID = $_POST['astID'];
    if($_POST['type'] === 'save') {
        $astQuestion = $_POST['astQuestion'];
        $astAnswer = $_POST['astAnswer'];

        $saveAssistanceSql = "UPDATE assistance SET 
                            astQuestion = '".$astQuestion."', 
                            astAnswer = '".$astAnswer."'
                            WHERE astID = '".$astID."'";

        runSQLQuery($saveAssistanceSql);
    }
    else if($_POST['type'] === 'switch') {
        $getPreviousAssistanceApprovedSql = "SELECT astApproved FROM assistance WHERE astID = '".$astID."'";
        $previousAssistanceApprovedResult = runSQLQuery($getPreviousAssistanceApprovedSql)->fetch_assoc();
        $previousAssistanceApproved = intval($previousAssistanceApprovedResult['astApproved']);

        $insertNewAssistanceApprovedSql = "UPDATE assistance SET astApproved = '".!$previousAssistanceApproved."' WHERE astID = '".$astID."'";
        runSQLQuery($insertNewAssistanceApprovedSql);
    }
    else if($_POST['type'] === 'delete') {
        $deleteAssistanceSql = "DELETE FROM assistance WHERE astID = '".$astID."'";
        runSQLQuery($deleteAssistanceSql);
    }
}
