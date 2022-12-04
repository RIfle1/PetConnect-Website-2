<?php
include 'dbConnection.php';
$isInvalid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "SELECT * FROM client WHERE cltEmail = '" . $_POST["lgEmail-input"] . "'";
    $result = runSQLResult($sql);
    $client = $result->fetch_assoc();

    if ($client) {
        if (password_verify($_POST["lgPassword-input"], $client["cltPassword"])) {

            session_start();
            session_regenerate_id();
            $_SESSION["cltID"] = $client["cltID"];
            header("Location: home.php", true, 303);
            exit;

        }
    }

    $isInvalid = true;
    header('Location: login.php?isInvalid='.$isInvalid.'&lgEmail-input='.$_POST["lgEmail-input"], true, 303);
}


