<?php
    if(isset($_POST['id']) && isset($_POST['allowanceAmount']) && isset($_POST['edit'])){
        $id = filterInput($_POST['id']);
        $allowanceAmount = filterInput($_POST['allowanceAmount']);
        $sql = "UPDATE allowance SET allowanceAmount='$allowanceAmount' WHERE allowanceId='$id'";
        swal_result($sql, "Edit Allowance", "", "");
    }

?>