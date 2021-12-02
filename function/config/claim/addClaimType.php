<?php
    if(isset($_POST['claimTypeName']) && isset($_POST['add'])){
        $claimTypeName = filterInput($_POST['claimTypeName']);
        
        $sql = "SELECT claimName FROM claim_type";
        if(check_exist($claimTypeName, $sql)) swal("Data Existed!", "The claim type \'' . $claimTypeName . '\' is already exist!", "warning");
        else {
            $sql = "INSERT INTO claim_type VALUES (NULL, '$claimTypeName')";
            swal_result($sql, "Add Claim Type", "The claim type \'" . $claimTypeName . "\' has been added!", "");
        }
    }
?>