<?php
class Project{
    private $dbTable = "project";
    public $id;
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
        if($this->id) {
            $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." WHERE idproject = ?");
            $stmt->bind_param("i", $this->id);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    function read_nFilter($filter, $minVal, $maxVal) {
        $filter = "%".$filter."%";
        if($minVal != '' && $maxVal != ''){
            if($this->id) {
                $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." INNER JOIN project_location ON (".$this->dbTable.
                ".project_location_idproject_location = project_location.idproject_location)  INNER JOIN finances ON (".$this->dbTable.
                ".idproject = finances.project_idproject)
                WHERE project.idproject = ? AND (project_location.location_place LIKE ? OR project_location.location_place LIKE '%Cały Kraj%') AND (finances.total_value BETWEEN ? AND ?)");
                $stmt->bind_param("isii", $this->id, $filter, $minVal, $maxVal);
            } else {
                $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." INNER JOIN project_location ON (".$this->dbTable.
                ".project_location_idproject_location = project_location.idproject_location) INNER JOIN finances ON (".$this->dbTable.
                ".idproject = finances.project_idproject)
                WHERE (project_location.location_place LIKE ? OR project_location.location_place LIKE '%Cały Kraj%') AND (finances.total_value BETWEEN ? AND ?)");
                $stmt->bind_param("sii", $filter, $minVal, $maxVal);
            }  
        }
        else {
            if($this->id) {
                $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." INNER JOIN project_location ON (".$this->dbTable.
                ".project_location_idproject_location = project_location.idproject_location) 
                WHERE project.idproject = ? AND (project_location.location_place LIKE ? OR project_location.location_place LIKE '%Cały Kraj%')");
                $stmt->bind_param("is", $this->id, $filter);
            } else {
                $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." INNER JOIN project_location ON (".$this->dbTable.
                ".project_location_idproject_location = project_location.idproject_location) 
                WHERE project_location.location_place LIKE ? OR project_location.location_place LIKE '%Cały Kraj%'");
                $stmt->bind_param("s", $filter);
            }    
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>