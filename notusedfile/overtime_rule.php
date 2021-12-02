<?php
include('layout/initial.php');
start_HTML_header("Overtime Rule");
if(isset($_SESSION['admin'])){
    require_once('function/config/overtime/addOvertimeRule.php');
    require_once('function/config/overtime/editOvertimeRule.php');

    if(isset($_GET['name'])) set_h1("Overtime Rule (" . $_GET['name'] . ")");
    else set_h1("Overtime Rule");
    include('template/config/overtime_rule_view.php');
}
include('layout/footer.php');
?>