<?php
    if(isset($_POST['allowanceName']) && isset($_POST['add'])){
        $allowanceName = filterInput($_POST['allowanceName']);

        $sql = "SELECT allowanceName FROM allowance_type";
        if(check_exist($allowanceName, $sql)) swal("Data Existed!", "The allowance \'" . $allowanceName . "\' is already exist!", "warning");
        else {
            $sql = "INSERT INTO allowance_type VALUES (NULL, '$allowanceName')";
            swal_result($sql, "Add Allowance", "The allowance \'" . $allowanceName . "\' has been added", "");
        }
    }
?>