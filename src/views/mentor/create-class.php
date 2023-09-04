<?php

$filePath = "../../utilities/viewsUtils.php";
if (file_exists($filePath)) {
  require_once $filePath;
  ViewsHelpers\secureView(null, "../");
}

require_once "../models/Mentoring.php";

use TutorFieldsModel\TutorFields;

$tutorInstance = new TutorFields();
$tutor = $tutorInstance->getTutor();

$mentoringI = new MentoringModel\Mentoring();

?>

<link rel="stylesheet" href="../styles/components/classCard.css">
<link rel="stylesheet" href="../styles/mentor/create-class.css">

<nav class="createClassContainer" id="mainContainer">

  <section class="card">
    <form action="">
      <h2>Agregar Clase</h2>
      <label for="name">
        <span>Nombre de la clase</span>
        <input data-class-name="" type="text" id="name" placeholder="Ciencias" name="<?php echo $mentoringI->mentoringName; ?>">
      </label>
      <label for="name">
        <span>Descripcion de la clase</span>
        <textarea data-class-description="" placeholder="En esta clase aprenderas los fundamentos de ciencias" id="description" rows="10" name="<?php echo $mentoringI->description; ?>"></textarea>
      </label>
      <input type="submit" value="Crear clase" data-class-disabled='' data-global-type="createClass">
    </form>

  </section>

  <section class="card class_schedule">
    <div class='classComponentStyle opacityHover' id="randomColorElement" role="link">
      <h2 data-class-name=""></h2>
      <p data-class-description=""></p>
      <div class="tutorFields">
        <p class="borderCard"><?php echo $tutor->userName; ?></p>
        <p class="textOpacity"><?php echo $tutor->specialization; ?></p>
      </div>
    </div>
    <div class="addSchedule">
      <p class="card textOpacity opacityHover" data-global-type="addSchedule">Agregar Horario</p>
    </div>
  </section>
</nav>

<script src="../js/public/create-class/index.js" type="module"></script>