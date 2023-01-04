<?php
include '../php-processes/dbConnection.php';
session_start();
onlyClientPage();


if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['adrID'])) {
    $adrID = $_POST['adrID'];
    if($_POST['type'] === 'delete') {
        $deleteAddressSql = "DELETE FROM address WHERE adrID = '".$adrID."'";
        runSQLResult($deleteAddressSql);
    }
    else if($_POST['type'] === 'default') {
        $ID = $_SESSION['ID'];
        $resetDefaultAddressSql = "UPDATE address SET adrDefault = 0 WHERE Client_cltID = '".$ID."'";
        $setDefaultAddressSql = "UPDATE address SET adrDefault = 1 WHERE adrID = '".$adrID."'";
        runSQLResult($resetDefaultAddressSql);
        runSQLResult($setDefaultAddressSql);

    }
}
else if($_SERVER['REQUEST_METHOD'] === 'GET') {
    header("Content-Type: application/json");
    echo json_encode(["addressList" => returnAddressList()]);
}