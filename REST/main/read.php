<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/Database.php';
include_once '../class/Projects.php';
include_once '../class/Duration.php';
include_once '../class/Beneficiaries.php';
include_once '../class/Funds.php';
include_once '../class/Locations.php';
include_once '../class/Finances.php';
include_once '../class/informations.php';
$database = new Database();
$db = $database->getConnection();
$projects = new Project($db);
$duration = new Duration($db);
$beneficiaries = new Beneficiary($db);
$funds = new Fund($db);
$locations = new Location($db);
$finances = new Finance($db);
$informations = new Information($db);
$projects->id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$result = $projects->read();
if($result->num_rows > 0){
    $projectRecords=array();
    $projectRecords["project"]=array();
    while ($project = $result->fetch_assoc()) {
        extract($project);
        $duration->id = (isset($duration_idduration) && $duration_idduration) ? $duration_idduration : '0';
        $beneficiaries->id = (isset($beneficiary_idbeneficiary) && $beneficiary_idbeneficiary) ? $beneficiary_idbeneficiary : '0';
        $funds->id = (isset($fund_n_programme_idfund_n_program) && $fund_n_programme_idfund_n_program) ? $fund_n_programme_idfund_n_program : '0';
        $locations->id = (isset($project_location_idproject_location) && $project_location_idproject_location) ? $project_location_idproject_location : '0';
        $finances->id = (isset($idproject) && $idproject) ? $idproject : '0';
        $informations->id = (isset($project_information_idproject_information) && $project_information_idproject_information) ? $project_information_idproject_information : '0';

        $projectDetails=array(
            "idproject" => $idproject,
            "title" => $title,
            "description" => $description,
            "contract_no" => $contract_no,
            /*"beneficiary_idbeneficiary" => $beneficiary_idbeneficiary,
            "fund_n_programme_idfund_n_program" => $fund_n_programme_idfund_n_program,
            "project_location_idproject_location" => $project_location_idproject_location,
            "duration_idduration" => $duration_idduration,
            "project_information_idproject_information" => $project_information_idproject_information*/
            "beneficiary" => array(),
            "fund_n_programme" => array(),
            "finance" => array(),
            "project_location" => array(),
            "duration" => array(),
            "project_information" => array()
        );
        array_push($projectRecords["project"], $projectDetails);

        $related_result = $beneficiaries->read($beneficiaries->id);
        if($related_result->num_rows > 0){
            while($elem = $related_result->fetch_assoc()){
                extract($elem);
                $projectRecords["beneficiary"]=array();
                $beneficiaryDetails=array(
                    "idbeneficiary" => $idbeneficiary,
                    "name" => $name
                );    
            }
            array_push($projectRecords["beneficiary"], $beneficiaryDetails);    
        }

        $related_result = $funds->read($funds->id);
        if($related_result->num_rows > 0){
            while($elem = $related_result->fetch_assoc()){
                extract($elem);
                $projectRecords["fund_n_programme"]=array();
                $fund_n_programmeDetails=array(
                    "idfund_n_program" => $idfund_n_program,
                    "fund" => $fund,
                    "programme" => $programme,
                    "priority" => $priority,
                    "measure" => $measure,
                    "submeasure" => $submeasure
                );    
            }
            array_push($projectRecords["fund_n_programme"], $fund_n_programmeDetails);    
        }
        
        $related_result = $finances->read($finances->id);
        if($related_result->num_rows > 0){
            while($elem = $related_result->fetch_assoc()){
                extract($elem);
                $projectRecords["finance"]=array();
                $financeDetails=array(
                    "idfinances" => $idfinances,
                    "total_value" => $total_value,
                    "eligible_expenditure" => $eligible_expenditure,
                    "amount_cofinancing" => $amount_cofinancing,
                    "cofinancing_rate" => $cofinancing_rate,
                    "form" => $form
                );    
            }
            array_push($projectRecords["finance"], $financeDetails);
        }
        
        $related_result = $locations->read($locations->id);
        if($related_result->num_rows > 0){
            while($elem = $related_result->fetch_assoc()){
                extract($elem);
                $projectRecords["project_location"]=array();
                $project_locationDetails=array(
                    "idproject_location" => $idproject_location,
                    "location" => $location,
                    "type" => $type
                );    
            }
            array_push($projectRecords["project_location"], $project_locationDetails);    
        }
        
        $related_result = $duration->read($duration->id);
        if($related_result->num_rows > 0){
            while($elem = $related_result->fetch_assoc()){
                extract($elem);
                $projectRecords["duration"]=array();
                $durationDetails=array(
                    "idduration" => $idduration,
                    "start" => $start,
                    "end" => $end
                );    
            }
            array_push($projectRecords["duration"], $durationDetails);    
        }
        
        $related_result = $informations->read($informations->id);
        if($related_result->num_rows > 0){
            while($elem = $related_result->fetch_assoc()){
                extract($elem);
                $projectRecords["project_information"]=array();
                $project_informationDetails=array(
                    "idproject_information" => $idproject_information,
                    "competitive_or_not" => $competitive_or_not,
                    "area_of_economic_activity" => $area_of_economic_activity,
                    "area_of_project_intervention" => $area_of_project_intervention,
                    "objective" => $objective,
                    "esf_secondary_theme" => $esf_secondary_theme,
                    "implemented_under_territorial_delivery_mechanisms" => $implemented_under_territorial_delivery_mechanisms,
                    "funding_complete" => $funding_complete
                );    
            }
            array_push($projectRecords["project_information"], $project_informationDetails);    
        }

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