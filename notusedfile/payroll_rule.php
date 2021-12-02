<?php
include('layout/initial.php');
start_HTML_header("Payroll Rule");
if(isset($_SESSION['admin'])){
    require_once('function/config/payroll/addPayrollRule.php');
    require_once('function/config/payroll/editPayrollRule.php');

    if(isset($_GET['name'])) set_h1("Payroll Rule (" . $_GET['name'] . ")");
    else set_h1("Payroll Rule");
    include('template/config/payroll_rule_view.php');
}
include('layout/footer.php');
?>