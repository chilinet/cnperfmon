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
include_once '../objects/results.php';

$database = new Database();
$db = $database->getConnection();

$results = new Results($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->id) &&
    !empty($data->sort) &&
    !empty($data->result)
){

    // set product property values
    $results->id = $data->id;
    $results->sort = $data->sort;
    $results->cmdtype = $data->cmdtype;
    $results->command = $data->command;
    $results->result = $data->result;
    $results->cmd_dttm = date('Y-m-d H:i:s');

    // create the product
    if($results->push()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Result was added."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to add result."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to add result. Data is incomplete."));
}
?>
