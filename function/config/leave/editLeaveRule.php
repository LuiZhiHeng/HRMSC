<?php
if(isset($_POST['id']) && isset($_POST['minWorkYear']) && isset($_POST['leaveDay']) && isset($_POST['valid']) && isset($_POST['edit'])){
    $id = filterInput($_POST['id']);
    $minWorkYear = filterInput($_POST['minWorkYear']);
    $leaveDay = filterInput($_POST['leaveDay']);
    $valid = filterInput($_POST['valid']);

    $sql = "UPDATE leave_item SET minWorkedYear = '$minWorkYear', day = '$leaveDay', leaveItemStartFrom = '$valid' WHERE leaveItemId = '$id'";
    swal_result($sql, "Edit Leave Rule", "", "");
}
?>