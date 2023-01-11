<?php

$language = $_POST['language-button'];
setcookie("language-cookie", $language, time() + (86400 * 30), "/"); // 86400 = 1 day



header("Location: ".$_GET['page'], true, 303);

