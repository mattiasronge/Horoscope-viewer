<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// include database and libaray files
include_once '../config/database.php';
include_once '../lib/function.php';
// instantiate database and horoscope object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$horoscope = new Horoscope($db);
// query horoscope
$stmt = $horoscope->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // horoscope array
    $horoscope_arr=array();
    $horoscope_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $horoscope_item=array(
            "no" => $no,
            "ID" => $ID,
            "dateFrom" => $dateFrom,
            "dateUntil" => $dateUntil,
            "horoscopeSign" => $horoscopeSign,
            "description" => $description,
            "created" => $created
        );
 
        array_push($horoscope_arr["records"], $horoscope_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show horoscope data in json format
    echo json_encode($horoscope_arr);
}else{
 
    // set response code - 404 Not found
    //http_response_code(404);
 
    // tell the user no horoscope found
    echo json_encode(
        array("message" => "No horoscope found.","state" =>"404")
    );
}




?>