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

?>

<link rel="stylesheet" href="../styles/sideBar.css">
<link rel="stylesheet" href="../styles/mentor/render-created-class.css">
<input type="checkbox" id="handleHideBar" hidden>
<label for="handleHideBar" class="sideBarIcon hoverAnimation">&#9776;</label>
<div class="sideBarContainer">
  <ul class="sideBarMethods">
    <li>Estudiantes registrados: <strong>2</strong></li>
    <li><button class="button hoverAnimation">Material de la clase</button></li>
    <li>Cantidad de horarios <strong>5</strong></li>
    <li><button class="button hoverAnimation">Valoraciones de la clase</button></li>
  </ul>
</div>
<div class="contentBody">
  <nav class="sectionRender">
    <section class="card schedulesRenderContainer">
      <h2>Fechas</h2>
      <div class="schedulesRenderer">
        <div class="card">
          <p>Empieza <span class="textOpacity">12/06/56</span></p>
          <p>Termina <span class="textOpacity">12/06/56</span></p>
        </div>
        <p class="card textOpacity opacityHover" data-global-type="addSchedule">
          Agregar Horario
        </p>
      </div>
    </section>
    <section class="sectionNeeds">
      <button class="button danger">Eliminar clase</button>
      <button class="button primary">Actualizar</button>
    </section>
    <section class="classDetail card">
      <form action="">
        <label for="">
          <span>Nombre de la clase</span>
          <input type="text" placeholder="Ciencias..." value="Class name" class="inputTitle">
        </label>
        <label for="">
          <span>Link de la clase</span>
          <input type="text" placeholder="meet" value="https//:meet">
        </label>
        <label for="">
          <span>Descripcion de la clase</span>
          <textarea name="" id="" rows="10">A good description</textarea>
        </label>
        
      </form>
    </section>
  </nav>
</div>