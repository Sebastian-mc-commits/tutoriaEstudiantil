<?php
namespace SpecializationsModel;

require_once "index.php";
use Model\IndexModel;

class Specialization extends IndexModel {
    function __construct()
    {
        parent::__construct("available_specializations", [
            "ID" => "id",
            "NAME" => "name",
        ]);
    }

    public $name = "NAME";

    public $Db_name = "name";
    public $Db_id = "id";

}