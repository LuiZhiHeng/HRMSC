<?php
    if(isset($_POST['stateName']) && isset($_POST['add'])){
        $stateName = filterInput($_POST['stateName']);

        $sql = "SELECT stateName FROM state_type";
        if(check_exist($stateName, $sql)) swal("Data Existed!", "The state \'" . $stateName . "\' is already exist!", "warning");
        else {
            $sql = "INSERT INTO state_type VALUES (NULL, '$stateName')";
            swal_result($sql, "Add State", "The state \'" . $stateName . "\' has been added", "");
        }
    }
?>