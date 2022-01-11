<?php
include('layout/initial.php');
start_HTML_header("Payroll");

require('function/payroll/payroll_formula.php');

if(isset($_POST['uId']) && isset($_POST['pId']) && isset($_POST['view']) && ( isset($_SESSION['admin']) || isset($_SESSION['employee']) )){
    include('template/payroll/salary_slip.php');

} elseif(isset($_SESSION['admin'])){
    require('function/payroll/generatePayroll.php');
    require('function/payroll/editCheque.php');

    if(isset($_GET['month']) && isset($_GET['year']) && isset($_GET['view'])){
        $monthSelected = filterInput($_GET['month']);
        $yearSelected = filterInput($_GET['year']);
        set_h1("Payroll (" . $monthSelected . "/" . $yearSelected . ")");
        breadcrumb(array("Payroll" => "payroll.php"), "View");
        include('template/payroll/payroll_view.php');

    } else { // view
        set_h1("Payroll History");
        breadcrumb(0, "Payroll");
        include('template/payroll/payroll_history.php');
        
    }
} elseif(isset($_SESSION['employee'])) {
    set_h1("Payroll");
    breadcrumb(0, "Payroll");
    include('template/payroll/payroll_personal.php');

}
include('layout/footer.php');
?>