<?php
    if(isset($_POST['lId'])){
        $lId = filterInput(($_POST['lId']));

        if(isset($_POST['approve'])) {
            $manage = "Approve";
            $status = 1;
        } elseif(isset($_POST['reject'])){
            $manage = "Reject";
            $status = 2;
        } else $manage = "Manage";
        $datetimeNow = get_now();

        $sql = "UPDATE leave_request SET leaveStatus='$status', approveLeaveDateTime='$datetimeNow' WHERE leaveId='$lId'";
        swal_result($sql, $manage . " Leave", "", "");
    }
?>