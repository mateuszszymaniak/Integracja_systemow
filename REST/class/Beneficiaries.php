<?php
class Beneficiary{
    private $dbTable = "beneficiary";
    public $name;
    public function __construct(){
        $this->conn = $db;
    }
    function read($projId){
        $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." WHERE odbeneficiary = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    //TODO
}
?>