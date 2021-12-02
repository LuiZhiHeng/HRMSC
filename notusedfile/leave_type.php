<?php
include('layout/initial.php');
start_HTML_header("Leave Type");
if(isset($_SESSION['admin'])){
    require_once('function/config/leave/addLeaveType.php');
    require_once('function/config/leave/editLeaveType.php');

    set_h1("Leave Type List");
    include('template/config/leave_type_view.php');
}
include('layout/footer.php');
?>