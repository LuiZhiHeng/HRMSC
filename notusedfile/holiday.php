<?php
include('layout/initial.php');
start_HTML_header("Public Holiday");
if(isset($_SESSION['admin'])){
    require_once('function/config/holiday/addHoliday.php');
    require_once('function/config/holiday/editHoliday.php');
    require_once('function/config/holiday/deleteHoliday.php');    

    set_h1("Public Holiday");
    include('template/config/holiday_view.php');
}
include('layout/footer.php');
?>