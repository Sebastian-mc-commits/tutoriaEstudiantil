<?php

$filePath = "../../utilities/viewsUtils.php";
if (file_exists($filePath)) {
  require_once $filePath;
  ViewsHelpers\secureView(null, "../");
}
require_once "../models/MentoringUserRate.php";
$classesI = new RateModel\MentoringUserRate();
$registeredClasses = $classesI->getUserRegisteredClasses();
print_r($registeredClasses);

echo "Hello";
$navigate = fn ($id) => \Context\App\Functions\navigation("class-selected", [
  "id" => $id
], "user");
?>

<link rel="stylesheet" href="../styles/user/user-classes.css">
<div class="classesContainer">
  
  <nav class="classRender">

    <?php

if (empty($registeredClasses)) {
  ?>

      <section class='classComponent opacityHover card' role="link">
        <h2>Clases no encontradas</h2>
      </section>
      <?php
    } else {
      $classes = $registeredClasses->result;

      while ($row = $classes->fetch_assoc()) {
      ?>
        <a href="<?php echo $navigate($row[$registeredClasses->classId]) ?>">

          <section class='classComponent opacityHover card' role="link">
            <div>
              <h2><?php echo $row[$registeredClasses->mentoringName] ?></h2>
              <p><?php echo $row[$registeredClasses->mentoringDescription] ?></p>
              <div class="tutorFields">
                <p class="borderCard"><strong>Tutor: </strong> <?php echo $row[$registeredClasses->userName] ?></p>
                <p class="textOpacity"><?php echo $row[$registeredClasses->specialization] ?></p>
                <p class="textOpacity">Email: <?php echo $row[$registeredClasses->userEmail] ?></p>
              </div>
            </div>
            <div class="renderScheduleOps card">
              <h2>Horario</h2>
              <p class="borderCard"><strong>Empieza: </strong> <?php echo $row[$registeredClasses->date] ?></p>
              <p class="borderCard"><strong>Termina: </strong> <?php echo $row[$registeredClasses->endsIn] ?></p>
            </div>
          </section>
        </a>
    <?php
      }
    }
    ?>
  </nav>
</div>