<?php
    if( isset($_POST['id']) && isset($_POST['file']) && isset($_POST['delete'])){
        $claimId = filterInput(($_POST['id']));
        $file = filterInput(($_POST['file']));

        //delete file
        if($file != NULL) if(!unlink("upload/claim/" . $file)) console("File is not exist!");

        $sql = "DELETE FROM claim_request WHERE claimId = '$claimId'";
        swal_result($sql, "Delete Claim Request", "", "");
    }
?>