<?php

$filePath = "../../utilities/viewsUtils.php";
if (file_exists($filePath)) {
  require_once $filePath;
  ViewsHelpers\secureView(null, "../");
}

require_once "../models/Specializations.php";
require_once "../models/Mentoring.php";

use function Context\App\Functions\navigation;

$tutorFieldsI = new TutorFieldsModel\TutorFields();
$userI = new UserModel\User();
$user = $userI->getUser();
$mentoringI = new MentoringModel\Mentoring();
$mentoring = $mentoringI->getClassesUsersAndSchedulesNotAccepted();
$mentoringData = $mentoringI->findAll();

$suggestedDates = isset($mentoring->result) ? $mentoring->result->num_rows : 0;

$existTutor = $tutorFieldsI->exists([
  "where" => [
    $tutorFieldsI->userId => [$user->userId, "equal"],
  ],
]);

?>

<link rel="stylesheet" href="../styles/user/mentor-options.css">
<div class="mentorOptions" id="mainContainer">

  <div class="options">
    <a href="<?php echo navigation("create-class", null, "mentor"); ?>" class="borderCard opacityHover">Crear Clase</a>
    <a href="<?php echo navigation("created-classes", null, "mentor"); ?>" class="borderCard opacityHover">Clases Creadas</a>
    <button class="borderCard opacityHover suggestedSchedulesContainerButton" data-global-type="navigateToSuggestedSchedules">
      <span>Horarios sugeridos</span>
      <p class="suggestedSchedules card"><?php echo $suggestedDates; ?></p>
    </button>
    <button class="borderCard opacityHover suggestedSchedulesContainerButton" data-global-type="navigateToTodaysClasses">
      Clases del dia
    </button>
    <button class="borderCard opacityHover suggestedSchedulesContainerButton" data-global-type="navigateToCreatedClasses">Clases creadas</button>
    <a href="" class="borderCard opacityHover">Eliminar clases y horarios</a>
  </div>

  <?php
  if (!$existTutor) {
  ?>
    <a href="<?php echo navigation("mentor-fields", null, "user"); ?>">
      <button class="button-yellow-green button hoverAnimation" role="link">Llena los siguientes campos requeridos</button>
    </a>
  <?php
  }
  ?>
  <div id='suggestedSchedules' class="suggestedSchedulesRender wholeView" hidden>
    <button data-global-type='goBack' class="goBackStyle">Volver</button>
    <nav class="suggestedSchedulesRenderContainer">
      <?php
      while ($row = $mentoring->result->fetch_assoc()) {

      ?>

        <section id="randomColorElement" class="card" data-global-id='<?php echo $row[$mentoring->scheduleId] ?>'>
          <h2><?php echo $row[$mentoring->userName] ?></h2>
          <strong class="textOpacity"><?php echo $row[$mentoring->userEmail] ?></strong>
          <strong class="textOpacity">Sugirio</strong>
          <h3><?php echo $row[$mentoring->mentoringName] ?></h3>
          <p class="borderCard opacityHover"><strong>De:</strong> <?php echo $row[$mentoring->date] ?> <strong>Hasta:</strong> <?php echo $row[$mentoring->endsIn] ?></p>
          <button class='button hoverAnimation' data-global-type="acceptSchedule">Aceptar Horario</button>
        </section>
      <?php
      }
      ?>
    </nav>

  </div>

  <div class="renderTodaysClassesContainer wholeView" id="todaysClasses" hidden>
    <button data-global-type='goBack' class="goBackStyle">Volver</button>

    <nav class="todaysClassesContainer" aria-label="addSchedule">

    </nav>
  </div>

  <div id="createdClasses" class="wholeView createdClasses" hidden>
    <button data-global-type='moveCreatedClassesContainer' class="goBackStyle">Volver</button>
    <nav aria-label="created_Classes">
    </nav>
  </div>
</div>

<script src="../js/public/home/index.js" type="module"></script>