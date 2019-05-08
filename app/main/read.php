<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// inkluderar databas- och libaray-filer
include_once '../config/database.php';
include_once '../lib/function.php';
// instantiate databas och horoskop objekt
$database = new Database();
$db = $database->getConnection();
 
// initiera objekt
$horoscope = new Horoscope($db);
// query horoskop
$stmt = $horoscope->read();
$num = $stmt->rowCount();
 
// kolla om mer än 0 record hittades
if($num>0){
 
    // horoskop array
    $horoscope_arr=array();
    $horoscope_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract 
        // Detta kommer att göra $ rad ['namn'] till
        // bara bara $ namn
        extract($row);
 
        $horoscope_item=array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "created" => $created
        );
 
        array_push($horoscope_arr["records"], $horoscope_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
// visa horoskopdata i json-format
    echo json_encode($horoscope_arr);
}else{
 
    // set response code - 404 Not found
    //http_response_code(404);
 
    echo json_encode(
        array("message" => "No horoscope found.","state" =>"404")
    );
}




?>