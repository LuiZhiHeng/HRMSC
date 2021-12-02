<?php
    require('../../db/connectDB.php');
    require('../filter.php');
    require('../../db/functionTemplate.php');
    $emId = (int) $_REQUEST["n"];
    $attDate = $_REQUEST["d"];
    $startJobT = $endJobT = "00:00";
    $checkined = 0;
    $checkouted = 0;
    $rsTime = $conn->query("SELECT recruitment.startJobTime, recruitment.endJobTime FROM recruitment JOIN employee ON employee.recruitmentId = recruitment.recruitmentId WHERE employee.employeeId = '$emId'");
    if($rsTime->num_rows > 0){
        for ($i=0; $i < $rsTime->num_rows; $i++) { 
            $dataTime = $rsTime->fetch_assoc();
            $startJobT = substr($dataTime['startJobTime'], 0, 5);
            $endJobT = substr($dataTime['endJobTime'], 0, 5);
        }
    } else {}

    $rsCheck = $conn->query("SELECT attendanceId, punchInDateTime, punchOutDateTime FROM attendance WHERE employeeId = '$emId' AND attendanceDate = '$attDate'");
    if($rsCheck->num_rows > 0){
        for ($i=0; $i < $rsCheck->num_rows; $i++) { 
            $data = $rsCheck->fetch_assoc();
            $startJobT = substr($data['punchInDateTime'], 11, 5);
            $tempOut = $data['punchOutDateTime'];
            if($tempOut != "0000-00-00 00:00:00" && $tempOut != NULL) {
                $endJobT = substr($tempOut, 11, 5);
                $checkouted = 1;
            }
            $checkined = 1;
        }
    } else {}

    echo $startJobT . $endJobT . $checkined . $checkouted;
?>