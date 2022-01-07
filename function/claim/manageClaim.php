<?php
    if(isset($_POST['cid'])){
        
        if(isset($_POST['approve'])){
            $manage = "Approve";
            $status = 1;
        } elseif(isset($_POST['reject'])){
            $manage = "Reject";
            $status = 2;
        } elseif(isset($_POST['prepare'])){
            $manage = "Perpare";
            $status = 5;
        } else $manage = "Manage";
        
        $datetimeNow = get_now();
        $lId = filterInput(($_POST['cid']));

        $sql = "UPDATE claim_request SET claimStatus='$status', approveClaimDateTime='$datetimeNow' WHERE claimId = '$lId'";
        swal_result($sql, $manage . " Claim", "", "");
    }
?>