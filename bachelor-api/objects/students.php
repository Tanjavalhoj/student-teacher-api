<?php
/**
 * Created by PhpStorm.
 * User: Tanja Olsen
 * Date: 10-05-2019
 * Time: 16:00
 */

class Students{

    // database connection and table name
    private $conn;
    private $table_name = "students";

    // object properties
    public $student_id;
    public $firstname;
    public $lastname;
    public $group_id;
    public $created;
    public $updated;
    public $classyear;

    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){

        // select all query
        $query = "SELECT
                firstname, lastname, group_id, student_id
            FROM
                " . $this->table_name . "
            ORDER BY
                lastname DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // search products
    function search($keywords){

        // select query
        $query = "SELECT firstname, lastname, student_id, groups.name as class_year
                  FROM " . $this->table_name . "
                  LEFT JOIN groups ON students.group_id = groups.group_id
                  WHERE groups.name LIKE ?
                  ORDER BY groups.name ASC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // bind
        $stmt->bindParam(1, $keywords);

        // execute query
        $stmt->execute();

        return $stmt;
    }

}