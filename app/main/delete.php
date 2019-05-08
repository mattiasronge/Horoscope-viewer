<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Inkludera databas och objektfil
include_once '../config/database.php';
include_once '../lib/function.php';
session_start(); 
// Hämta databasanslutning
$database = new Database();
$db = $database->getConnection();
 
// Förbered horoskopobjekt
$horoscope = new Horoscope($db);
if(
    !empty($_SESSION['id'])
){ 
// Ange horoskop-id som ska raderas
$horoscope->id = $_SESSION["id"];
	 
// radera horoskopet
if($horoscope->delete()){
	 
	    // set response code - 200 ok
	    http_response_code(200);
	 
	    // interact
	    echo json_encode(array("message" => "horoscope was deleted.","state" =>"good"));
	}
	 
// om det inte går att ta bort horoskopet
else{
	 
	    // set response code - 503 service unavailable
	    // http_response_code(503);
	 
	    // interact
	    echo json_encode(array("message" => "Unable to delete horoscope.","state" =>"503"));
	}
}else{
		echo json_encode(array("message" => "Unable to delete horoscope.","state" =>"400"));
}
session_destroy();
?>