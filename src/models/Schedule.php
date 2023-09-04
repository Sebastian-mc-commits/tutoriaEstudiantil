<?php
namespace ScheduleModel;

require_once "index.php";
use Model\IndexModel;

class Schedule extends IndexModel {
    function __construct()
    {
        parent::__construct("schedule", [
            "ID" => "id",
            "DATE" => "date",
            "MENTORING_ID" => "mentoringId",
            "ENDS_IN" => "endsIn",
            "IS_ACCEPTED" => "isAccepted",
            "DESCRIPTION" => "description",
            "ACCESS_LINK" => "accessLink"
        ]);
    }

    public $mentoringId = "MENTORING_ID";
    public $isAccepted = "IS_ACCEPTED";
    public $endsIn = "ENDS_IN";
    public $date = "DATE";
    public $id = "ID";
    public $accessLink = "ACCESS_LINK";
    public $description = "DESCRIPTION";
    public $mentoringIdType = "mentoringId";
    public $isAcceptedType = "isAccepted";
    public $dateType = "date";
    public $endsInType = "endsIn";
    public $idType = "id";
}