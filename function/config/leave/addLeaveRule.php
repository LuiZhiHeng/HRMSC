<?php
    if(isset($_POST['id']) && isset($_POST['minWorkYear']) && isset($_POST['leaveDay']) && isset($_POST['valid']) && isset($_POST['add'])){
        $id = filterInput($_POST['id']);
        $minWorkYear = filterInput($_POST['minWorkYear']);
        $leaveDay = filterInput($_POST['leaveDay']);
        $valid = filterInput($_POST['valid']);

        $sql = "INSERT INTO leave_item VALUES (NULL, '$id', '$minWorkYear', '$leaveDay', '$valid')";
        swal_result($sql, "Add Leave Rule", "", "");
    }
?>