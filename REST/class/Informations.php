<?php
class Information{
    private $dbTable = "project_information";
    public $id;
    public $competitive;
    public $activity_area;
    public $intervention_area;
    public $objective;
    public $esf;
    public $teritorial_delivery_mechanism;
    public $funding_complete;
    public function __construct($db){
        $this->conn = $db;
    }
    function read($projId){
        $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." WHERE idproject_information = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    //TODO
}
?>