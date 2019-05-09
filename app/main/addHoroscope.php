<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate horoscope object
include_once '../lib/function.php';
 
$database = new Database();
$db = $database->getConnection();
 
$horoscope = new Horoscope($db);
 
// get posted data
// $data = json_decode(file_get_contents("php://input"));
$data = $_POST;
 
// make sure data is not empty

if(
    !empty($data['ID'])
){
 
    // set horoscope property values
    $horoscope->ID = $data['ID'];
    $date = substr($data['ID'], -4, 4);
    $Person = new Person($date);
    
    $horoscope->description = $Person->horoscope;
    $horoscope->dateFrom = $Person->from;
    $horoscope->dateUntil = $Person->until;
    $horoscope->horoscopeSign = $Person->horoscopeSign;
    $horoscope->created = date('Y-m-d H:i:s');

    // create the horoscope
    if($horoscope->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "horoscope was created.","state" =>"good"));
    }
 
    // if unable to create the horoscope, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create horoscope.","state" =>"503"));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    // http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create horoscope. Data is incomplete.","state" =>"400"));
}
?>