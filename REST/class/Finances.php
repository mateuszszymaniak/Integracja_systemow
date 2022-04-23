<?php
class Finance{
    private $dbTable = "finances";
    public $id;
    public $total_value;
    public $eligible_expenditure;
    public $amount_cofinancing;
    public $cofinancing_rate;
    public $form;
    public function __construct($db){
        $this->conn = $db;
    }
    function read($projId){
        $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." WHERE project_idproject = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>