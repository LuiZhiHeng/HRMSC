<?php
    if(isset($_POST['emId']) && isset($_POST['date'])){
        $uId = filterInput($_POST['emId']);
        $date = filterInput($_POST['date']);
        $datetimeNow = get_now();
        $dateNow = get_date_now();

        if(isset($_POST['punchIn'])){
            $sql = "INSERT INTO attendance VALUES (NULL, '$uId', '$date', '$datetimeNow', NULL);";
            swal($sql, "Punch In", "Punched In for " . $dateNow, "");
        } else if(isset($_POST['punchOut'])){
            $sql = "UPDATE attendance SET punchOutDateTime = '$datetimeNow' WHERE attendanceDate = '$dateNow' AND employeeId = '$uId'";
            swal($sql, "Punch Out", "Punched Out for " . $dateNow, "");
        }
    }
?>