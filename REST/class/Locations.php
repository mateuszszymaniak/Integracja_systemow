<?php
class Location{
    private $dbTable = "project_location";
    public $id;
    public $location;
    public $type;
    public function __construct($db){
        $this->conn = $db;
    }
    function read($projId){
        $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." WHERE idproject_location = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    //TODO
}
?>