<?php
class Finance{
    private $dbTable = "finances";
    public $total_value;
    public $eligible_expenditure;
    public $amount_cofinancing:
    public $cofinancing_rate;
    public $form;
    public function __construct(){
        $this->conn = $db;
    }
    function read($projId){
        $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." WHERE idproject_locationfinances
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    //TODO
}
?>