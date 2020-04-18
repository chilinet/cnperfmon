<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../objects/inventory.php';

$database = new Database();
$db = $database->getConnection();

$inventory = new Inventory($db);

// get posted data
// $data = json_decode(file_get_contents("php://input"));
$inventory->hostname = isset($_GET['hostname']) ? $_GET['hostname'] : die();

// make sure data is not empty
if(
    //!empty($data->hostname)
    $inventory->hostname
){

    // set product property values
//    $inventory->hostname = $data->hostname;
    $inventory->status = 0;
    $inventory->create_dttm = date('Y-m-d H:i:s');
    $inventory->lastupd_dttm = date('Y-m-d H:i:s');

    // create the product
    if($inventory->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Device was added."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to add Device."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to add Device. Data is incomplete."));
}
?>
