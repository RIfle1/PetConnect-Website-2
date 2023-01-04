<?php

include '../php-processes/dbConnection.php';


$sql = "SELECT * FROM client";

$result = runSQLResult($sql);

while($result2 = $result->fetch_assoc()) {
    echo $result2['cltFirstName']."<br>";
}

$stupid;



if($stupid) {
    die();
}


