<?php

namespace UserModel;

require_once "index.php";
require_once "UserTypes.php";

use Exception;
use Model\IndexModel;
use UserTypesModel\UserType;

use function Utils\UserUtils\getUserSession;

class User extends IndexModel
{
    function __construct()
    {
        parent::__construct("user", [
            "ID" => "id",
            "NAME" => "name",
            "EMAIL" => "email",
            "PASSWORD" => "password",
            "USER_TYPE" => "userType",
        ]);
    }

    public $name = "NAME";
    public $email = "EMAIL";
    public $password = "PASSWORD";
    public $userType = "USER_TYPE";

    public $studentType = "student";
    public $tutorType = "tutor";
    public $adminType = "admin";

    public function getUser()
    {

        $userTypeInstance = new UserType();
        require_once "../utilities/userUtils.php";

        $user = getUserSession();
        $result = [];

        if ($user == null) {
            return null;
        }

        try {
            $userId = $user["id"];
            $query = "SELECT us.*, us.id as userId, ut.* FROM $this->modelName us INNER JOIN $userTypeInstance->modelName ut ON us.userType = ut.id WHERE us.id = $userId LIMIT 1";
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
            public $name;
            public $email;
            public $userType;
            public $userId;
            public $type;

            public function __construct($result)
            {
                ["name" => $name, "email" => $email, "userType" => $userType, "userId" => $userId, "type" => $type] = $result;
                $this->name = $name;
                $this->email = $email;
                $this->userType = $userType;
                $this->userId = $userId;
                $this->type = $type;
            }
        };
    }
}
