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
    function read_nFilter($filter, $minVal, $maxVal, $minDate, $maxDate) {
        $filter = "%".$filter."%";
        if($minDate != '' && $maxDate != '') {
            $minDate = substr($minDate, 1);
            $minDate = strtotime($minDate);
            $maxDate = strtotime($maxDate);
            $minDate = date('Y-m-d', $minDate);
            $maxDate = date('Y-m-d', $maxDate);
            if($minVal != '' && $maxVal != ''){
                if($this->id) {
                    $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." INNER JOIN project_location ON (".$this->dbTable.
                    ".project_location_idproject_location = project_location.idproject_location)  INNER JOIN finances ON (".$this->dbTable.
                    ".idproject = finances.project_idproject) INNER JOIN duration ON (".$this->dbTable.
                    ".duration_idduration = duration.idduration)
                    WHERE project.idproject = ? AND (project_location.location_place LIKE ? OR project_location.location_place LIKE '%Cały Kraj%') 
                    AND (finances.total_value BETWEEN ? AND ?) AND (duration.start BETWEEN ? AND ?)");
                    $stmt->bind_param("isiiss", $this->id, $filter, $minVal, $maxVal, $minDate, $maxDate);
                } else {
                    $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." INNER JOIN project_location ON (".$this->dbTable.
                    ".project_location_idproject_location = project_location.idproject_location) INNER JOIN finances ON (".$this->dbTable.
                    ".idproject = finances.project_idproject) INNER JOIN duration ON (".$this->dbTable.
                    ".duration_idduration = duration.idduration)
                    WHERE (project_location.location_place LIKE ? OR project_location.location_place LIKE '%Cały Kraj%') AND (finances.total_value BETWEEN ? AND ?)  
                    AND (duration.start BETWEEN ? AND ?)");
                    $stmt->bind_param("siiss", $filter, $minVal, $maxVal, $minDate, $maxDate);
                }
            }
            else {
                if($this->id) {
                    $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." INNER JOIN project_location ON (".$this->dbTable.
                    ".project_location_idproject_location = project_location.idproject_location) INNER JOIN duration ON (".$this->dbTable.
                    ".duration_idduration = duration.idduration)
                    WHERE project.idproject = ? AND (project_location.location_place LIKE ? OR project_location.location_place LIKE '%Cały Kraj%') 
                    AND (duration.start BETWEEN ? AND ?)");
                    $stmt->bind_param("isss", $this->id, $filter, $minDate, $maxDate);
                } else {
                    $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." INNER JOIN project_location ON (".$this->dbTable.
                    ".project_location_idproject_location = project_location.idproject_location) INNER JOIN duration ON (".$this->dbTable.
                    ".duration_idduration = duration.idduration)
                    WHERE (project_location.location_place LIKE ? OR project_location.location_place LIKE '%Cały Kraj%') AND (duration.start BETWEEN ? AND ?)");
                    $stmt->bind_param("sss", $filter, $minDate, $maxDate);
                }
            }
        }
        else {
            if($minVal != '' && $maxVal != ''){
                if($this->id) {
                    $stmt = $this->conn->prepare("SELECT * FROM ".$this->dbTable." INNER JOIN project_location ON (".$this->dbTable.
                    ".project_location_idproject_location = project_location.idproject_location)  INNER JOIN finances ON (".$this->dbTable.
                    ".idproject = finances.project_idproject)
                    WHERE project.idproject = ? AND (project_location.location_place LIKE ? OR project_location.location_place LIKE '%Cały Kraj%') 
                    AND (finances.total_value BETWEEN ? AND ?)");
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
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>