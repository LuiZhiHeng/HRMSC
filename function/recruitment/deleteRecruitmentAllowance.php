<?php
    if(isset($_POST['id']) && isset($_POST['delete'])){
        $id = filterInput($_POST['id']);

        $sql = "DELETE FROM allowance WHERE allowanceId = '$id'";
        swal_result($sql, "Delete Allowance", "", "");
    }
?>