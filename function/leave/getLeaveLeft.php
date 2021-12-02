<?php
require('../../db/connectDB.php');
$emId = $_REQUEST["q"];
$leaveTypeId = $_REQUEST["leaveType"];

    if($emId == 0) echo "Please select Employee ID first!";
    else {
        $startWorkDate = $leaveStart = $leaveEnd = "";
        $countTotalRequest = 0;

        $sql = "SELECT employee.startWorkDate, 
                    leave_request.startLeaveDateTime,
                    leave_request.endLeaveDateTime
                FROM leave_request
                JOIN employee ON employee.employeeId = leave_request.employeeId
                WHERE leave_request.employeeId = '$emId' AND leave_request.leaveTypeId = '$leaveTypeId'  AND leave_request.leaveStatus = 1;
                ";
        $rs = $conn->query($sql);
        if($rs->num_rows > 0){ // if has request before
            $countTotalRequest = $rs->num_rows;
            for ($i=0; $i < $rs->num_rows; $i++) { 
                $data = $rs->fetch_array(MYSQLI_NUM);
                $startWorkDate = $data[0];
                $leaveStart = $data[1];
                $leaveEnd = $data[2];
            }

        } elseif($rs->num_rows == 0){ // if no request before
            $countTotalRequest = 0;
            $rsEmp = $conn->query("SELECT startWorkDate FROM employee WHERE employeeId='$emId'");
            $data = $rsEmp->fetch_array(MYSQLI_NUM);
            $startWorkDate = $data[0];
        } else echo "Fail to get employee data";

        $todayDate = get_date_now();
        $yearWorked = round(((strtotime($todayDate) - strtotime($startWorkDate)) / 31556952), 2);

        // get leave calculation
        $arr = [[]];
        $rsItem = $conn->query("SELECT * FROM leave_item WHERE leaveTypeId='$leaveTypeId' ORDER BY minWorkedYear DESC, leaveItemStartFrom DESC");
        if(!$rs) echo "no leave rule yet";
        else {
            for ($f=0; $f < $rsItem->num_rows; $f++) { 
                $dataLeaveItem = $rsItem->fetch_array(MYSQLI_NUM);
                for ($tem=0; $tem < count($dataLeaveItem); $tem++) { 
                    $arr[$f][$tem] = $dataLeaveItem[$tem];
                }
            }
        }
        
        //check worked year for leave_item
        function checkWhichRuleToBeUsed($yearWorked, $arr){
            for ($i=0; $i < count($arr); $i++) { 
                for ($tem=0; $tem < count($arr[$i]); $tem++) { 
                    if($yearWorked >= $arr[$i][2]) return $arr[$i];
                }
            }
        }

        $arrSelected = [];
        $leaveAvailable = "";
        if($arrSelected = checkWhichRuleToBeUsed($yearWorked, $arr)){
            $totalLeave = $arrSelected[3];
            $leaveAvailable .= ($totalLeave - $countTotalRequest) . "/" . $totalLeave;
            echo $leaveAvailable;
        } else echo "∞";
    }
?>