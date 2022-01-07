<?php
    if(isset($_POST['id']) && isset($_POST['take'])){
        $lId = filterInput(($_POST['id']));

        $sql = "UPDATE claim_request SET claimStatus = 6 WHERE claimId='$lId'";
        swal_result($sql, "Take Claim", "", "");
    }
?>