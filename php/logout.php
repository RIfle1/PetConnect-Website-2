<?php

session_start();
session_destroy();

header('Location: home.php', true, 303);

