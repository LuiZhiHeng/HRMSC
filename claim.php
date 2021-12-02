<?php
include('layout/initial.php');
start_HTML_header("Claim");

if(isset($_SESSION['admin'])){
    require_once('function/claim/manageComment.php');
    require_once('function/claim/manageClaim.php');

    if(isset($_GET['history'])){
        set_h1('Claim History');
        include('template/claim/claim_history.php');

    } else { //view request
        set_h1("Claim Request");
        include('template/claim/claim_request.php');
    }
} elseif($_SESSION['employee']) {
    require_once('function/claim/applyClaim.php');
    require_once('function/claim/takeClaim.php');
    require_once('function/claim/deleteClaim.php');

    if(isset($_GET['apply'])){
        set_h1("Apply Claim");
        include('template/claim/claim_apply.php');
     
    } elseif(isset($_GET['history'])) {
        set_h1('Claim History');
        include('template/claim/claim_personal_history.php');
   
    } else {
        set_h1('Claim Record');
        include('template/claim/claim_personal.php');
    }
}
include('layout/footer.php');
?>