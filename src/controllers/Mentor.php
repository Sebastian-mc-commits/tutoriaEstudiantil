<?php

require_once "../models/User.php";
require_once "../models/TutorFields.php";

session_start();
$userInstance = new UserModel\User();
$user = $userInstance->getUser();
$tutorInstance = new TutorFieldsModel\TutorFields();

$type = $_GET["type"];

switch ($type) {
  case "createMentorFields": {
      $data = array_merge($_POST, [
        $tutorInstance->userId => $user->userId
      ]);
      $isCreated = $tutorInstance->create($data);
      echo $isCreated;
    }
}

header("Location: ../views/index.php?tree=user&page=user-detail");
