<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/Database.php';
include_once '../class/Projects.php';
$database = new Database();
$db = $database->getConnection();
$projects = new Project($db);
$projects->id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$result = $projects->read();
if($result->num_rows > 0){
    $projectRecords=array();
    $projectRecords["project"]=array();
    while ($project = $result->fetch_assoc()) {
        extract($project);
        $projectDetails=array(
            "idproject" => $idproject,
            "title" => $title,
            "description" => $description,
            "contract_no" => $contract_no,
            "beneficiary_idbeneficiary" => $beneficiary_idbeneficiary,
            "fund_n_programme_idfund_n_program" => $fund_n_programme_idfund_n_program,
            "project_location_idproject_location" => $project_location_idproject_location,
            "duration_idduration" => $duration_idduration,
            "project_information_idproject_information" => $project_information_idproject_information
        );
        array_push($projectRecords["project"], $projectDetails);
    }
    http_response_code(200);
    echo json_encode($projectRecords);
}
else{
    http_response_code(404);
    echo json_encode(
    array("message" => "No item found.")
    );
}
?>