<?php
/**
 * Created by PhpStorm.
 * User: Tanja Olsen
 * Date: 10-05-2019
 * Time: 16:00
 */

class Teachers{

    // database connection and table name
    private $conn;
    private $table_name = "teachers";

    // object properties
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $mobilenumber;
    public $created;
    public $updated;


    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){

        // select all query
        $query = "SELECT
                firstname, lastname, teacher_id
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
        $query = "SELECT firstname, lastname, teachers.teacher_id
                  FROM " . $this->table_name . "
                  LEFT JOIN teach_subject ON teachers.teacher_id = teach_subject.teacher_id
                  LEFT JOIN subject ON teach_subject.subject_id = subject.subject_id
                  WHERE subject.title LIKE ?
                  ORDER BY lastname DESC";

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