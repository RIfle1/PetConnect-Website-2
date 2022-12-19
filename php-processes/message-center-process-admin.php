<?php
session_start();
include '../php-processes/dbConnection.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

//adminPage();
//$entityInfo = returnEntityInfo();

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(!empty($_GET['activeMessages'])) {
        $getActiveMessagesSql = "SELECT DISTINCT cltID, cltUsername FROM client
                             INNER JOIN client_message cm on client.cltID = cm.Client_cltID
                             INNER JOIN session_message sm on cm.Session_Message_sesMsgID = sm.sesMsgID
                             WHERE sesMsgEndDate is null";

        $ActiveMessagesResult = runSQLResult($getActiveMessagesSql);

        if(mysqli_num_rows($ActiveMessagesResult) > 0) {
            while($ActiveMessages = $ActiveMessagesResult->fetch_assoc()) {
                $ActiveMessagesList[] = array(
                    'cltID' => $ActiveMessages['cltID'],
                    'cltUsername' => $ActiveMessages['cltUsername']
                );
            }
        }
        else {
            $ActiveMessagesList = array();
        }

        header("Content-Type: application/json");
        echo json_encode(["activeMessagesList" => $ActiveMessagesList]);
    }

    if(!empty($_GET['sessionMessages'])) {
        $sesMsgID = $_GET['cltID'];
        $sessionMessagesList = returnMessagesSessionList($sesMsgID);

        header("Content-Type: application/json");
        echo json_encode(["sessionMessagesList" => $sessionMessagesList]);
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['sesMsgID']) && !empty($_POST['markResolved'])) {
        $sesMsgID = $_POST['sesMsgID'];

        $resolvedID = generateID(2);

        $updateSessionMessageSql = "UPDATE session_message 
                                    SET sesMsgEndDate = timestamp(NOW()),
                                    sesMsgID = '".$sesMsgID."-resolved-".$resolvedID."'
                                    WHERE sesMsgID = '".$sesMsgID."'";

        runSQLResult($updateSessionMessageSql);
    }
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {

    if(!empty($_GET['sesMsgID']) && !empty($_GET['deleteConversation'])) {
        $sesMsgID = $_GET['sesMsgID'];

        $deleteSessionMessageSql = "DELETE FROM session_message WHERE sesMsgID = '".$sesMsgID."'";
        echo $deleteSessionMessageSql;
        runSQLResult($deleteSessionMessageSql);
    }
}

//
//header("Content-Type: application/json");
//echo json_encode(["sessionMessagesList" => returnMessagesSessionList('clt19')]);