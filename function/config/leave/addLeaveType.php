<?php
    if(isset($_POST['leaveTypeName']) && isset($_POST['add'])){
        $leaveTypeName = filterInput($_POST['leaveTypeName']);
    
        $sql = "SELECT leaveName FROM leave_type";
        if(check_exist($leaveTypeName, $sql)) swal("Data Existed!", "The leave type \"' . $leaveTypeName . '\" is already exist!", "warning");
        else {
            $sql = "INSERT INTO leave_type VALUES (NULL, '$leaveTypeName')";
            swal_result($sql, "Add Leave Type", "The leave type \"" . $leaveTypeName . "\" has been added", "");
        }
    }
?>