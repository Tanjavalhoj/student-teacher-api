<?php
/**
 * Created by PhpStorm.
 * User: Tanja Olsen
 * Date: 10-05-2019
 * Time: 16:09
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../../config/core.php';
include_once '../../config/database.php';
include_once '../../objects/students.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$students = new Students($db);

// get keywords
$keywords = isset($_GET["class"]) ? $_GET["class"] : "";

// query students
$stmt = $students->search($keywords);
$num = $stmt->rowCount();

// check if more than 0 record found
if($num > 0){

    // products array
    $students_arr = array();
    $students_arr["records"] = array();

    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $students_item = array(
            "firstname" => $firstname,
            "lastname" => $lastname,
            "student_id" => $student_id,
        );

        array_push($students_arr["records"], $students_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data
    echo json_encode($students_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No student found.")
    );
}