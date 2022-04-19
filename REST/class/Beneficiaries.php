<?php
class Beneficiary{
    private $dbTable = "beneficiary";
    public $id;
    public $name;
    public function __construct($db){
        $this->conn = $db;
    }
    function read($projId){
        $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." WHERE idbeneficiary = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    //TODO
}
?>