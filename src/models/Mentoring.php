<?php

namespace MentoringModel;

require_once "index.php";
require_once "User.php";
require_once "TutorFields.php";
require_once "Specializations.php";
require_once "Schedule.php";
require_once "MentoringUserRate.php";

use Exception;
use Model\IndexModel;
use RateModel\MentoringUserRate;
use ScheduleModel\Schedule;
use SpecializationsModel\Specialization;
use TutorFieldsModel\TutorFields;
use UserModel\User;

class Mentoring extends IndexModel
{
    public function __construct()
    {
        parent::__construct("mentoring", [
            "ID" => "id",
            "MENTORING_NAME" => "mentoringName",
            "DESCRIPTION" => "description",
            "TUTOR_CREATOR" => "tutorCreator",
        ]);
    }

    public $mentoringName = "MENTORING_NAME";
    public $description = "DESCRIPTION";
    public $tutorCreator = "TUTOR_CREATOR";
    public $id = "ID";

    public $idType = "id";
    public $mentoringNameType = "mentoringName";
    public $descriptionType = "description";
    public $userNameTypeX = "userName";
    public $userSpecializationX = "specialization";

    private function classAndTutorQuery($tutorM, $userM, $specializationM)
    {
        return "SELECT us.name as userName, sp.name as specialization, mn.*"
            .
            " FROM $this->modelName mn INNER JOIN $tutorM t"
            .
            " ON t.id = mn.tutorCreator INNER JOIN $userM us"
            .
            " ON us.id = t.userId INNER JOIN $specializationM sp"
            .
            " ON t.specialization = sp.id";
    }

    public function getMentoringAndAndTutorFields()
    {
        $userI = new User();
        $tutorI = new TutorFields();
        $tutor = $tutorI->getTutor();
        $where = "";

        if (!empty($tutor) || $tutor != null) {

            $where = " WHERE t.id != $tutor->tutorId";
        }
        $specializationI = new Specialization();

        $query = $this->classAndTutorQuery($tutorI->modelName, $userI->modelName, $specializationI->modelName) . $where;

        $result = $this->getConnection()->query($query);
        $this->closeConnection();

        return $result;
    }

    public function getMentoringAndTutorById($id)
    {

        $userI = new User();
        $tutorI = new TutorFields();
        $specializationI = new Specialization();

        $query = $this->classAndTutorQuery($tutorI->modelName, $userI->modelName, $specializationI->modelName);

        $query = $query . " WHERE mn.id = $id";

        try {
            $result = $this->getConnection()->query($query);
            if (empty($result) || $result->num_rows == 0) {
                return null;
            }
            $result = $result->fetch_assoc();
        } catch (Exception $e) {
            return null;
        }

        return new class($result)
        {
            public $specialization;
            public $userName;
            public $mentoringName;
            public $description;
            public $tutorCreator;
            public $id;

            public function __construct($result)
            {

                [
                    "specialization" => $specialization,
                    "userName" => $userName,
                    "mentoringName" => $mentoringName,
                    "description" => $description,
                    "tutorCreator" => $tutorCreator,
                    "id" => $id,
                ] = $result;

                $this->specialization = $specialization;
                $this->userName = $userName;
                $this->mentoringName = $mentoringName;
                $this->description = $description;
                $this->tutorCreator = $tutorCreator;
                $this->id = $id;
            }
        };
    }

    private function mentoringAndScheduleQuery ($scheduleI, $rateI, $userI, $whereStatement = null) {

        return "SELECT mt.mentoringName, mt.description AS mentoringDescription,"
        .
        " rt.comment AS userComment, rt.rate AS userRate, rt.score AS userScore,"
        .
        " s.date, s.endsIn, s.accessLink, s.isAccepted, s.description AS scheduleDescription, s.id AS scheduleId,"
        .
        " us.name AS userName, us.email AS userEmail"
        .
        " FROM $this->modelName mt"
        .
        " INNER JOIN $scheduleI->modelName s ON mt.id = s.mentoringId"
        .
        " INNER JOIN $rateI->modelName rt ON rt.scheduleId = s.id"
        .
        " INNER JOIN $userI->modelName us ON us.id = rt.userId"
        . $whereStatement;
    }

    public function getClassesUsersAndSchedulesNotAccepted($getById = null)
    {
        $scheduleI = new Schedule();
        $rateI = new MentoringUserRate();
        $userI = new User();
        $tutorI = new TutorFields();
        $tutor = $tutorI->getTutor();

        if (empty($tutor)) {
            return null;
        }

        $tutorId = $tutor->tutorId;

        $whereStatement = "";
        if (!empty($getById)) {
            $whereStatement = " AND mt.id = $getById";
        }
        $whereStatement .= " WHERE s.isAccepted = 0 AND mt.tutorCreator = $tutorId";
        $query = $this->mentoringAndScheduleQuery($scheduleI, $rateI, $userI, $whereStatement);
        $result = [];

        try {
            $result = $this->getConnection()->query($query);
            if (empty($result) || $result->num_rows == 0) {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }


        return new class($result) extends ModelUtilities
        {
            public $result;
            public function __construct($result)
            {
                parent::__construct();
                $this->result = $result;
            }
        };
    }

    public function getCurrentDateClasses () {
        $scheduleI = new Schedule();
        $currentDateTime = date('Y-m-d');
        $query = "SELECT mt.*, mt.description AS mentoringDescription, sh.*, sh.description AS scheduleDescription FROM $this->modelName mt"
        .
        " INNER JOIN $scheduleI->modelName sh"
        .
        " ON sh.mentoringId = mt.id"
        .
        " WHERE sh.date = '$currentDateTime'";

        $result = $this->getConnection()->query($query);

        $this->closeConnection();
        return $result;
    }
}
abstract class ModelUtilities
{
    public $mentoringDescription = "mentoringDescription";
    public $scheduleId = "scheduleId";
    public $mentoringName = "mentoringName";
    public $userComment = "userComment";
    public $userRate = "userRate";
    public $userScore = "userScore";
    public $date = "date";
    public $endsIn = "endsIn";
    public $accessLink = "accessLink";
    public $isAccepted = "isAccepted";
    public $scheduleDescription = "scheduleDescription";
    public $userName = "userName";
    public $userEmail = "userEmail";

    public function __construct($result = null)
    {
        if (!empty($result) || isset($result)) {
            $result = $result->fetch_assoc();
            [
                "mentoringDescription" => $mentoringDescription,
                "mentoringName" => $mentoringName,
                "userComment" => $userComment,
                "userRate" => $userRate,
                "userScore" => $userScore,
                "date" => $date,
                "endsIn" => $endsIn,
                "accessLink" => $accessLink,
                "isAccepted" => $isAccepted,
                "scheduleDescription" => $scheduleDescription,
                "userName" => $userName,
                "userEmail" => $userEmail,
                "scheduleId" => $scheduleId,
            ] = $result;


            $this->mentoringDescription = $mentoringDescription;
            $this->mentoringName = $mentoringName;
            $this->userComment = $userComment;
            $this->userRate = $userRate;
            $this->userScore = $userScore;
            $this->date = $date;
            $this->endsIn = $endsIn;
            $this->accessLink = $accessLink;
            $this->isAccepted = $isAccepted;
            $this->scheduleDescription = $scheduleDescription;
            $this->userName = $userName;
            $this->userEmail = $userEmail;
            $this->scheduleId = $scheduleId;
        }
    }
}
