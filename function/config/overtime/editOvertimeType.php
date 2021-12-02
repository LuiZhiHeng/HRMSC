<?php
    if(isset($_POST['id']) && isset($_POST['overtimeTypeNameOld']) && isset($_POST['overtimeTypeName']) && isset($_POST['edit'])){
        $id = filterInput($_POST['id']);
        $overtimeTypeNameOld = filterInput($_POST['overtimeTypeNameOld']);
        $overtimeTypeName = filterInput($_POST['overtimeTypeName']);

        $sql = "SELECT dayTypeName FROM overtime_day_type";
        if(check_exist($overtimeTypeName, $sql)) swal("Data Existed!", "The overtime day type \'" . $overtimeTypeName . "\' is already exist!", "warning");
        else {
            $sql = "UPDATE overtime_day_type SET dayTypeName='$overtimeTypeName' WHERE dayTypeId='$id'";
            swal_result($sql, "Edit OT Day Type", "The overtime day type \'" . $overtimeTypeNameOld . "\' has been changed to \'" . $overtimeTypeName . "\'", "");
        }
    }

?>