<?php
include('layout/initial.php');
start_HTML_header("Overtime Type");
if(isset($_SESSION['admin'])){
    require_once('function/config/overtime/addOvertimeType.php');
    require_once('function/config/overtime/editOvertimeType.php');

    set_h1("Overtime List");
    include('template/config/overtime_type_view.php');
}
include('layout/footer.php');
?>