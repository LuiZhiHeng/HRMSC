<?php
include('layout/initial.php');
start_HTML_header("Leave Rule");
if(isset($_SESSION['admin'])){
    require_once('function/config/leave/addLeaveRule.php');
    require_once('function/config/leave/editLeaveRule.php');

    if(isset($_GET['name'])) set_h1("Leave Rule (" . $_GET['name'] . ")");
    else set_h1("Leave Rule");
    include('template/config/leave_rule_view.php');
}
include('layout/footer.php');
?>