<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../lib/function.php';
session_start(); 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare horoscope object
$horoscope = new Horoscope($db);
if(
    !empty($_SESSION['id'])
){ 
	// set horoscope id to be deleted
	$horoscope->no = $_SESSION["id"];
	 
	// delete the horoscope
	if($horoscope->delete()){
	 
	    // set response code - 200 ok
	    http_response_code(200);
	 
	    // tell the user
	    echo json_encode(array("message" => "horoscope was deleted.","state" =>"good"));
	}
	 
	// if unable to delete the horoscope
	else{
	 
	    // set response code - 503 service unavailable
	    // http_response_code(503);
	 
	    // tell the user
	    echo json_encode(array("message" => "Unable to delete horoscope.","state" =>"503"));
	}
}else{
		echo json_encode(array("message" => "Unable to delete horoscope.","state" =>"400"));
}
session_destroy();
?>