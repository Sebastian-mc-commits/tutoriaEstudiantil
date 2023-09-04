<?php

$type = isset($_GET["type"]) ? $_GET["type"] : null;

if (empty($type) || $_SERVER["PHP_METHOD"] != "POST") {
    header("Location: ../index.php");
    exit;
}

switch ($type) {
    case "signUp": {
        //Aqui
        break;
    }
    case "logIn": {
        break;
    }

    default: 
    break;
}

header("Location: ../views/home.php");
exit;