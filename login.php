<?php
include('layout/initial.php');
start_HTML_header("Login");

require_once('function/verifyUser.php');
require_once('function/forgotPassword.php');

if(isset($_SESSION["login"])){
    if($_SESSION["login"] == 0) echo '<script>swal("Invalid email or password", "Please Try Again!", "error");</script>';
    unset($_SESSION["login"]);
}

if(!isset($_SESSION['userId'])) include('template/login_form.php');
else echo "<script>window.location = 'index.php'</script>";

include('layout/footer.php');
?>