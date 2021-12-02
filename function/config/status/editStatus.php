<?php
    if(isset($_POST['id']) && isset($_POST['statusNameOld']) && isset($_POST['statusName']) && isset($_POST['edit'])){
        $id = filterInput($_POST['id']);
        $statusNameOld = filterInput($_POST['statusNameOld']);
        $statusName = filterInput($_POST['statusName']);
        
        $sql = "SELECT statusName FROM status_type";
        if(check_exist($statusName, $sql)) swal("Data Existed!", "The status \'" . $statusName . "\' is already exist!", "warning");
        else {
            $sql = "UPDATE status_type SET statusName = '$statusName' WHERE statusTypeId = '$id'";
            swal_result($sql, "Edit Status", "The status \'" . $statusName . "\' has been added", "");
        }
    }

?>