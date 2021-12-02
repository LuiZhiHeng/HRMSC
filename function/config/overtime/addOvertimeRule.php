<?php
    if(isset($_POST['id']) && isset($_POST['minWorkHour']) && isset($_POST['payrate']) && isset($_POST['valid']) && isset($_POST['add'])){
        $id = filterInput($_POST['id']);
        $minWorkHour = filterInput($_POST['minWorkHour']);
        $payrate = filterInput($_POST['payrate']);
        $valid = filterInput($_POST['valid']);

        $sql = "INSERT INTO overtime_payrate VALUES (NULL, '$id', '$minWorkHour', '$payrate', '$valid')";
        swal_result($sql, "Add OT Payrate Rule", "", "");
    }
?>