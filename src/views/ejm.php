<?php

require_once "../models/Mentoring.php";

$mentoringI = new MentoringModel\Mentoring();
$mentoring = $mentoringI->findAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/user/mentor-options.css">
</head>

<body>

<nav class="renderAddSchedulesContainer">

    <?php
    while ($row = $mentoring->fetch_assoc()) {
    ?>
        <section class='opacityHover card' id="randomColorElement" role="link">
            <h2><?php echo $row[$mentoringI->mentoringNameType] ?></h2>
            <p><?php echo $row[$mentoringI->descriptionType] ?></p>
            <div class="scheduleCreatedContainer card">
                <div class="card schedule-created">
                    <h2>${DATE}</h2>
                    <p class="textOpacity opacityHover">Ends in</p>
                    <p class="textOpacity">CLASS_COMMENT</p>
                    <p class="borderCard access-link">ACCESS_LINK</p>
                </div>
                <div class="card schedule-created">
                    <h2>${DATE}</h2>
                    <p class="textOpacity opacityHover">Ends in</p>
                    <p class="textOpacity">CLASS_COMMENT</p>
                    <p class="borderCard access-link">ACCESS_LINK</p>
                </div>
                <div class="card schedule-created">
                    <h2>${DATE}</h2>
                    <p class="textOpacity opacityHover">Ends in</p>
                    <p class="textOpacity">CLASS_COMMENT</p>
                    <p class="borderCard access-link">ACCESS_LINK</p>
                </div>
                <div class="card schedule-created">
                    <h2>${DATE}</h2>
                    <p class="textOpacity opacityHover">Ends in</p>
                    <p class="textOpacity">CLASS_COMMENT</p>
                    <p class="borderCard access-link">ACCESS_LINK</p>
                </div>
            </div>
        </section>
    <?php
    }
    ?>
</nav>
</body>

</html>