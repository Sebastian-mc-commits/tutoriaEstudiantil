<?php
$filePath = "../../utilities/viewsUtils.php";
if (file_exists($filePath)) {
    require_once $filePath;
    ViewsHelpers\secureView(null, "../");
}

use function Context\App\Functions\navigation;

?>

<div class="options">
  <a href="" class="borderCard opacityHover">Salir de una clase</a>
  <a href="" class="borderCard opacityHover">Cambiar de horario</a>
  <a href="<?php echo navigation("suggest-date", null, "user"); ?>" class="borderCard opacityHover">Sugerir Horario</a>
</div>