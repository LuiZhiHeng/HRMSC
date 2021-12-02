<?php
    if(isset($_POST['lId'])){
        $lId = filterInput(($_POST['lId']));

        if(isset($_POST['approve'])) $manage = "Approve";
        elseif(isset($_POST['reject'])) $manage = "Reject";
        else $manage = "Manage";

        $sql = "UPDATE leave_request SET leaveStatus='$status' WHERE leaveId='$lId'";
        swal_result($sql, $manage . " Leave", "", "");
    }
?>