<?php
session_start();
include '../php-processes/dbConnection.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

onlyAdminPage();

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(!empty($_GET['getMessages'])) {
        header("Content-Type: application/json");
        echo json_encode(["lastMessagesList" => returnLastMessagesList($_GET['getMessages'])]);
    }

    if(!empty($_GET['sessionMessages'])) {

        $sesMsgID = $_GET['sesMsgID'];
        $sessionMessagesList = returnSessionMessages($sesMsgID);

        header("Content-Type: application/json");
        echo json_encode(["sessionMessagesList" => $sessionMessagesList]);
    }


}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['sesMsgID']) && !empty($_POST['markResolved'])) {
        $sesMsgID = $_POST['sesMsgID'];

        $resolvedID = generateID(10);

        $updateSessionMessageSql = "UPDATE session_message 
                                    SET sesMsgEndDate = timestamp(NOW()),
                                    sesMsgID = '".$sesMsgID."-resolved-".$resolvedID."'
                                    WHERE sesMsgID = '".$sesMsgID."'";

        runSQLQuery($updateSessionMessageSql);
    }

    if(!empty($_POST['sesMsgID']) && !empty($_POST['deleteConversation'])) {
        $sesMsgID = $_POST['sesMsgID'];

        $deleteSessionMessageSql = "DELETE FROM session_message WHERE sesMsgID = '".$sesMsgID."'";
        runSQLQuery($deleteSessionMessageSql);
    }

    if(!empty($_POST['deleteInterval'])) {
        $startDate = date($_POST['startDate']);
        $endDate = date($_POST['endDate']);
        $sesMsgDate = $_POST['sesMsgDate'];

        $deleteSessionMessageIntervalSql = "DELETE FROM session_message WHERE ".$sesMsgDate." between '".$startDate."' 
                                                                              AND '".$endDate."'
                                                                              AND sesMsgID LIKE '%resolved%'";
        runSQLQuery($deleteSessionMessageIntervalSql);
    }

}


