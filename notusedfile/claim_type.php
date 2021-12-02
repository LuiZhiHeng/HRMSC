<?php
include('layout/initial.php');
start_HTML_header("Claim Type");
if(isset($_SESSION['admin'])){
    require_once('function/config/claim/addClaimType.php');
    require_once('function/config/claim/editClaimType.php');
    
    set_h1("Claim Type");
    include('template/config/claim_type_view.php');
}
include('layout/footer.php');
?>