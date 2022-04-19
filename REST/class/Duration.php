<?php
class Duration{
    private $dbTable = "duration";
    public $id;
    public $start;
    public $end;
    public function __construct($db){
        $this->conn = $db;
    }
    function read($projId){
        $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." WHERE idduration = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>