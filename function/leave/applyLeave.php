<?php
    if( isset($_POST['id']) &&
        isset($_POST['start']) && isset($_POST['end']) &&
        isset($_POST['type']) && isset($_POST['reason']) &&
        isset($_POST['apply'])
        ){
        
        $emId = filterInput(($_POST['id']));
        $start = filterInput(($_POST['start']));
        $end = filterInput(($_POST['end']));
        $type = filterInput(($_POST['type']));
        $fileName = filterInput($_FILES["fileToUpload"]["name"]);
        $reason = filterInput(($_POST['reason']));
        $datetimeNow = get_now();

        $msg = check_upload_valid("leave");
        if($msg == 1){
            $sql = "INSERT INTO leave_request VALUES (NULL, '$emId', '$type', '$reason', '$start', '$end', '$fileName', '$datetimeNow', NULL, NULL, 3)";
            swal_result($sql, "Apply Leave", "", "");
        } else swal("Apply Leave Failed", $msg, "error");
    }
?>