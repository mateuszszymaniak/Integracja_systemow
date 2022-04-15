<?php
class Project{
    private $dbTable = "project";
    public $title;
    public $description;
    public $contract_no;
    public $beneficiary;
    public $fund;
    public $location;
    public $duration;
    public $information;
    public function __construct($db){
        $this->conn = $db;
    }
    function read(){
        //TODO
    }
    function write(){
        //TODO
    }
}
?>