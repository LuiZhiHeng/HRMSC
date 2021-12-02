<?php //checkSession.php
session_start();

$logged_user_type = 0;
$logged_user_id = 0;
$logged_user_shortname = "";

// set logged user type
if(isset($_SESSION['admin'])) $logged_user_type = 1;
elseif(isset($_SESSION['employee'])) $logged_user_type = 2;
else $logged_user_type = 0;

// set logged user id
if(isset($_SESSION['userId'])) $logged_user_id = $_SESSION['userId'];
else $logged_user_id = 0;

//set logged user short name
if(isset($_SESSION['admin'])) $logged_user_shortname = $_SESSION['admin'];
elseif(isset($_SESSION['employee'])) $logged_user_shortname = $_SESSION['employee'];
else $logged_user_shortname = "";

// check session user
if(!isset($_SESSION['userId']) && basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'recruitment.php' ) {
    if(isset($_GET['punch'])) set_session_page("punch", $_GET['punch']);
    header('Location: login.php');
}

// check session page
function check_session_page(){
    if(isset($_SESSION['page'])){
        $pageSession = $_SESSION['page'];
        unset($_SESSION['page']);
        header('Location: ' . $pageSession);
    }
}

function set_session_page($get, $value){
    if($get == NULL && $value == NULL) $_SESSION['page'] = $_SERVER['PHP_SELF'];
    elseif($get != NULL && $value == NULL) $_SESSION['page'] = $_SERVER['PHP_SELF'] . "?" . $get . "=";
    else $_SESSION['page'] = $_SERVER['PHP_SELF'] . "?" . $get . "=" . $value;
}

function set_session($shortName, $userType, $userId){
    $_SESSION['userId'] = $userId;
    if($userType == 1) $_SESSION['admin'] = $shortName;
    elseif($userType == 2) $_SESSION['employee'] = $shortName;
}

function delete_session(){
    if(isset($_SESSION['admin'])) unset($_SESSION['admin']);
    if(isset($_SESSION['employee'])) unset($_SESSION['employee']);
    if(isset($_SESSION['userId'])) unset($_SESSION['userId']);
}

function get_logged_user_id(){
    global $logged_user_id;
    return $logged_user_id;
}

function get_logged_user_type(){
    global $logged_user_type;
    return $logged_user_type;
}

function get_logged_user_shortname(){
    global $logged_user_shortname;
    return $logged_user_shortname;
}
?>
