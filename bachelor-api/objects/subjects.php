<?php
/**
 * Created by PhpStorm.
 * User: Tanja Olsen
 * Date: 10-05-2019
 * Time: 16:01
 */

class Subject{

    // database connection and table name
    private $conn;
    private $table_name = "subject";

    // object properties
    public $id;
    public $title;
    public $created;
    public $updated;

    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){

        // select all query
        $query = "SELECT
                title
            FROM
                " . $this->table_name . "
            ORDER BY
                title DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }




    // search products
    function search($keywords){

        // select all query
        $query = "SELECT title as subjects
                  FROM " . $this->table_name . "
                  WHERE title LIKE ?
                  ORDER BY groups.name DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // bind
        $stmt->bindParam(1, $keywords);

        // execute query
        $stmt->execute();

        return $stmt;
    }

}