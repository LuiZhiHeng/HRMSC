<?php
    if( isset($_POST['emId']) &&
        isset($_POST['start']) && isset($_POST['end']) &&
        isset($_POST['type']) && isset($_POST['reason']) &&
        isset($_POST['comment']) &&
        isset($_POST['add'])
        ){
        
        $emId = filterInput(($_POST['emId']));
        $start = filterInput(($_POST['start']));
        $end = filterInput(($_POST['end']));
        $type = filterInput(($_POST['type']));
        $fileName = filterInput($_FILES["fileToUpload"]["name"]);
        $reason = filterInput(($_POST['reason']));
        $comment = filterInput(($_POST['comment']));
        $datetimeNow = get_now();

        $msg = check_upload_valid("leave");
        if($msg == 1){
            $sql = "INSERT INTO leave_request VALUES (NULL, '$emId', '$type', '$reason', '$start', '$end', '$fileName', '$datetimeNow', '$datetimeNow', '$comment', 1)";
            swal_result($sql, "Assign Leave", "", "");
        } else swal("Assign Leave Failed", $msg, "error");
    }
?>