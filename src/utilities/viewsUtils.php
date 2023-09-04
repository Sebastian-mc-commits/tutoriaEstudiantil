<?php
namespace ViewsHelpers;

function secureView($params = null, $tree = "")
{
    $areNeedItParamsSet = true;

    if (!empty($params)) {
        ["method" => $method, "allowParams" => $allowParams] = $params;
        $newMethod = $method == "GET" ? $_GET : $_POST;

        foreach ($allowParams as $allowParam) {
            if (!isset($newMethod[$allowParam])) {
                $areNeedItParamsSet = false;
                break;
            }
        }

    }
    if (getCurrentView() !== "index.php" || !isset($_GET['page']) || !$areNeedItParamsSet) {
        header("Location: $tree" . "index.php?page=auth");
    }
}

$isSet = fn($var) => isset($var) ? $var : null;

function getCurrentView()
{
    $path = explode("/", $_SERVER["PHP_SELF"]);

    return $path[count($path) - 1];
};

function redirectIfNotPost($targetPage = 'home', $tree = "../views/")
{
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: " . $tree . "index.php?page=$targetPage");
        exit;
    }
}
