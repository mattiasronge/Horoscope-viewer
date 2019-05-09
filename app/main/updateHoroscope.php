<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
session_start(); 
// include database and object files
include_once '../config/database.php';
include_once '../lib/function.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare horoscope object
$horoscope = new Horoscope($db);
parse_str(file_get_contents("php://input"), $_PUT);
// get id of horoscope to be edited
$data = $_PUT;
 
// set ID property of horoscope to be edited
if(
    !empty($data['ID'])
){
	// set horoscope property values
	$horoscope->no = $data['no'];
	$horoscope->ID = $data['ID'];
    $date = substr($data['ID'], -4, 4);
    $Person = new Person($date);
    
    $horoscope->description = $Person->horoscope;
    $horoscope->dateFrom = $Person->from;
    $horoscope->dateUntil = $Person->until;
    $horoscope->horoscopeSign = $Person->horoscopeSign;    	 
	// update the horoscope
	if($horoscope->update()){
	 
	    // set response code - 200 ok
	    http_response_code(200);
	 
	    // tell the user
	    echo json_encode(array("message" => "horoscope was updated.","state" =>"good"));
	}
	 
	// if unable to update the horoscope, tell the user
	else{
	 
	    // set response code - 503 service unavailable

	    // tell the user
	    echo json_encode(array("message" => "Unable to update horoscope.","state" =>"503"));
	}
}else{
	echo json_encode(array("message" => "Unable to update horoscope.","state" =>"400"));
}

session_destroy();
?>