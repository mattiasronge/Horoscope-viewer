<?php
//  headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// hämta databas connection
include_once '../config/database.php';
 
// instansiera horoskop objekt
include_once '../lib/function.php';
 
$database = new Database();
$db = $database->getConnection();
 
$horoscope = new Horoscope($db);
 
// posted data
// $data = json_decode(file_get_contents("php://input"));
$data = $_POST;
 
// Kolla så att det inte är tomt

if(
    !empty($data['name'])
){
 
    // horoskop egenskaper värden
    $horoscope->name = $data['name'];
    $date = substr($data['name'], -4, 4);
    $Person = new Person($date);
    
    $horoscope->description = $Person->horoscope;
    $horoscope->created = date('Y-m-d H:i:s');
 
    // skapa horoskop
    if($horoscope->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // interact
        echo json_encode(array("message" => "horoscope was created.","state" =>"good"));
    }
 
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // interact
        echo json_encode(array("message" => "Unable to create horoscope.","state" =>"503"));
    }
}

else{
 
    // set response code - 400 bad request
    // http_response_code(400);
 
    // interact
    echo json_encode(array("message" => "Unable to create horoscope. Data is incomplete.","state" =>"400"));
}
?>