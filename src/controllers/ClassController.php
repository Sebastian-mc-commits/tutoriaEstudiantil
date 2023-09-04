
<?php
require_once "index.php";
require_once "../models/TutorFields.php";

$type = isset($_GET["type"]) ? $_GET["type"] : "";
session_start();
$tutorI = new TutorFieldsModel\TutorFields();
$tutor = $tutorI->getTutor();
$status = false;

if ($tutor != null) {
  require_once "../models/Mentoring.php";

  $newClass = new MentoringModel\Mentoring();

  switch ($type) {
    case "createClass":
      require_once "../models/Schedule.php";
      $classesCreated = $newClass->findAll([
        "where" => [
          $newClass->tutorCreator => [$tutor->tutorId, "equal"]
        ]
      ], false, false);


      if ($classesCreated->num_rows >= 8) {
        break;
      }
      $newSchedules = new ScheduleModel\Schedule();

      ["class" => $class, "schedules" => $schedules] = Controller\getJson();


      $createClass = function ($rollback) use ($newClass, $class, $schedules, $tutor, $newSchedules) {
        ["description" => $classDescription, "name" => $className] = $class;
        ["hasError" => $hasError, "result" => $result] = $newClass->createAndGet($newClass->id, [
          "MENTORING_NAME" => $className,
          "DESCRIPTION" => $classDescription,
          "TUTOR_CREATOR" => $tutor->tutorId,
        ], false);


        if ($hasError) {
          $rollback();
          return;
        }

        $inserted = $newSchedules->bulkCreate([
          "keys" => ["DATE", "ENDS_IN", "ACCESS_LINK", "DESCRIPTION"],
          "values" => $schedules,
          "global" => [
            $newSchedules->mentoringIdType => $result[$newClass->idType],
            $newSchedules->isAcceptedType => 1
          ]
        ], false, false);

        if (!$inserted) {
          $rollback();
        }
      };

      $status = $newClass->transaction($createClass, true);

      break;

    case "getClassesJson": {
        $classesCreated = $newClass->findAll([
          "where" => [
            $newClass->tutorCreator => [$tutor->tutorId, "equal"]
          ]
        ]);

        header("Content-type: application/json");
        echo json_encode([
          "data" => Controller\parseMysqlDataToJson($classesCreated)
        ]);

        exit;
      }

    case "tutorTodaysClasses": {
        header("Content-type: application/json");
        echo json_encode([
          "data" => Controller\parseMysqlDataToJson($newClass->getCurrentDateClasses())
        ]);
        exit;
      }
    default:
      break;
  }
}

header("Content-Type: application/json");
echo json_encode([
  "status" => $status
]);
exit;