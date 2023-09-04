<?php

session_start();
require "../utilities/indexContext.php";
require_once "../utilities/userUtils.php";
require_once "../models/User.php";
require_once "../utilities/viewsUtils.php";

use Utils\UserUtils;

$currentPage = isset($_GET['page']) ? $_GET['page'] : '';
$isTreeUriSet = isset($_GET["tree"]) ? $_GET["tree"] : null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoria <?php echo $currentPage; ?></title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/bar.css">
</head>

<body>

    <?php
include "bar.php";

?>
    <main class="mainStyles">

        <?php

if (!empty($isTreeUriSet) || isset($isTreeUriSet)) {
    UserUtils\isNotAuthenticated();
    require_once "../models/TutorFields.php";
    $tutorInstance = new TutorFieldsModel\TutorFields();
    switch ($isTreeUriSet) {
        case 'mentor':{
                if ($tutorInstance->getTutor() == null || empty($tutorInstance->getTutor())) {
                    header("Location: index.php?tree=user&page=user-detail");
                    break;
                }
                switch ($currentPage) {
                    case "create-class":{
                            include "mentor/create-class.php";
                            break;
                        }

                    case "created-classes":{
                            include "mentor/created-classes.php";
                            break;
                        }
                    case "render-created-class":{
                            include "mentor/render-created-class.php";
                            break;
                        }
                }
            }
        case "user":
            switch ($currentPage) {
                case "user-detail":{
                        include "user/user-detail.php";
                        break;
                    }

                case "mentor-fields":{
                        include "user/mentor-fields.php";
                        break;
                    }
                case "user-classes":{
                        include "user/user-classes.php";
                        break;
                    }
                case "class-selected":{
                        include "user/class-selected.php";
                        break;
                    }
                case "suggest-date":{
                        include "user/suggest-date.php";
                        break;
                    }
            }
    }
} else {

    switch ($currentPage) {
        case 'auth':{
                UserUtils\isAuthenticated();
                include "auth.php";
                break;
            }
        case 'home':{
                UserUtils\isNotAuthenticated();
                include "home.php";
                break;
            }
        case 'class-list':{
                UserUtils\isNotAuthenticated();
                include "class-list.php";
                break;
            }
        default:
            include 'auth.php';
            break;
    }
}

?>
    </main>

    <script src="../js/public/global/index.js" type="module"></script>
</body>

</html>