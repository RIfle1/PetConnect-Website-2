<?php
function OpenCon()
{
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $db = "app db";
    $conn = new mysqli($dbHost, $dbUser, $dbPass,$db) or die("Connect failed: %s\n". $conn -> error);

    if ($conn->connect_errno) {
        die("Connection Error: " . $conn->connect_error);
    }
    else {
        return $conn;
    }
}

function CloseCon($conn): void
{
    $conn->close();
}

function runSQLResult($query) : bool|mysqli_result
{
    $conn = OpenCon();
    $result = mysqli_query($conn, $query);
    CloseCon($conn);
    return $result;
}

function insertSQL($sql): string
{
    $mysqli = OpenCon();
    $stmt = $mysqli->stmt_init();

    if ( ! $stmt->prepare($sql)) {
        die("SQL Error: " . $mysqli->error);
    }

    if($stmt->execute()) {
        CloseCon($mysqli);
        return "Success";
    }
    else {
        return ($mysqli->error . " " . $mysqli->errno);
    }
}

function getImage($imgName): mysqli_result|bool
{
    $sql = "SELECT imgPath FROM image WHERE imgName = '".$imgName."'";
    return runSQLResult($sql);
}




