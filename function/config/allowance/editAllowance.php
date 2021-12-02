<?php
    if(isset($_POST['id']) && isset($_POST['allowanceNameOld']) && isset($_POST['allowanceName']) && isset($_POST['edit'])){
        $id = filterInput($_POST['id']);
        $allowanceNameOld = filterInput($_POST['allowanceNameOld']);
        $allowanceName = filterInput($_POST['allowanceName']);
        
        $sql = "SELECT allowanceName FROM allowance_type";
        if(check_exist($allowanceName, $sql)) swal("Data Existed!", "The allowance \'" . $allowanceName . "\' is already exist!", "warning");
        else {
            $sql = "UPDATE allowance_type SET allowanceName = '$allowanceName' WHERE allowanceTypeId = '$id'";
            swal_result($sql, "Edit Allowance", "The allowance \'" . $allowanceNameOld . "\' has been changed to \'" . $allowanceName . "\'", "");
        }
    }

?>