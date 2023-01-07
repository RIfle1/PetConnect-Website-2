<?php
session_start();
include '../php-processes/dbConnection.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

onlyAdminPage();

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(!empty($_GET['getMessages']) && $_GET['getMessages'] === 'message') {
        $getActiveMessagesSql = "SELECT DISTINCT cltID, cltUsername FROM client
                             INNER JOIN client_message cm on client.cltID = cm.Client_cltID
                             INNER JOIN session_message sm on cm.Session_Message_sesMsgID = sm.sesMsgID
                             WHERE sesMsgEndDate is null 
                             ORDER BY sesMsgStartDate";

        $activeMessagesResult = runSQLResult($getActiveMessagesSql);

        if(mysqli_num_rows($activeMessagesResult) > 0) {
            while($activeMessages = $activeMessagesResult->fetch_assoc()) {
                $sesMsgID = $activeMessages['cltID'];

                $sessionMessages = returnSessionMessages($sesMsgID);
                $lastSessionMessage = end($sessionMessages[$sesMsgID]);

                $activeMessagesList[] = array(
                    'cltID' => $activeMessages['cltID'],
                    'cltUsername' => $activeMessages['cltUsername'],

                    'username' => $lastSessionMessage['username'],
                    'msgMessage' => $lastSessionMessage['msgMessage'],
                    'msgDate' => $lastSessionMessage['msgDate'],
                );
            }
        }
        else {
            $activeMessagesList = array();
        }

        header("Content-Type: application/json");
        echo json_encode(["lastMessagesList" => $activeMessagesList]);
    }

    if(!empty($_GET['getMessages']) && $_GET['getMessages'] === 'resolved') {
        $getResolvedMessagesSql = "SELECT DISTINCT sesMsgID, sesMsgStartDate ,sesMsgEndDate, cltUsername  FROM session_message 
                                   LEFT JOIN client_message cm on session_message.sesMsgID = cm.Session_Message_sesMsgID
                                   LEFT JOIN client c on cm.Client_cltID = c.cltID
                                   WHERE sesMsgID LIKE '%resolved%'
                                   ORDER BY sesMsgEndDate";

        $resolvedMessagesResult = runSQLResult($getResolvedMessagesSql);

        if(mysqli_num_rows($resolvedMessagesResult) > 0) {
            while($resolvedMessages = $resolvedMessagesResult -> fetch_assoc()) {

//                $sessionMessages = returnSessionMessages($resolvedMessages['sesMsgID']);
//                $lastSessionMessage = end($sessionMessages);

                $resolvedMessagesList[] = array(
                    'sesMsgID' => $resolvedMessages['sesMsgID'],
                    'cltUsername' => $resolvedMessages['cltUsername'],
                    'sesMsgEndDate' => $resolvedMessages['sesMsgEndDate'],
                    'sesMsgStartDate' => $resolvedMessages['sesMsgStartDate'],

//                    'username' => $lastSessionMessage['username'],
//                    'msgMessage' => $lastSessionMessage['msgMessage'],
//                    'msgDate' => $lastSessionMessage['msgDate'],
                );
            }
        }
        else {
            $resolvedMessagesList = array();
        }

        header("Content-Type: application/json");
        echo json_encode(["lastMessagesList" => $resolvedMessagesList]);
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

        runSQLResult($updateSessionMessageSql);
    }

    if(!empty($_POST['sesMsgID']) && !empty($_POST['deleteConversation'])) {
        $sesMsgID = $_POST['sesMsgID'];

        $deleteSessionMessageSql = "DELETE FROM session_message WHERE sesMsgID = '".$sesMsgID."'";
        runSQLResult($deleteSessionMessageSql);
    }

    if(!empty($_POST['deleteInterval'])) {
        $startDate = date($_POST['startDate']);
        $endDate = date($_POST['endDate']);
        $sesMsgDate = $_POST['sesMsgDate'];

        $deleteSessionMessageIntervalSql = "DELETE FROM session_message WHERE ".$sesMsgDate." between '".$startDate."' 
                                                                              AND '".$endDate."'
                                                                              AND sesMsgID LIKE '%resolved%'";
        runSQLResult($deleteSessionMessageIntervalSql);
    }

}


