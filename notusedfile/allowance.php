<?php
include('layout/initial.php');
start_HTML_header("Allowance Type");
if(isset($_SESSION['admin'])){
    require_once('function/config/allowance/addAllowance.php');
    require_once('function/config/allowance/editAllowance.php');
    
    set_h1("Allowance List");
    include('template/config/allowance_view.php');
}
include('layout/footer.php');
?>