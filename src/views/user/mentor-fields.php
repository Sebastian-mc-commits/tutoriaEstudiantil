<?php

$filePath = "../../utilities/viewsUtils.php";
if (file_exists($filePath)) {
  require_once $filePath;
  ViewsHelpers\secureView(null, "../");
}

require_once "../models/Specializations.php";

use function Context\App\Functions\navigateController;

$tutorI = new TutorFieldsModel\TutorFields();
$specializationI = new SpecializationsModel\Specialization();
$specializations = $specializationI->findAll();
?>

<link rel="stylesheet" href="../styles/user/mentor-fields.css">
<form action="<?php echo navigateController("Mentor", [
                "type" => "createMentorFields"
              ]); ?>" method="post" class="mentorFieldsContainer card">

  <label for="">
    <span>Especializaciones disponibles</span>
    <select name="<?php echo $tutorI->specialization; ?>">
      <?php
      while ($row = $specializations->fetch_assoc()) {
      ?>
        <option value="<?php echo $row[$specializationI->Db_id]; ?>">
          <?php echo $row[$specializationI->Db_name]; ?>
        </option>
      <?php
      }
      ?>

      <option value="" selected>Selecciona una especializacion</option>
    </select>
  </label>

  <input type="submit" value="Registrar">

</form>