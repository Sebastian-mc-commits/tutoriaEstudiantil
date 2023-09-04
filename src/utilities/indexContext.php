<?php

namespace Context\App\Functions;

function buildQueryParams($queryParams = null, $avoidQuery = '')
{
    $hasParams = true;

    if ($queryParams == null) {
        $hasParams = false;
    }
    if (!empty($avoidQuery) && isset($queryParams[$avoidQuery])) {
        unset($queryParams[$avoidQuery]);
    }

    $queryString = "";

    if ($hasParams) {
        $queryString = http_build_query($queryParams);
    }

    $queryString = !empty($queryString) ? '?' . $queryString : '';
    return [
        'params' => $queryString,
        'hasParams' => $hasParams
    ];
}

function navigation($route, $queryParams = null, $tree = null)
{
    ["params" => $buildParams, "hasParams" => $hasParams] = buildQueryParams($queryParams);

    $view = "index.php" . ($hasParams ? $buildParams . "&" : "?") . "page=$route";

    if (isset($tree)) {
        $view .= "&tree=$tree";
    }

    return $view;
}

function navigateController($controllerName, $params = null)
{
    ["params" => $newParams] = buildQueryParams($params);
    return "../controllers/$controllerName.php$newParams";
}
