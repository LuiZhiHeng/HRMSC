<?php
include('layout/initial.php');
start_HTML_header("State");
if(isset($_SESSION['admin'])){
    require_once('function/config/state/addState.php');
    require_once('function/config/state/editState.php');
    
    set_h1("State List");
    include('template/config/state_view.php');
}
include('layout/footer.php');
?>