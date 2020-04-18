<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/inventory.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$inventory = new Inventory($db);

$inventory->id = isset($_GET['id']) ? $_GET['id'] : die();

// query products
$stmt = $inventory->getcmdlist();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // products array
    $cmd_arr=array();
    $cmd_arr["cmdlist"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $cmd_item=array(
            "id" => $id,
            "sort " => $sort,
            "cmdtype" => $cmdtype,
            "commmand" => $command,
            "value1" => $value1,
            "value2" => $value2
        );

        array_push($cmd_arr["cmdlist"], $cmd_item);
        //array_push($cmd_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($cmd_arr);
}

else{

    // set response code - 404 Not found
    http_response_code(404);

//    $cmd_arr=array();
//    $cmd_arr["cmdlist"]=array();

//    $cmd_item=array(
//            "id" => "No commmand found."
//        );

    // tell the user no products found
//    echo json_encode(
//        array("cmdlist" => "No commmand found.")
//    );
}