<?php
namespace DbModel;
use \mysqli;

class InitDb {
    private $defaultDatabase = "studenttutoring";
    private $host = '127.0.0.1';
    private $username = 'root';
    private $password = '98757682';
    private $instance;
    public $database = "";

    public function __construct($database = null)
    {
        if ($database == null) {
            $database = $this->defaultDatabase;
        }

        $this->database = $database;
        $this->instance = new mysqli($this->host, $this->username, $this->password, $this->database);
    }

    public function getConnection() {
        $conn = $this->instance;

        if ($conn->connect_error) {
            header("Location: ../onFail.html");
            exit;
        }

        return $conn;
    }

    public function closeConnection () {
        $this->instance->close();
    }
}
