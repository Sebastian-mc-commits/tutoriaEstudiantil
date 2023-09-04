<?php

$filePath = "../../utilities/viewsUtils.php";
if (file_exists($filePath)) {
  require_once $filePath;
  ViewsHelpers\secureView(null, "../");
}

require_once "../models/Mentoring.php";
require_once "../models/Schedule.php";

$mentoringI = new MentoringModel\Mentoring();
$tutorI = new TutorFieldsModel\TutorFields();
$tutor = $tutorI->getTutor();

$classes = $mentoringI->findAll([
  "where" => [
    $mentoringI->tutorCreator => [$tutor->tutorId, "equal"]
  ]
], false, false);

$renderClassN = fn ($id) => \Context\App\Functions\navigation("render-created-class", [
  "id" => $id
], "mentor");

?>

<link rel="stylesheet" href="../styles/mentor/created-classes.css">

<nav class="classRenderContainer">
  <?php
  while ($row = $classes->fetch_assoc()) {
  ?>
    <a href="<?php echo $renderClassN($row[$mentoringI->idType]); ?>">
      <section class="card opacityHover" id="randomColorElement" role="link">
        <h2><?php echo $row[$mentoringI->mentoringNameType]; ?></h2>
        <p class="textOpacity"><?php echo $row[$mentoringI->descriptionType]; ?></p>
      </section>
    </a>
  <?php
  }
  ?>
</nav>

<script src="../js/public/home/index.js" type="module"></script>