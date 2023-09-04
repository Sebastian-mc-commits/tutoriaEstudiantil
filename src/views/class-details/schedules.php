<?php

$filePath = "../../utilities/viewsUtils.php";
if (file_exists($filePath)) {
  require_once $filePath;
  ViewsHelpers\secureView(null, "../");
}

require_once "../models/MentoringUserRate.php";

$rateModel = new RateModel\MentoringUserRate();

use function Context\App\Functions\navigateController;

$exists = $rateModel->exists([
    "where" => [
        "USER_ID" => ["sad", "equal", "and"],
        "SCHEDULE_ID" => ["sadness", "equal"]
    ]
]);

$scheduleI = new ScheduleModel\Schedule();
$schedules = $scheduleI->findAll([
    "where" => [
        $scheduleI->mentoringId => [$id, "equal", "and"],
        $scheduleI->isAccepted => [1, "equal"]
    ]
]);

$schedulesLength = $schedules->num_rows;

?>

<section class="scheduleRenderStyles">
    <?php
    while ($row = $schedules->fetch_assoc()) {
    ?>
        <div class="card">
            <p><strong>Fecha: </strong><?php echo $row[$scheduleI->dateType]; ?></p>
            <p><strong>Termina: </strong><?php echo $row[$scheduleI->endsInType]; ?></p>
            <p class="textOpacity">Son maximo 5 estudiantes</p>
            <?php
            if (!$isUserRegistered) {

            ?>
                <a href="<?php echo navigateController("Rate", [
                                "type" => "registerUserToClass",
                                "scheduleId" => $row[$scheduleI->idType],
                                "mentoringId" => $id
                            ]) ?>">
                    <button class="registerButton button hoverAnimation" role="link">Inscribirme</button>
                </a>
            <?php
            }

            ?>
        </div>
    <?php
    }
    ?>
</section>