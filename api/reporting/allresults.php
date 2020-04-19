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
        //var_dump($Obj);

        if (strpos($result, 'error') == 0) {

        $localhost = $Obj["start"]["connected"][0]["local_host"];
        $remotehost = $Obj["start"]["connecting_to"]["host"];
        $remoteport = $Obj["start"]["connecting_to"]["port"];

        $version = $Obj["start"]["version"];
        $system_info = $Obj["start"]["system_info"];
        $timestamp = $Obj["start"]["timestamp"]["time"];
        //echo date('Y-m-d H:i:s',strtotime($timestamp) ). PHP_EOL;

        $send_bytes = $Obj["end"]["streams"][0]["sender"]["bytes"];
        $send_bitsec = $Obj["end"]["streams"][0]["sender"]["bits_per_second"];
        $received_bytes = $Obj["end"]["streams"][0]["receiver"]["bytes"];
        $received_bitsec = $Obj["end"]["streams"][0]["receiver"]["bits_per_second"];

        $reporting->id = $id;
        $reporting->sort = $sort;
        $reporting->cmdid = $cmdid;
        $reporting->localhost = $localhost;
        $reporting->remotehost = $remotehost;
        $reporting->remoteport = $remoteport;
        $reporting->send_bytes = floatval($send_bytes);
        $reporting->send_bitsec = floatval($send_bitsec);
        $reporting->received_bytes = floatval($received_bytes);
        $reporting->received_bitsec = floatval($received_bitsec);
        $reporting->version = $version;
        $reporting->system_info = $system_info;
        $reporting->timestamp = date('Y-m-d H:i:s',strtotime($timestamp) );

        if ($reporting->insertresult()) {
            $reporting->setarchiv();
        //    echo "Okay";
        } else {
        //    echo "Nicht okay";

        }
        } else {
            $reporting->id = $id;
            $reporting->sort = $sort;
            $reporting->cmdid = $cmdid;
            $reporting->setarchiv();
        }
    }
}

else{

    // set response code - 404 Not found
   // http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}