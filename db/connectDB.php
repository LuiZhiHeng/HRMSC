<?php
$conn = new mysqli('localhost', 'root', '', 'hrmsc');
if ($conn->connect_error) {
    throw new Exception("Connection failed: " . $conn->connect_error);
}

//set timezone
date_default_timezone_set('Asia/Kuala_Lumpur');


// 0000
function get_year_now(){
    return date('Y');
}

// 1-12
function get_month_now(){
    return date('n');
}

function get_day_now(){
    return date('d');
}

function get_date_now(){
    return date('Y-m-d');
}

function get_time_now(){
    return date('H:i:s');
}

function get_now(){
    return date('Y-m-d H:i:s');
}

function display_date(){
    return date('d/m/y');
}

function get_page(){
    return $_SERVER['PHP_SELF'];
}

function get_first_day($year, $month){
    if($month < 10) $month = "0" . $month;
    return date("Y-m-d" , strtotime($year . "-".  $month . "-01"));
}

?>