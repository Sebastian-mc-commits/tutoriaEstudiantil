<?php

require "../utilities/viewsUtils.php";
require_once "../models/User.php";
require_once "../utilities/userUtils.php";

use Utils\UserUtils;

session_start();
$type = isset($_GET["type"]) ? $_GET["type"] : "";
$userInstance = new UserModel\User();

switch ($type) {
    case "signUp":
        ViewsHelpers\redirectIfNotPost();
        ["hasError" => $hasError, "result" => $result] = $userInstance->createAndGet($userInstance->email, $_POST);

        $redirectPage = "auth";
        if (!$hasError) {
            $redirectPage = "home";
            UserUtils\setUserSession($result);
        }

        header("Location: ../views/index.php?page=$redirectPage");
        exit;

    case "logIn":{
            [$userInstance->email => $email, $userInstance->password => $password] = $_POST;
            $getUser = $userInstance->findOne([
                "where" => [
                    $userInstance->email => [$email, "equal", "and"],
                    $userInstance->password => [$password, "equal"],
                ],
            ]);

            if ($getUser) {
                echo "Here";
                UserUtils\setUserSession($getUser);
                header("Location: ../views/index.php?page=home");
                exit;
            }
            break;
        }
    case "logOut":{
            $_SESSION = array();
            session_destroy();
            break;
        }
    default:
        header("Location: ../views/index.php?page=auth");
        echo "No redirect";
        break;
}

header("Location: ../views/index.php?page=auth");
exit;
