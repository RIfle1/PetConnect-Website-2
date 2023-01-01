<?php

include '../php-processes/dbConnection.php';

$language = '';

if(empty($_GET['lang'])) {
    $language = 'English';
}
else {
    $language = $_GET['lang'];
}

$languageList = returnLanguageList();

$languageListKeys = array_keys($languageList);

//var_dump($languageList);

for ($i = 0; $i < sizeof($languageListKeys); $i++) {
    echo $languageListKeys[$i];
}

//print_r(array_keys($languageList));

//header("Content-Type: application/json");
//echo json_encode(["processValues" => $languageList]);
