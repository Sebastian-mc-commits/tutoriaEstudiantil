
<?php
require_once "index.php";
require_once "../models/Schedule.php";
require_once "../models/User.php";
require_once "../models/MentoringUserRate.php";

$type = isset($_GET["type"]) ? $_GET["type"] : "";
session_start();

$userI = new UserModel\User();
$user = $userI->getUser();
$status = false;

$rateI = new RateModel\MentoringUserRate();

if ($type != null || $user != null) {
    require_once "../models/Mentoring.php";

    $scheduleI = new ScheduleModel\Schedule();

    switch ($type) {
        case "suggestSchedule":

            $jsonData = Controller\getJson();
            $data = array_merge($jsonData, [
                $scheduleI->accessLink => "",
                $scheduleI->description => "",
                $scheduleI->isAccepted => 0,
            ]);

            $isUserRegisteredInClass = $rateI->exists([
                "where" => [
                    $rateI->userId => [$user->userId, "equal", "and"],
                    $rateI->mentoringId => [$jsonData["MENTORING_ID"], "equal"]
                ]
            ], false);

            if ($isUserRegisteredInClass) {
                break;
            }

            $callback = function ($rollback) use ($scheduleI, $data, $user, $jsonData) {


                ["hasError" => $hasError, "result" => $result] = $scheduleI->createAndGet($scheduleI->id, $data, false);

                if ($hasError) {
                    $rollback();
                    return;
                }

                $rateI = new RateModel\MentoringUserRate();

                $isCreated = $rateI->create([
                    $rateI->scheduleId => $result[$scheduleI->idType],
                    $rateI->userId => $user->userId,
                    $rateI->mentoringId => $jsonData["MENTORING_ID"],
                ], false, false);

                if (!$isCreated) {
                    $rollback();
                }
            };

            $status = $scheduleI->transaction($callback, true);

            break;

        case "acceptSchedule": {
                require_once "../models/TutorFields.php";
                $tutorI = new TutorFieldsModel\TutorFields();
                if ($tutorI->getTutor() == null) {
                    break;
                }

                ["scheduleId" => $scheduleId] = Controller\getJson();
                $isUpdate = $scheduleI->update([
                    "where" => [
                        $scheduleI->id => [$scheduleId, "equal"]
                    ],
                    "set" => [
                        $scheduleI->isAccepted => 1
                    ]
                ]);

                header("Content-Type: application/json");
                echo json_encode([
                    "status" => $isUpdate
                ]);
                exit;
            }

        case "addScheduleJson": {
                $data = Controller\getJson();
                $data[$scheduleI->isAccepted] = 1;
                $isAdded = $scheduleI->create($data);

                header("Content-Type: application/json");
                echo json_encode([
                    "isAdded" => $isAdded,
                ]);
                exit;
            }

        case "getScheduleByIdJson": {
                $schedule = $scheduleI->findOne([
                    "where" => [
                        $scheduleI->id => [$_GET["id"], "equal"]
                    ]
                ]);
                header("Content-Type: application/json");
                echo json_encode([
                    "schedule" => $schedule,
                ]);
                exit;
            }

        case "updateScheduleJson": {

                // ["id" => $id, "date" => $date, "endsIn" => $endsIn, "accessLink" => $accessLink, "description" => $description] = Controller\getJson();
                $data = Controller\getJson();
                $id = $data["id"];
                unset($data["id"]);

                $isUpdated = $scheduleI->update([
                    "where" => [
                        $scheduleI->id => [$id, "equal"]
                    ],
                    "set" => $data
                ]);

                header("Content-Type: application/json");
                echo json_encode([
                    "isUpdated" => $isUpdated,
                ]);
                exit;
            }

        case "deleteScheduleJson": {

                ["id" => $id] = Controller\getJson();

                $isDeleted = $scheduleI->delete([
                    "where" => [
                        $scheduleI->id => [$id, "equal"]
                    ]
                ]);

                header("Content-Type: application/json");
                echo json_encode([
                    "isDeleted" => $isDeleted,
                ]);
                exit;
            }

        default:
            break;
    }
}

header("Content-Type: application/json");
echo json_encode([
    "status" => $status,
]);
exit;
