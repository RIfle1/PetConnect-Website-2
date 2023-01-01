<?php
include_once '../php-processes/dbConnection.php';

if($_SERVER["REQUEST_METHOD"] === "GET") {
    if(!empty($_GET['file'])) {
        header("Content-Type: application/json");
        echo json_encode(["languageList" => returnLanguageList()[returnLanguage()][$_GET['file']]]);
    }
    if(!empty($_GET['language'])) {
        header("Content-Type: application/json");
        echo json_encode(["language" => returnLanguage()]);
    }
}
