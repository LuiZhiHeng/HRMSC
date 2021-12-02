<?php
    if( isset($_POST['id']) && isset($_POST['chequeNo']) && isset($_POST['saveEdit'])){
        $id = filterInput($_POST['id']);
        $cheque = filterInput($_POST['chequeNo']);

        $sql = "UPDATE payroll SET cheque='$cheque' WHERE payrollId = '$id'";
        swal_result($sql, "Edit Cheque", "", "");
    }
?>