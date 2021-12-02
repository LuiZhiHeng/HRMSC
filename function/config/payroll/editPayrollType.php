<?php
    if(isset($_POST['id']) && isset($_POST['payrollTypeNameOld']) && isset($_POST['payrollTypeName']) && isset($_POST['edit'])){
        $id = filterInput($_POST['id']);
        $payrollTypeNameOld = filterInput($_POST['payrollTypeNameOld']);
        $payrollTypeName = filterInput($_POST['payrollTypeName']);

        $sql = "SELECT payrollItemTypeName FROM payroll_item_type";
        if(check_exist($payrollTypeName, $sql)) swal("Data Existed!", "The payroll type \'" . $payrollTypeName . "\' is already exist!", "warning");
        else {
            $sql = "UPDATE payroll_item_type SET payrollItemTypeName = '$payrollTypeName' WHERE payrollItemTypeId = '$id'";
            swal_result($sql, "Edit Payroll Type", "The payroll type \'" . $payrollTypeNameOld . "\' has been changed to \'" . $payrollTypeName . "\'", "");
        }
    }

?>