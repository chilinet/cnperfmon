<?php
// required headers
//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/reporting.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$reporting = new Reporting($db);

// query products
$stmt = $reporting->allresults();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $Obj = json_decode($result, true);
        var_dump($Obj);

 //       $reporting_item=array(
 //           "id" => $id,
 //           "sort" => $sort,
 //           "cmdid" => $cmdid,
 //           "cmdtype" => $cmdtype,
 //           "command" => $command,
 //           "result" => $result,
 //           "cmd_dttm" => $cmd_dttm
 //       );

 //       array_push($products_arr["records"], $product_item);
    }

    // set response code - 200 OK
 //   http_response_code(200);

    // show products data in json format
 //   echo json_encode($products_arr);
}

else{

    // set response code - 404 Not found
   // http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}