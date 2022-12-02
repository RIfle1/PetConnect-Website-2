<?php

include 'dbConnection.php';
$conn = OpenCon();

$test_query = 'SELECT cltID, cltFirstName, cltLastName FROM Client';
$result = mysqli_query($conn, $test_query);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["cltID"]. " - Name: " . $row["cltFirstName"]. " - LastName: " . $row["cltLastName"]. "<br>";
    }
} else {
    echo "0 results";
}

CloseCon($conn);

function autoSetCltID()
{
    include 'dbConnection.php';
    $conn = OpenCon();
    $idList_1 = array();
    $lastCltID = 0;

    $get_cltIDCount_query = 'SELECT cltID FROM Client';
    $result = mysqli_query($conn, $get_cltIDCount_query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            $cltIDNumberInt = idToInt($row["cltID"], "clt");
            $idList_1[] = $cltIDNumberInt;
            $lastCltID = findMax($idList_1);
        }
    }

    $get_lastCltID_query = "SELECT cltID FROM Client WHERE cltID LIKE '%".$lastCltID."'";
    $result2 = mysqli_query($conn, $get_lastCltID_query);
    if (mysqli_num_rows($result2) > 0) {
        $row2 = $result2->fetch_assoc();
        $lastCltID = $row2["cltID"];
    }
    else{
        $lastCltID = 'No Value';
    }

    CloseCon($conn);
    return $lastCltID;
}
