<?php

namespace TutorFieldsModel;

require_once "index.php";
require_once "User.php";
require_once "Specializations.php";

use Exception;
use UserModel\User;
use SpecializationsModel\Specialization;

use Model\IndexModel;

class TutorFields extends IndexModel
{
  function __construct()
  {
    parent::__construct("tutorFields", [
      "ID" => "id",
      "USER_ID" => "userId",
      "SPECIALIZATION" => "specialization",
    ]);
  }

  public $specialization = "SPECIALIZATION";
  public $userId = "USER_ID";

  public function getTutor()
  {

    $userInstance = new User();
    $user = $userInstance->getUser();
    $specializationI = new Specialization();
    $result = [];

    if ($user == null) {
      return null;
    }

    try {
      $userId = $user->userId;
      $query = "SELECT t.specialization as specializationId,"
        .
        " t.id as tutorId, us.id as userId, us.name as userName, us.*, s.name as specialization"
        .
        " FROM $this->modelName t INNER JOIN $userInstance->modelName us ON us.id = t.userId"
        .
        " INNER JOIN $specializationI->modelName s ON s.id = t.specialization WHERE us.id = $userId LIMIT 1";
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
      public $tutorId;
      public $userId;
      public $userName;
      public $email;
      public $specialization;
      public $specializationId;

      public function __construct($result)
      {
        [
          "userName" => $userName,
          "email" => $email,
          "specialization" => $specialization,
          "specializationId" => $specializationId,
          "tutorId" => $tutorId,
          "userId" => $userId,
        ] = $result;
        $this->userName = $userName;
        $this->email = $email;
        $this->specializationId = $specializationId;
        $this->specialization = $specialization;
        $this->tutorId = $tutorId;
        $this->userId = $userId;
      }
    };
  }
}
