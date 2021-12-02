<?php
if(isset($_POST['id']) && isset($_POST['minWorkHour']) && isset($_POST['payrate']) && isset($_POST['valid']) && isset($_POST['edit'])){
    $id = filterInput($_POST['id']);
    $minWorkHour = filterInput($_POST['minWorkHour']);
    $payrate = filterInput($_POST['payrate']);
    $valid = filterInput($_POST['valid']);

    $sql = "UPDATE overtime_payrate SET minWorkedHour = '$minWorkHour', payrate = '$payrate', overtimePayrateStartFrom = '$valid' WHERE overtimePayrateId = '$id'";
    swal_result($sql, "Edit Overtime Rule", "", "");
}
?>