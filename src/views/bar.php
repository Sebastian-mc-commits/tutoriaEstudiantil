<?php

require_once "../utilities/viewsUtils.php";

ViewsHelpers\secureView();

use function Context\App\Functions\navigation;

$userInstance = new UserModel\User();
?>

<nav class="barContainer">
  <section class="routesBar">
    <a class="opacityHover" href="<?php echo navigation("class-list"); ?>">Clases</a>
    <?php
    if ($userInstance->getUser() == null) {

    ?>
      <a class="opacityHover" href="<?php echo navigation("auth"); ?>">Autenticacion</a>
    <?php
    }
    ?>
    <button id="theme" class="hoverAnimation button button-yellow-green">Cambiar tema</button>
  </section>

  <a href="<?php echo navigation("user-detail", null, "user"); ?>" id="user">
    <button class="hoverAnimation button button-yellow-green">User</button>
  </a>
</nav>