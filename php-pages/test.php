<?php

include '../php-processes/dbConnection.php';

//header("Content-Type: application/json");
echo json_encode([returnProductList()]);
