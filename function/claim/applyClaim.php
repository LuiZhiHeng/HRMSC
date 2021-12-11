<?php
    if( isset($_POST['id']) && isset($_POST['type']) && 
        isset($_POST['detail']) && isset($_POST['amount']) &&
        isset($_POST['apply'])
        ){
        
        $emId = filterInput(($_POST['id']));
        $type = filterInput(($_POST['type']));
        $detail = filterInput(($_POST['detail']));
        $amount = filterInput(($_POST['amount']));
        $fileName = filterInput($_FILES["fileToUpload"]["name"]);
        $datetimeNow = get_now();
        
        $msg = check_upload_valid("claim");
        if($msg == 1){
            $sql = "INSERT INTO claim_request VALUES (NULL, '$emId', '$type', '$detail', '$amount', '$fileName', '$datetimeNow', NULL, NULL, 3)";
            swal_result($sql, "Apply Claim", "", "");
        } else swal("Apply Claim Failed", $msg, "error");
    }
?>