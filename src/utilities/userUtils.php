<?php

namespace Utils\UserUtils;

use UserModel\User;

function isAuthenticated($redirect = true)
{
    $user = new User();
    $existUser = isset($_SESSION["user"]);
    if ($existUser && $redirect && $user->getUser() != null) {
        header("Location: ./index.php?page=home");
        exit;
    }

    return $existUser;
}

function isNotAuthenticated($redirect = true)
{
    $user = new User();
    $userNotExist = !isset($_SESSION["user"]);

    if ($userNotExist && $redirect || $user->getUser() == null) {
        session_destroy();
        header("Location: ./index.php?page=auth");
        exit;
    }

    return $userNotExist;
}

function setUserSession($userFields)
{
    $_SESSION["user"] = $userFields;
}

function getUserSession()
{
    return isset($_SESSION["user"]) ? $_SESSION["user"] : null;
}
