<?php
include('layout/initial.php');
start_HTML_header("Attendance");

if(isset($_SESSION['admin'])){
    if(isset($_GET['qr'])) {
        set_h1("QR Code (" . display_date() . ")");
        breadcrumb(array("Attendance" => "attendance.php"), "QR Code");
        include('template/attendance/attendance_qr.php');

    } elseif(isset($_GET['history'])) {
        set_h1("Attendance History");
        breadcrumb(array("Attendance" => "attendance.php"), "History");
        include('template/attendance/attendance_history.php');

    } else { //view
        require_once("function/attendance/addAttendance.php");

        set_h1("Attendance Record <small>(" . ((isset($_GET['date']) && strtotime($_GET['date'])) ? $_GET['date'] : display_date()) . ")</small>");
        breadcrumb(0, "Attendance");
        include('template/attendance/attendance_view.php');

    }
} elseif($_SESSION['employee']) {
    require_once('function/attendance/punch.php');
    if(isset($_GET['punch'])) {
        set_h1("Punch");
        breadcrumb(array("Attendance" => "attendance.php"), "Punch");
        include('template/attendance/attendance_punch.php');

    } else {
        set_h1("Attendance Record");
        breadcrumb(0, "Attendance");
        include('template/attendance/attendance_personal.php');

    }
}
include('layout/footer.php');
?>