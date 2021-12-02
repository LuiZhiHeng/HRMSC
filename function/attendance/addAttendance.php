<?php
    if(isset($_POST['emN']) && isset($_POST['attDate']) && isset($_POST['check-in']) && isset($_POST['check-out']) && isset($_POST['addAtt'])){
        $emId = filterInput($_POST['emN']);
        $attDate = filterInput($_POST['attDate']);
        $startJobDT = $attDate . " " . filterInput($_POST['check-in']) . ":00";
        $endJobDT = $attDate . " " . filterInput($_POST['check-out']) . ":00";

        $rsCheck = $conn->query("SELECT attendanceId FROM attendance WHERE employeeId = '$emId' AND attendanceDate = '$attDate'");
        if($rsCheck->num_rows > 0){
            $data = $rsCheck->fetch_assoc();
            $attId = $data['attendanceId'];
            $sql = "UPDATE attendance SET punchInDateTime = '$startJobDT', punchOutDateTime = '$endJobDT' WHERE attendanceId = '$attId';";
        } elseif($rsCheck->num_rows == 0){
            $sql = "INSERT INTO attendance VALUES (NULL, '$emId', '$attDate', '$startJobDT', '$endJobDT');";
        } else swal("Add Attendance Failed", "", "error");
        swal_result($sql, "Update Attendance", "Attendance Added for " . $attDate, "");

    }
?>