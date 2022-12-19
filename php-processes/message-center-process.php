<?php
session_start();
include '../php-processes/dbConnection.php';

$clientLoggedIn = $_SESSION['clientLoggedIn'];
$adminLoggedIn = $_SESSION['adminLoggedIn'];
$loggedIn = $_SESSION['loggedIn'];

clientPage();
$entityInfo = returnEntityInfo();


if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(!empty($_GET['userInfo'])) {

        $entityInfo['ID'] = $_SESSION['ID'];

        header("Content-Type: application/json");
        echo json_encode(["entityInfo" => $entityInfo]);
    }

    if(!empty($_GET['sessionMessages'])) {

        if($_SESSION['ID'] === 'client') {
            $sesMsgID = $_SESSION['cltID'];
        }
        elseif($_SESSION['ID'] === 'admin') {
            $sesMsgID = $_GET['sesMsgID'];
        }

        $sessionMessagesList = returnMessagesSessionList($sesMsgID);

        header("Content-Type: application/json");
        echo json_encode(["sessionMessagesList" => $sessionMessagesList]);
    }
}


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['msgMessage'])) {
        $IDLetters = $_POST['IDLetters'];
        $ID = $_POST['ID'];
        $entityID = $_POST['entityID'];
        $msgMessage = $_POST['msgMessage'];
        $newMsgID = autoSetID($IDLetters.'MsgID',$ID.'_message',$IDLetters.'Msg');
        $entityForeignKey = $ID."_".$IDLetters."ID";

        $cltID = '';

        if($ID === 'client') {
            $cltID = $entityID;
            $insertMessageInNewSessionSql = "INSERT IGNORE INTO session_message (sesMsgID) VALUES ('".$cltID."')";
            runSQLResult($insertMessageInNewSessionSql);
        }
        elseif($ID === 'admin') {
            $cltID = $_POST['cltID'];
        }

        $insertNewMessageSql = "INSERT INTO ".$ID."_message (".$IDLetters."MsgID, ".$IDLetters."MsgMessage, ".$entityForeignKey.", Session_Message_sesMsgID)
                            VALUES ('".$newMsgID."','".$msgMessage."','".$entityID."', '".$cltID."')";
        runSQLResult($insertNewMessageSql);
//        echo $insertNewMessageSql;
    }
}

