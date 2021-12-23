<?php
    if(isset($_POST['id']) && isset($_POST['leaveTypeNameOld']) && isset($_POST['leaveTypeName']) && isset($_POST['edit'])){
        $id = filterInput($_POST['id']);
        $leaveTypeNameOld = filterInput($_POST['leaveTypeNameOld']);
        $leaveTypeName = filterInput($_POST['leaveTypeName']);

        $sql = "SELECT leaveName FROM leave_type";
        if(check_exist($leaveTypeName, $sql)) swal("Data Existed!", "The leave type \'" . $leaveTypeName . "\' is already exist!", "warning");
        else {
            $sql = "UPDATE leave_type SET leaveName = '$leaveTypeName' WHERE leaveTypeId = '$id'";
            swal_result($sql, "Edit Leave Type", "The leave type \'" . $leaveTypeNameOld . "\' has been changed to \'" . $leaveTypeName . "\'", "");
        }
    }

?>