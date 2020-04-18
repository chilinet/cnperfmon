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

// read the details of product to be edited
$inventory->gethostid();

if($inventory->id!=null){
    // create array
    $inventory_arr = array(
        "id" =>  $inventory->id
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($inventory_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Hostname does not exist."));
}

?>
