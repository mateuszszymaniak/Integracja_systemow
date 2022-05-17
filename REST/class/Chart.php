<?php
class Chart{
    public $idproject;
    public $start;
    public $location_place;
    public $total_value;
    public function __construct($db){
        $this->conn = $db;
    }
    function read($projId){
        $stmt = $this->conn->prepare("SELECT project.idproject, duration.start, project_location.location_place, finances.total_value FROM (((project INNER JOIN finances ON project.idproject = finances.idfinances) INNER JOIN duration ON project.idproject = duration.idduration) INNER JOIN project_location ON project.idproject = project_location.idproject_location) WHERE project_location.location_place LIKE '%".$this->filter."%' ORDER BY duration.start ASC;");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>