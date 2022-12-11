<?php
include 'dbConnection.php';
session_start();

if(empty($_SESSION['admID'])) {
    $_SESSION['errorMsg'] = 'You do not have access to this page, if you think this is a mistake contact the web developer';
    header("Location: restricted-access.php", true,303);
} else {
    if(!empty($_GET['sortBy'])) {
        $sql = "SELECT * FROM client ORDER BY ".$_GET['sortBy'];
    } else {
        $sql = "SELECT * FROM client";
    }
    $result = runSQLResult($sql);

    $tableRowNumber = 1;

    $clientList = array();

    while($clientInfo = $result->fetch_array()) {
        $newUserInfo = array(
            "cltID" => $clientInfo["cltID"],
            "cltUsername" => $clientInfo["cltUsername"],
            "cltFirstName" => $clientInfo["cltFirstName"],
            "cltLastName" => $clientInfo["cltLastName"],
            "cltEmail" => $clientInfo["cltEmail"],
            "cltPhoneNumber" => $clientInfo["cltPhoneNumber"],
            "cltIsModerator" => $clientInfo["cltIsModerator"],
//            "admID" => $_SESSION['admID'],
        );

        $clientList[] = $newUserInfo;
    }

    header("Content-Type: application/json");
    echo json_encode(['clientList' => $clientList]);
}
