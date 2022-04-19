<?php
class Fund{
    private $dbTable = "fund_n_programme";
    public $fund;
    public $programme;
    public $priority;
    public $measure;
    public $submeasure;
    public function __construct(){
        $this->conn = $db;
    }
    function read($projId){
        $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." WHERE idfund_n_program = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    //TODO
}
?>