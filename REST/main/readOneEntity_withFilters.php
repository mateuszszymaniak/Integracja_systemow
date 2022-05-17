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
include_once '../class/Chart.php';
$database = new Database();
$db = $database->getConnection();
$projects = new Project($db);
$duration = new Duration($db);
$beneficiaries = new Beneficiary($db);
$funds = new Fund($db);
$locations = new Location($db);
$finances = new Finance($db);
$informations = new Information($db);
$chart = new Chart($db);
$projects->id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
$type = (isset($_GET['entity']) && $_GET['entity']) ? $_GET['entity'] : '';
$filter = (isset($_GET['filter']) && $_GET['filter']) ? $_GET['filter'] : '';
$minVal = (isset($_GET['minVal']) && $_GET['minVal']) ? $_GET['minVal'] : '';
$maxVal = (isset($_GET['maxVal']) && $_GET['maxVal']) ? $_GET['maxVal'] : '';
$minDate = (isset($_GET['minDate']) && $_GET['minDate']) ? $_GET['minDate'] : '';
$maxDate = (isset($_GET['maxDate']) && $_GET['maxDate']) ? $_GET['maxDate'] : '';
$result = $projects->read_nFilter($filter, $minVal, $maxVal, $minDate, $maxDate, $chart);
if($result->num_rows > 0){
	//var_dump($result->num_rows);
    $projectRecords=array();
    $projectRecords["project"]=array();
    $projectRecords["beneficiary"]=array();
    $projectRecords["fund_n_programme"]=array();
    $projectRecords["finance"]=array();
    $projectRecords["project_location"]=array();
    $projectRecords["duration"]=array();
    $projectRecords["project_information"]=array();   
	$projectRecords["chart"]=array();	
    while ($project = $result->fetch_assoc()) {
        extract($project);
        $duration->id = (isset($duration_idduration) && $duration_idduration) ? $duration_idduration : '0';
        $beneficiaries->id = (isset($beneficiary_idbeneficiary) && $beneficiary_idbeneficiary) ? $beneficiary_idbeneficiary : '0';
        $funds->id = (isset($fund_n_programme_idfund_n_program) && $fund_n_programme_idfund_n_program) ? $fund_n_programme_idfund_n_program : '0';
        $locations->id = (isset($project_location_idproject_location) && $project_location_idproject_location) ? $project_location_idproject_location : '0';
        $finances->id = (isset($idproject) && $idproject) ? $idproject : '0';
        $informations->id = (isset($project_information_idproject_information) && $project_information_idproject_information) ? $project_information_idproject_information : '0';
		$chart->filter = (isset($filter) && $filter) ? $filter : '0';

        /*$projectDetails=array(
            "idproject" => $idproject,
            "title" => $title,
            "description" => $description,
            "contract_no" => $contract_no
        );
        array_push($projectRecords["project"], $projectDetails);*/
        switch($type){
            case 'beneficiary': {
                $related_result = $beneficiaries->read($beneficiaries->id);
                if($related_result->num_rows > 0){
                    while($elem = $related_result->fetch_assoc()){
                        extract($elem);
                        $beneficiaryDetails=array(
                            "idbeneficiary" => $idbeneficiary,
                            "name" => $name
                        );    
                        array_push($projectRecords["beneficiary"], $beneficiaryDetails);   
                    }
                    break; 
                }
            }
            case 'fund': {
                $related_result = $funds->read($funds->id);
                if($related_result->num_rows > 0){
                    while($elem = $related_result->fetch_assoc()){
                        extract($elem);
                        $fund_n_programmeDetails=array(
                            "idfund_n_program" => $idfund_n_program,
                            "fund" => $fund,
                            "programme" => $programme,
                            "priority" => $priority,
                            "measure" => $measure,
                            "submeasure" => $submeasure
                        );    
                        array_push($projectRecords["fund_n_programme"], $fund_n_programmeDetails);    

                    }
                    break;
                }
            }
            case 'finance': {
                $related_result = $finances->read($finances->id);
                if($related_result->num_rows > 0){
                    while($elem = $related_result->fetch_assoc()){
                        extract($elem);
                        $financeDetails=array(
                            "idfinances" => $idfinances,
                            "total_value" => $total_value,
                            "eligible_expenditure" => $eligible_expenditure,
                            "amount_cofinancing" => $amount_cofinancing,
                            "cofinancing_rate" => $cofinancing_rate,
                            "form" => $form
                        );    
                        array_push($projectRecords["finance"], $financeDetails);
                    }
                    break;
                }
            }
            case 'location': {
                $related_result = $locations->read($locations->id);
                if($related_result->num_rows > 0){
                    while($elem = $related_result->fetch_assoc()){
                        extract($elem);
                        $project_locationDetails=array(
                            "idproject_location" => $idproject_location,
                            "location_place" => $location_place,
                            "location_type" => $location_type
                        );    
                        array_push($projectRecords["project_location"], $project_locationDetails);  
                    }
                    break;  
                }  
            }
            case 'duration': {
                $related_result = $duration->read($duration->id);
				var_dump($related_result);
                if($related_result->num_rows > 0){
                    while($elem = $related_result->fetch_assoc()){
                        extract($elem);
                        $durationDetails=array(
                            "idduration" => $idduration,
                            "start" => $start,
                            "end" => $end
                        );
                        array_push($projectRecords["duration"], $durationDetails);
                    }
                    break;
                }
            }
            case 'information': {
                $related_result = $informations->read($informations->id);
                if($related_result->num_rows > 0){
                    while($elem = $related_result->fetch_assoc()){
                        extract($elem);
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
                        array_push($projectRecords["project_information"], $project_informationDetails);  
                    }
                    break;  
                } 
            }
			case 'chart': {
                $related_result = $chart->read($chart->filter);
                if($related_result->num_rows > 0 ){
					$projectRecords["chart"] = array_fill(0, $related_result->num_rows,'');
                    while($elem = $related_result->fetch_assoc()){
                        extract($elem);
                        $chart_informationDetails=array(
                            "idproject" => $idproject,
                            "start" => $start,
                            "location_place" => $location_place,
                            "total_value" => $total_value
                        );    
                        array_push($projectRecords["chart"], $chart_informationDetails);
                    }
                    break;  
                }
            }
            default: {
                http_response_code(404);
                echo json_encode(
                array("message" => "No item found.xD")
                );
                exit();
            }
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