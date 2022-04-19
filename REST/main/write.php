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

$cities->name = (isset($_POST['Name']) && $_POST['Name']) ? $_POST['Name'] : '0';
$cities->countrycode = (isset($_POST['CountryCode']) && $_POST['CountryCode']) ? $_POST['CountryCode'] : '0';
$cities->district = (isset($_POST['District']) && $_POST['District']) ? $_POST['District'] : '0';
$cities->population = (isset($_POST['Population']) && $_POST['Population']) ? $_POST['Population'] : '0';
$result = $cities->create();
if($result == 0){
    http_response_code(201);
    echo json_encode(array("message" => "Item was created successfully."));
}
else{
    http_response_code(400);
    echo json_encode(
    array("message" => "Item not created.")
    );
}
?>