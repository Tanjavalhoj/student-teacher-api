<?php
/**
 * Created by PhpStorm.
 * User: Tanja Olsen
 * Date: 10-05-2019
 * Time: 15:57
 */

// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// home page url
$home_url="http://localhost/bachelor-api/";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;