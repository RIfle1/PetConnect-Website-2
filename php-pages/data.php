<?php
// Include the file containing the variables
$data = include 'data.php';

// Access the variables from the included file
$DB_Time = $data['DB_Time'];
$timeArray = $data['timeArray'];

// Create an associative array with the variables
$response = array(
    'DB_Time' => $DB_Time,
    'timeArray' => $timeArray
);

// Convert the array to JSON and send the response
header('Content-Type: application/json');
echo json_encode($response);
