<?php
    if(isset($_POST['id']) && isset($_POST['stateNameOld']) && isset($_POST['stateName']) && isset($_POST['edit'])){
        $id = filterInput($_POST['id']);
        $stateNameOld = filterInput($_POST['stateNameOld']);
        $stateName = filterInput($_POST['stateName']);

        $sql = "SELECT stateName FROM state_type";
        if(check_exist($stateName, $sql)) swal("Data Existed!", "The state \'" . $stateName . "\' is already exist!", "warning");
        else {
            $sql = "UPDATE state_type SET stateName = '$stateName' WHERE stateTypeId = '$id'";
            swal_result($sql, "Edit State", "The state \'" . $stateNameOld . "\' has been changed to \'" . $stateName . "\'", "");
        }
    }

?>