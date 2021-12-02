<?php
include('layout/initial.php');
start_HTML_header("Payroll Type");
if(isset($_SESSION['admin'])){
    require_once('function/config/payroll/addPayrollType.php');
    require_once('function/config/payroll/editPayrollType.php');

    set_h1("Payroll Type List");
    include('template/config/payroll_type_view.php');
}
include('layout/footer.php');
?>