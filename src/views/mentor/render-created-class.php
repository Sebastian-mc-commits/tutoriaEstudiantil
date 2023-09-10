<?php
$filePath = "../../utilities/viewsUtils.php";
$tree = "../";
if (!file_exists($filePath)) {
  $filePath = "../utilities/viewsUtils.php";
  $tree = "";
}

require_once $filePath;
ViewsHelpers\secureView([
  "method" => "GET",
  "allowParams" => ["id"]
], $tree);

require_once "../models/Mentoring.php";
require_once "../models/Schedule.php";
$id = $_GET["id"];
$classI = new MentoringModel\Mentoring();
$selectedClass = $classI->findOne([
  "where" => [
    $classI->id => [$id, "equal"]
  ]
], false, false);

$scheduleI = new ScheduleModel\Schedule();

$schedules = $scheduleI->findAll([
  "where" => [
    $scheduleI->mentoringId => [$selectedClass[$classI->idType], "equal"]
  ]
], false, false);

// $scheduleI->isAccepted => [1, "equal"]
$registeredUsersI = new RateModel\MentoringUserRate();

$registeredUsers = $registeredUsersI->findAll([
  "where" => [
    $registeredUsersI->mentoringId => [$selectedClass[$classI->idType], "equal"]
  ]
]);
?>

<link rel="stylesheet" href="../styles/sideBar.css">
<link rel="stylesheet" href="../styles/mentor/render-created-class.css">
<input type="checkbox" id="handleHideBar" hidden>
<label for="handleHideBar" class="sideBarIcon hoverAnimation">&#9776;</label>
<div class="sideBarContainer" id="mainContainer">
  <ul class="sideBarMethods">
    <li data-global-id="<?php echo $selectedClass[$classI->idType] ?>">
      Estudiantes registrados: <strong><?php echo $registeredUsers->num_rows; ?></strong>
      <button data-global-type="getRegisteredUsers" class="button hoverAnimation">Info</button>
    </li>
    <li><button class="button hoverAnimation">Anunciar</button></li>
    <li>Cantidad de horarios <strong><?php echo $schedules->num_rows; ?></strong></li>
    <li><button class="button hoverAnimation">Valoraciones de la clase</button></li>
  </ul>
</div>
<div class="contentBody">
  <nav class="sectionRender" id="mainContainer">
    <section class="card schedulesRenderContainer">
      <h2>Fechas</h2>
      <div class="schedulesRenderer" data-global-id="<?php echo $selectedClass[$classI->idType]; ?>">
        <?php
        while ($row = $schedules->fetch_assoc()) {
        ?>
          <div class="card" data-date-id="<?php echo $row[$scheduleI->idType]; ?>">
            <p>Empieza <span class="textOpacity"><?php echo $row[$scheduleI->dateType]; ?></span></p>
            <p>Termina <span class="textOpacity"><?php echo $row[$scheduleI->endsInType]; ?></span></p>
            <div class="sectionNeeds">
              <button class="button danger" data-global-type="handleDeleteSchedule">Eliminar</button>
              <button class="button primary" data-global-type="handleUpdateSchedule">Actualizar</button>
            </div>
          </div>
        <?php
        }
        ?>
        <p class="card textOpacity opacityHover" data-global-type="handleAddSchedule">
          Agregar Horario
        </p>
      </div>
    </section>
    <section class="sectionNeeds" data-global-id="<?php echo $selectedClass[$classI->idType]; ?>">
      <button class="button danger" data-global-type="handleDeleteClass">Eliminar clase</button>
      <button class="button primary" data-global-type="handleUpdateClass">Actualizar</button>
    </section>
    <section class="classDetail card">
      <form id="classForm">
        <label for="<?php echo $classI->mentoringName; ?>">
          <span>Nombre de la clase</span>
          <input type="text" name="<?php echo $classI->mentoringName; ?>" placeholder="Ciencias..." value="<?php echo $selectedClass[$classI->mentoringNameType]; ?>" class="inputTitle">
        </label>
        <label for="<?php echo $classI->description; ?>">
          <span>Descripcion de la clase</span>
          <textarea name="<?php echo $classI->description; ?>" id="" rows="10"><?php echo $selectedClass[$classI->descriptionType]; ?></textarea>
        </label>

      </form>
    </section>
  </nav>
</div>