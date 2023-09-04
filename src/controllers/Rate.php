<?php

require_once "../models/User.php";
require_once "../models/MentoringUserRate.php";

session_start();
$type = $_GET["type"];

$userI = new UserModel\User();
$user = $userI->getUser();

$class = new RateModel\MentoringUserRate();

if ($user != null) {
    switch ($type) {
        case "registerUserToClass":{
          $mentoringId = isset($_GET["mentoringId"]) ? $_GET["mentoringId"] : null;
          $scheduleId = isset($_GET["scheduleId"]) ? $_GET["scheduleId"] : null;
                if (empty($mentoringId) || empty($scheduleId)) {
                    break;
                }

                require_once "../models/TutorFields.php";
                require_once "../models/Mentoring.php";

                $tutorI = new TutorFieldsModel\TutorFields();
                $tutor = $tutorI->getTutor();
                $mentoringI = new MentoringModel\Mentoring();

                $isUserRegistered = $class->exists([
                    "where" => [
                        $class->userId => [$user->userId, "equal", "and"],
                        $class->mentoringId => [$mentoringId, "equal"]
                    ],
                ], false);

                $getClasses = $class->findAll([
                  "where" => [
                    $class->mentoringId => [$mentoringId, "equal"]
                  ]
                ], false, false);

                if ($isUserRegistered || $getClasses->num_rows >= 5) {
                    break;
                }

                $getClassSelected = $mentoringI->findOne([
                    "where" => [
                        $mentoringI->id => [$mentoringId, "equal"],
                    ],
                ], false, false);

                if (($tutor != null || !empty($tutor)) && $getClassSelected[$class->mentoringId] == $tutor->tutorId) {
                    break;
                }
                $class->create([
                    $class->scheduleId => $scheduleId,
                    $class->userId => $user->userId,
                    $class->mentoringId => $mentoringId,
                ]);

                break;
            }

        case "rateClass":{
                [$class->comment => $comment, $class->rate => $rate] = $_POST;
                $class->update([
                    "where" => [
                        $class->mentoringId => [$mentoringId, "equal"],
                    ],
                    "set" => [
                        $class->rate => $rate,
                        $class->comment => $comment,
                    ],
                ]);

                break;
            }

        default:
            break;
    }
}

header("Location: ../views/index.php?page=class-list");
exit;
