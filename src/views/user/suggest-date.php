<?php

require_once "../models/Mentoring.php";
require_once "../utilities/viewsUtils.php";

ViewsHelpers\secureView();

use function Context\App\Functions\navigation;
use MentoringModel\Mentoring;

$mentoringInstance = new Mentoring();
$singleDateSuggest = isset($_GET["singleSuggest"]) ? $_GET["singleSuggest"] : "";

$navigate = fn ($id) => navigation("class-list", ["id" => $id]);

?>

<link rel="stylesheet" href="../styles/user/suggest-schedule.css">
<nav class="scheduleSuggestContainer" id="mainContainer">
    <div class="mentoringRender">

        <?php

        if ($singleDateSuggest) {
            $m = $mentoringInstance->getMentoringAndTutorById($singleDateSuggest);

        ?>

            <section class='card' id="randomColorElement" data-global-id='<?php echo $m->id  ?>'>
                <h2><?php echo $m->mentoringName ?></h2>
                <div class="tutorFields">
                    <p class="borderCard"><strong>Tutor: </strong> <?php echo $m->tutorCreator ?></p>
                    <p class="textOpacity"><?php echo $m->specialization ?></p>
                </div>
                <button role="link" class="opacityHover button suggestDateButton" data-global-type="suggestSchedule">Sugerir Horario a esta clase</button>
            </section>
        <?php
        } else {
            $availableMentoring = $mentoringInstance->getMentoringAndAndTutorFields();
        ?>
            <?php
            while ($row = $availableMentoring->fetch_assoc()) {
            ?>
                <section class='card' id="randomColorElement" data-global-id='<?php echo $row[$mentoringInstance->idType] ?>'>
                    <h2><?php echo $row[$mentoringInstance->mentoringNameType] ?></h2>
                    <div class="tutorFields">
                        <p class="borderCard"><strong>Tutor: </strong> <?php echo $row[$mentoringInstance->userNameTypeX] ?></p>
                        <p class="textOpacity"><?php echo $row[$mentoringInstance->userSpecializationX] ?></p>
                    </div>
                    <button role="link" class="opacityHover button suggestDateButton" data-global-type="suggestSchedule">Sugerir Horario a esta clase</button>
                </section>
        <?php
            }
        }
        ?>
    </div>
    <div>
        <img src="../assets/images/calendar.jpg" alt="Why">
    </div>
</nav>

<script src="../js/public/home/index.js" type="module"></script>