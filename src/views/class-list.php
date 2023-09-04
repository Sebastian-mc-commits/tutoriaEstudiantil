<?php
require_once "../models/Mentoring.php";
require_once "../models/Schedule.php";
require_once "../models/MentoringUserRate.php";
require_once "../utilities/viewsUtils.php";

use function Context\App\Functions\navigateController;
use function Context\App\Functions\navigation;

ViewsHelpers\secureView([
    "method" => "GET",
    "allowParams" => ["id"],
]);

$mentoringInstance = new MentoringModel\Mentoring();

$id = $_GET["id"];
$mentoring = $mentoringInstance->getMentoringAndTutorById($id);
$rateModelI = new RateModel\MentoringUserRate();
$userI = new UserModel\User();
$user = $userI->getUser();

$isUserRegistered = $rateModelI->findOne(
    [
        "where" => [
            $rateModelI->mentoringId => [$id, "equal", "and"],
            $rateModelI->userId => [$user->userId, "equal"],
        ],
    ]
);

$C_navigate = navigateController("registration");
?>

<link rel="stylesheet" href="../styles/class-detail.css">

<div class="container">

    <nav class="classValuesContainer">
        <section class="card classValues">
            <h1><?php echo $mentoring->mentoringName; ?></h1>
            <p><?php echo $mentoring->description; ?></p>
        </section>
        <section>
            <div class="borderCard">
                <p><?php echo $mentoring->userName; ?></p>
                <span class="textOpacity"><strong>Especializacion: </strong><?php echo $mentoring->specialization; ?></span>
            </div>

        </section>
        <?php
        if (!$isUserRegistered) {

        ?>
            <h4 class="not-registered">No estas inscrito a esta clase</h4>
            <a href="<?php echo navigation("suggest-date", [
                            "singleSuggest" => $id,
                        ], "user"); ?>">
                <button class="button suggestScheduleButton hoverAnimation">Sugerir Horario</button>
            </a>
        <?php
        }

        ?>
    </nav>

    <nav class="class-detail-contents">
        <?php

        if (!$isUserRegistered) {
            include_once "class-details/schedules.php";
        } else {
            $scheduleRelatedI = new ScheduleModel\Schedule();
            $scheduleRelated = $scheduleRelatedI->findOne([
                "where" => [
                    $scheduleRelatedI->id => [$isUserRegistered[$rateModelI->scheduleIdType], "equal"]
                ]
            ]);

            if (!$scheduleRelated[$scheduleRelatedI->isAcceptedType]) {
        ?>

                <div class="borderCard">
                    <p>El profesor: <span> <?php echo $mentoring->userName; ?></span> No ha aceptado la clase</p>
                </div>
        <?php
            } else {
                include_once "class-details/comment-component.php";
            }
        }
        ?>

    </nav>


</div>