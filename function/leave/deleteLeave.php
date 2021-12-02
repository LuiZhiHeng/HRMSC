<?php
    if( isset($_POST['lId']) && isset($_POST['file']) && isset($_POST['delete'])){
        $leaveId = filterInput(($_POST['lId']));
        $file = filterInput(($_POST['file']));

        //delete file
        if($file != NULL) if(!unlink("upload/leave/" . $file)) console("File is not exist!");

        $sql = "DELETE FROM leave_request WHERE leaveId = '$leaveId'";
        swal_result($sql, "Delete Leave Request", "", "");
    }
?>