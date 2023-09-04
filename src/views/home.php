<?php

require_once "../models/Mentoring.php";
require_once "../utilities/viewsUtils.php";

ViewsHelpers\secureView();
use MentoringModel\Mentoring;
use function Context\App\Functions\navigation;


$mentoringInstance = new Mentoring();
$availableMentoring = $mentoringInstance->getMentoringAndAndTutorFields();

$navigate = fn ($id) => navigation("class-list", ["id" => $id]);

?>

<link rel="stylesheet" href="../styles/home.css">
<link rel="stylesheet" href="../styles/components/classCard.css">

<nav class="classList">
    <?php
    while ($row = $availableMentoring->fetch_assoc()) {
    ?>
        <a href="<?php echo $navigate($row[$mentoringInstance->idType]) ?>">
            <section class='classComponentStyle opacityHover' id="randomColorElement" role="link">
                <h2><?php echo $row[$mentoringInstance->mentoringNameType] ?></h2>
                <p><?php echo $row[$mentoringInstance->descriptionType] ?></p>
                <div class="tutorFields">
                    <p class="borderCard"><strong>Tutor: </strong> <?php echo $row[$mentoringInstance->userNameTypeX] ?></p>
                    <p class="textOpacity"><?php echo $row[$mentoringInstance->userSpecializationX] ?></p>
                </div>
            </section>
        </a>
    <?php
    }
    ?>
</nav>

<script src="../js/public/home/index.js" type="module"></script>