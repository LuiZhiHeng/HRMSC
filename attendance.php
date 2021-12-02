<?php
include('layout/initial.php');
start_HTML_header("Attendance");

if(isset($_SESSION['admin'])){
    if(isset($_GET['qr'])) {
        set_h1("QR Code (" . display_date() . ")");
        include('template/attendance/attendance_qr.php');

    } elseif(isset($_GET['history'])) {
        set_h1("Attendance History");
        include('template/attendance/attendance_history.php');

    } else { //view
        require_once("function/attendance/addAttendance.php");

        set_h1("Attendance Record <small>(" . display_date() . ")</small>");
        include('template/attendance/attendance_view.php');

    }
} elseif($_SESSION['employee']) {
    require_once('function/attendance/punch.php');
    if(isset($_GET['punch'])) {
        set_h1("Punch");
        include('template/attendance/attendance_punch.php');

    } else {
        set_h1("Attendance Record");
        include('template/attendance/attendance_personal.php');

    }
}
include('layout/footer.php');
?>