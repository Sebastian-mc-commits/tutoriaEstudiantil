<?php

$filePath = "../../utilities/viewsUtils.php";
if (file_exists($filePath)) {
    require_once $filePath;
    ViewsHelpers\secureView(null, "../");
}

use function Context\App\Functions\navigateController;
use function Context\App\Functions\navigation;
use UserModel\User;

$userInstance = new User();
$user = $userInstance->getUser();

?>

<link rel="stylesheet" href="../styles/user/user-detail.css">

<div class="userDetailContainer">
  <div>
    <a href="<?php echo navigation("user-classes", null, "user"); ?>">
      <button class="buttonSelectClass hoverAnimation button">Tus clases</button>
    </a>
    <a href="<?php echo navigateController("authentication", [
    "type" => "logOut",
]); ?>">
      <button class="buttonLogOut hoverAnimation button">Cerrar session</button>
    </a>
    <div class="card">
      <h3>¡Hola! <?php echo $user->name; ?></h3>
      <p class="textOpacity"><?php echo $user->email; ?></p>
      <p>Rol: <span class="textOpacity"><?php echo $user->type; ?></span></p>
    </div>
  </div>

  <div class="card userOptions">
    <h3 class="textOpacity"><?php echo $user->type; ?> Opciones</h3>
    <?php
if ($userInstance->studentType == $user->type) {
    include "user-options.php";
} elseif ($userInstance->tutorType == $user->type) {
    include "mentor-options.php";
}
?>

  </div>
</div>