<?php

namespace RateModel;

require_once "index.php";
require_once "User.php";
require_once "TutorFields.php";
require_once "Specializations.php";
require_once "Schedule.php";
require_once "Mentoring.php";

use Exception;
use UserModel\User;
use TutorFieldsModel\TutorFields;
use SpecializationsModel\Specialization;
use ScheduleModel\Schedule;
use MentoringModel\Mentoring;

use Model\IndexModel;

class MentoringUserRate extends IndexModel
{

    function __construct()
    {
        parent::__construct("mentoringRate", [
            "ID" => "id",
            "SCHEDULE_ID" => "scheduleId",
            "USER_ID" => "userId",
            "COMMENT" => "comment",
            "RATE" => "rate",
            "SCORE" => "score",
            "MENTORING_ID" => "mentoringId"
        ]);
    }

    public $mentoringId = "MENTORING_ID";
    public $userId = "USER_ID";
    public $scheduleId = "SCHEDULE_ID";
    public $scheduleIdType = "scheduleId";
    public $mentoringIdType = "mentoringId";
    public $userIdType = "userId";
    public $comment = "COMMENT";
    public $rate = "RATE";
    public $score = "SCORE";
    public $id = "ID";

    private function getRegisteredMentoringQuery($tutorI, $specializationI, $userI, $scheduleI, $mentoringI)
    {

        return "SELECT s.name as specialization,"
            .
            " us.name as userName, us.email as userEmail, mr.id as classId, mr.*, sc.*, mt.description as mentoringDescription, mt.mentoringName as mentoringName"
            .
            " FROM $this->modelName mr"
            .
            " INNER JOIN $mentoringI->modelName mt ON mt.id = mr.mentoringId"
            .
            " INNER JOIN $tutorI->modelName t ON t.id = mt.tutorCreator"
            .
            " INNER JOIN $userI->modelName us ON us.id = t.userId"
            .
            " INNER JOIN $specializationI->modelName s ON s.id = t.specialization"
            .
            " INNER JOIN $scheduleI->modelName sc ON sc.id = mr.scheduleId";
    }

    public function getUserRegisteredClasses()
    {

        $userI = new User();
        $user = $userI->getUser();
        $userId = $user->userId;
        $tutorI = new TutorFields();
        $specializationI = new Specialization();
        $scheduleI = new Schedule();
        $mentoringI = new Mentoring();

        $query = $this->getRegisteredMentoringQuery($tutorI, $specializationI, $userI, $scheduleI, $mentoringI)
            .
            " WHERE mr.userId = $userId AND sc.isAccepted = 1";

        $result = null;
        try {
            $result = $this->getConnection()->query($query);
            if (empty($result) || $result->num_rows == 0) {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }

        $this->closeConnection();
        return new class($result) extends RateModelTypes
        {
            public $result;

            public function __construct($result)
            {
                parent::__construct();
                $this->result = $result;
            }
        };
    }
    public function getUserRegisteredClass($classId)
    {

        $userI = new User();
        $user = $userI->getUser();
        $userId = $user->userId;
        $tutorI = new TutorFields();
        $specializationI = new Specialization();
        $scheduleI = new Schedule();
        $mentoringI = new Mentoring();

        $query = $this->getRegisteredMentoringQuery($tutorI, $specializationI, $userI, $scheduleI, $mentoringI)
            .
            " WHERE mr.userId = $userId AND sc.isAccepted = 1 AND mr.id = $classId";

        $result = null;
        try {
            $result = $this->getConnection()->query($query);
            if (empty($result) || $result->num_rows == 0) {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }

        $this->closeConnection();
        return new class($result) extends RateModelTypes
        {

            public function __construct($result)
            {
                parent::__construct($result);
            }
        };
    }

    public function getRegisteredUsersOfClass ($classId) {

        $userI = new User();
        $query = "SELECT mr.*, us.name AS userName, us.email AS userEmail FROM $this->modelName mr"
        .
        " INNER JOIN $userI->modelName us ON mr.userId = us.id WHERE mr.mentoringId = $classId";

        $result = null;
        try {
            $result = $this->getConnection()->query($query);
            if (empty($result) || $result->num_rows == 0) {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }

        $this->closeConnection();
        return new class($result) extends RateModelTypes
        {

            public $result = null;
            public function __construct($result)
            {
                parent::__construct();
                $this->result = $result;
            }
        };
    }
}

abstract class RateModelTypes
{
    public $rate = "rate";
    public $score = "score";
    public $date = "date";
    public $endsIn = "endsIn";
    public $isAccepted = "isAccepted";
    public $description = "description";
    public $accessLink = "accessLink";
    public $mentoringName = "mentoringName";
    public $comment = "comment";
    public $mentoringDescription = "mentoringDescription";
    public $userEmail = "userEmail";
    public $userName = "userName";
    public $specialization = "specialization";
    public $classId = "classId";

    public function __construct($result = null)
    {
        if (isset($result) && !empty($result)) {
            $result = $result->fetch_assoc();
            [
                "rate" => $rate,
                "score" => $score,
                "date" => $date,
                "endsIn" => $endsIn,
                "isAccepted" => $isAccepted,
                "description" => $description,
                "accessLink" => $accessLink,
                "mentoringName" => $mentoringName,
                "comment" => $comment,
                "mentoringDescription" => $mentoringDescription,
                "userEmail" => $userEmail,
                "userName" => $userName,
                "specialization" => $specialization,
                "classId" => $classId,
            ] = $result;

            $this->specialization = $specialization;
            $this->userName = $userName;
            $this->userEmail = $userEmail;
            $this->mentoringDescription = $mentoringDescription;
            $this->comment = $comment;
            $this->rate = $rate;
            $this->score = $score;
            $this->date = $date;
            $this->endsIn = $endsIn;
            $this->isAccepted = $isAccepted;
            $this->description = $description;
            $this->accessLink = $accessLink;
            $this->mentoringName = $mentoringName;
            $this->classId = $classId;
        }
    }
}
