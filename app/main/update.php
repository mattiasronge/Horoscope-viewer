<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
session_start(); 
// Inkludera databas och filer
include_once '../config/database.php';
include_once '../lib/function.php';
 
// skapa databas connection
$database = new Database();
$db = $database->getConnection();
 
// förbered horoskop objekt
$horoscope = new Horoscope($db);
parse_str(file_get_contents("php://input"), $_PUT);
// få id
$data = $_PUT;
 
// set ID 
if(
    !empty($data['name'])
){
	// set horoscope property values
	$horoscope->id = $data['id'];
	$horoscope->name = $data['name'];
    $date = substr($data['name'], -4, 4);
    $Person = new Person($date);
    
    $horoscope->description = $Person->horoscope;	 
	// update 
	if($horoscope->update()){
	 
	    // set response code - 200 ok
	    http_response_code(200);
	 
	    // interact with user
	    echo json_encode(array("message" => "horoscope was updated.","state" =>"good"));
	}
	 
	// Om uppdateringen inte gick lyckat
	else{
	 
	    // set response code - 503 service unavailable

	    // interact with user
	    echo json_encode(array("message" => "Unable to update horoscope.","state" =>"503"));
	}
}else{
	echo json_encode(array("message" => "Unable to update horoscope.","state" =>"400"));
}

session_destroy();
?>