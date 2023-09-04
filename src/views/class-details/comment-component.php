<?php

$filePath = "../../utilities/viewsUtils.php";
if (file_exists($filePath)) {
  require_once $filePath;
  ViewsHelpers\secureView(null, "../");
}

$rateI = new RateModel\MentoringUserRate();

use function Context\App\Functions\navigateController;

?>

<link rel="stylesheet" href="../styles/class-details/comment-component.css">

<form action="<?php echo navigateController("Rate", [
                    "type" => "rateClass",
                    "mentoringId" => $id
                ]); ?>" class="formContainer" method="POST">
    <h3 class="textOpacity">Comentar Clase</h3>
    <div class="rateContainer">
        <label for="id">
            <span>1</span>
            <input type="radio" id="rate" value='1' name="<?php echo $rateI->rate ?>">
        </label>
        <label for="id">
            <span>2</span>
            <input type="radio" id="rate" value='2' name="<?php echo $rateI->rate ?>">
        </label>
        <label for="id">
            <span>3</span>
            <input type="radio" id="rate" value='3' name="<?php echo $rateI->rate ?>">
        </label>
        <label for="id">
            <span>4</span>
            <input type="radio" id="rate" value='4' name="<?php echo $rateI->rate ?>">
        </label>
        <label for="id">
            <span>5</span>
            <input type="radio" id="rate" value='5' name="<?php echo $rateI->rate ?>">
        </label>
    </div>

    <textarea name="<?php echo $rateI->comment ?>" rows="10" placeholder="Provee tu retroalimentacion"></textarea>
    <input type="submit" value="Enviar">
</form>