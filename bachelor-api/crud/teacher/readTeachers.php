<?php
/**
 * Created by PhpStorm.
 * User: Tanja Olsen
 * Date: 10-05-2019
 * Time: 18:42
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/teachers.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$teachers = new Teachers($db);

// query products
$stmt = $teachers->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ( $num > 0 ){

    // products array
    $teachers_arr = array();
    $teachers_arr["records"] = array();

    // retrieve our table contents
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $teachers_item = array(
            "firstname" => $firstname,
            "lastname" => $lastname,
            "teacher_id" => $teacher_id,
        );

        array_push($teachers_arr["records"], $teachers_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show teachers data in json format
    echo json_encode($teachers_arr);
}

// no teacher found will be here
else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no teacher found
    echo json_encode(
        array("message" => "No teacher found.")
    );
}