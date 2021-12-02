<?php
    if(isset($_POST['cid'])){
        
        if(isset($_POST['approve'])) $manage = "Approve";
        elseif(isset($_POST['reject'])) $manage = "Reject";
        elseif(isset($_POST['prepare'])) $manage = "Perpare";
        else $manage = "Manage";
        
        $lId = filterInput(($_POST['cid']));

        $sql = "UPDATE claim_request SET claimStatus='$status' WHERE claimId = '$lId'";
        swal_result($sql, $manage . " Claim", "", "");
    }
?>