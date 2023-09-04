<?php
$filePath = "../../utilities/viewsUtils.php";
if (file_exists($filePath)) {
  require_once $filePath;
  ViewsHelpers\secureView(null, "../");
}

require_once "../models/MentoringUserRate.php";
$classesI = new RateModel\MentoringUserRate();
$id = $_GET["id"];
$class = $classesI->getUserRegisteredClass($id);

?>
<link rel="stylesheet" href="../styles/user/class-selected.css">
<div class="classContainer">

  <nav class="classRender">

    <section class="mainSection">
      <div class="card mentoringSection">
        <h2><?php echo $class->mentoringName ?></h2>
        <p><?php echo $class->mentoringDescription ?></p>
      </div>
      <div class='card scheduleSection' role="link">
        <h2>Horario</h2>
        <p class="borderCard"><strong>Empieza: </strong> <?php echo $class->date ?></p>
        <p class="borderCard"><strong>Termina: </strong> <?php echo $class->endsIn ?></p>
        <p class="textOpacity"><strong>Descripcion: </strong> <?php echo $class->description ?></p>
      </div>
    </section>
    <section class="card tutorSection">
      <p><strong>Link: </strong> <a href="<?php echo $class->accessLink ?>" target="_blank"><?php echo $class->accessLink ?></a></p>
      <p class="borderCard"><strong>Tutor: </strong> <?php echo $class->userName ?></p>
      <div class="card">
        <p class="textOpacity"><?php echo $class->specialization ?></p>
        <p class="textOpacity">Email: <?php echo $class->userEmail ?></p>
      </div>
    </section>

    <section class="rateSection card">
      <?php
      include("class-details/comment-component.php");
      ?>
    </section>

  </nav>
</div>