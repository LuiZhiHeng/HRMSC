<?php
    if(isset($_POST['overtimeTypeName']) && isset($_POST['add'])){
        $overtimeTypeName = filterInput($_POST['overtimeTypeName']);

        $sql = "SELECT dayTypeName FROM overtime_day_type";
        if(check_exist($overtimeTypeName, $sql)) swal("Data Existed!", "The overtime day type \'" . $overtimeTypeName . "\' is already exist!", "warning");
        else {
            $sql = "INSERT INTO overtime_day_type VALUES (NULL, '$overtimeTypeName')";
            swal_result($sql, "Add OT Day Type", "The overtime day type \'" . $overtimeTypeName . "\' has been added", "");
        }
    }
?>