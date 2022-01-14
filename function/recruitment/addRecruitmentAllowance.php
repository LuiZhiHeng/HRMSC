<?php
    if(isset($_POST['id']) && isset($_POST['allowance']) && isset($_POST['allowanceAmount']) && isset($_POST['add'])){
        $id = filterInput($_POST['id']);
        $allowance = filterInput($_POST['allowance']);
        $allowanceAmount = filterInput($_POST['allowanceAmount']);

        $sql = "SELECT allowanceTypeId FROM allowance WHERE recruitmentId = '$id'";
        if(check_exist($allowance, $sql)) swal("Data Existed!", "", "warning");
        else {
            $sql = "INSERT INTO allowance VALUES (NULL, '$id', '$allowance', '$allowanceAmount')";
            swal_result($sql, "Add Allowance", "", "");
        }
    }
?>