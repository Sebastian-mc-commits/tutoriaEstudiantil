<?php
namespace UserTypesModel;

require_once "index.php";
use Model\IndexModel;

class UserType extends IndexModel {
    function __construct()
    {
        parent::__construct("userTypes", [
            "ID" => "id",
            "TYPE" => "type",
        ]);
    }

    public $type = "TYPE";
}