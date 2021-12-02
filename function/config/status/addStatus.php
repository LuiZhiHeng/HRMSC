<?php
    if(isset($_POST['statusName']) && isset($_POST['add'])){
        $statusName = filterInput($_POST['statusName']);

        $sql = "SELECT statusName FROM status_type";
        if(check_exist($statusName, $sql)) swal("Data Existed!", "The status \'" . $statusName . "\' is already exist!", "warning");
        else {
            $sql = "INSERT INTO status_type VALUES (NULL, '$statusName')";
            swal_result($sql, "Add Status", "The status \'" . $statusName . "\' has been added", "");
        }
    }
?>