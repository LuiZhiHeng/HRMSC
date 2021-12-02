<?php
    if(isset($_POST['payrollTypeName']) && isset($_POST['add'])){
        $payrollTypeName = filterInput($_POST['payrollTypeName']);

        $sql = "SELECT payrollItemTypeName FROM payroll_item_type";
        if(check_exist($payrollTypeName, $sql)) swal("Data Existed!", "The payroll type \'" . $payrollTypeName . "\' is already exist!", "warning");
        else {
            $sql = "INSERT INTO payroll_item_type VALUES (NULL, '$payrollTypeName')";
            swal_result($sql, "Add Payroll Type", "The payroll type \'" . $payrollTypeName . "\' has been added", "");
        }
    }
?>