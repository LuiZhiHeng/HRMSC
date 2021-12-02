<?php
    if(isset($_POST['id']) && isset($_POST['claimTypeNameOld']) && isset($_POST['claimTypeName']) && isset($_POST['edit'])){
        $id = filterInput($_POST['id']);
        $claimTypeNameOld = filterInput($_POST['claimTypeNameOld']);
        $claimTypeName = filterInput($_POST['claimTypeName']);
        
        $sql = "SELECT claimName FROM claim_type";
        if(check_exist($claimTypeName, $sql)) swal("Data Existed!", "The claim type \'' . $claimTypeName . '\' is already exist!", "warning");
        else {
            $sql = "UPDATE claim_type SET claimName = '$claimTypeName' WHERE claimTypeId = '$id'";
            swal_result($sql, "Edit Claim Type", "The claim type \'" . $claimTypeNameOld . "\' has been changed to \'" . $claimTypeName . "\'", "");
        }
    }

?>