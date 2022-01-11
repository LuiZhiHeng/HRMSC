<?php
include('layout/initial.php');
start_HTML_header("Leave");

if(isset($_SESSION['admin'])){
    require_once('function/leave/approveLeave.php');
    require_once('function/leave/assignLeave.php');
    require_once('function/leave/manageComment.php');

    if(isset($_GET['assign'])){
        set_h1("Assign Leave");
        breadcrumb(array("Leave" => "leave.php"), "Assign");
        include('template/leave/leave_assign.php');

    } elseif(isset($_GET['history'])) {
        set_h1("Leave History");
        breadcrumb(array("Leave" => "leave.php"), "History");
        include('template/leave/leave_history.php');

    } else { //view
        set_h1("Leave Request");
        breadcrumb(0, "Leave");
        include('template/leave/leave_request.php');
    }
} elseif($_SESSION['employee']) { // session employee
    require_once('function/leave/applyLeave.php');
    require_once('function/leave/deleteLeave.php');
    if(isset($_GET['apply'])) {
        set_h1("Apply Leave");
        breadcrumb(array("Leave" => "leave.php"), "Apply");
        include('template/leave/leave_apply.php');
       
    } elseif(isset($_GET['history'])) {
        set_h1("Leave History");
        breadcrumb(array("Leave" => "leave.php"), "History");
        include('template/leave/leave_personal_history.php');

    } else { //view
        set_h1("Leave Record");
        breadcrumb(0, "Leave");
        include('template/leave/leave_personal.php');
    }
}
include('layout/footer.php');
?>