<?php
include('layout/initial.php');
start_HTML_header("Home");

if(isset($_SESSION['admin'])){
    set_h1("Home");
    include('template/home_admin.php');

} elseif (isset($_SESSION['employee'])){
    include('template/home_employee.php');

}
include('layout/footer.php');
?>