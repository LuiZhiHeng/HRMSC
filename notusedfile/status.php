<?php
include('layout/initial.php');
start_HTML_header("Status Type");
if(isset($_SESSION['admin'])){
    require_once('function/config/status/addStatus.php');
    require_once('function/config/status/editStatus.php');
    
    set_h1("Status List");
    include('template/config/status_view.php');
}
include('layout/footer.php');
?>