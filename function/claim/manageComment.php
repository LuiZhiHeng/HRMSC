<?php
    if(isset($_POST['id']) && isset($_POST['commentName']) && isset($_POST['comment'])){
        $id = filterInput($_POST['id']);
        $commentName = filterInput($_POST['commentName']);
    
        $sql = "UPDATE claim_request SET comment = '$commentName' WHERE claimId = '$id';";
        swal_result($sql, "Save Comment", "", "");
    }
?>