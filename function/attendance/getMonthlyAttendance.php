<?php
    require('../../db/connectDB.php');
    require('../filter.php');
    $emId = (int) $_REQUEST["n"];
    $monthSelected = (int) $_REQUEST["m"];
    $yearSelected = (int) $_REQUEST["y"];
    if($monthSelected < 1 || $monthSelected > 12) die("Invalid Month");
    if($yearSelected < 1900) die("Invalid Year");
    elseif($yearSelected >= get_year_now() && $monthSelected > get_month_now()) die("No record yet...");


    //get work day
    $workDay = "";
    $sqlEmData = "SELECT recruitment.workDay FROM employee JOIN recruitment ON recruitment.recruitmentId = employee.recruitmentId WHERE employee.employeeId = '$emId'";
    $rsEmData = $conn->query($sqlEmData);
    if($rsEmData->num_rows > 0){
        $dataEmData = $rsEmData->fetch_assoc();
        $workDay = $dataEmData['workDay'];
    } else die("Failed to Get Work Day Data...");
    

    //get all work date
    $arrWorkDate = get_all_work_date($workDay, $monthSelected, $yearSelected);


    //check attendance
    $rsAtt = $conn->query("SELECT attendanceDate FROM attendance WHERE employeeId = '$emId'");
    if($rsAtt->num_rows >= 0){
        for ($i=0; $i < $rsAtt->num_rows; $i++) { 
            $dataAtt = $rsAtt->fetch_assoc();
            $attendanceDate = $dataAtt['attendanceDate'];
            for ($j=0; $j < count($arrWorkDate); $j++) { 
                if($attendanceDate == $arrWorkDate[$j][0]){
                    $arrWorkDate[$j][1] = 1;
                }
            }
        }
    } else die("Failed to Get Attendance Record...");


    //get holiday
    $dateSelected = date("Y-m-d", strtotime($yearSelected . "-" . $monthSelected . "-1"));
    $yearNext = ($monthSelected == 12) ? $yearSelected + 1 : $yearSelected;
    $monthNext = ($monthSelected == 12) ? 1 : $monthSelected;
    $dateNext = date("Y-m-d", strtotime($yearNext . "-" . $monthNext . "-1"));
    $arrHoliday = [];
    $sqlHoliday = "SELECT * FROM holiday WHERE holidayDate >= '$dateSelected' AND holidayDate < '$dateNext'";
    $rsHoliday = $conn->query($sqlHoliday);
    if($rsHoliday->num_rows >= 0){
        for ($i=0; $i < $rsHoliday->num_rows; $i++) {
            $dataHoliday = $rsHoliday->fetch_assoc();
            $arrHoliday[$i] = $dataHoliday['holidayDate'];
            for ($j=0; $j < count($arrWorkDate); $j++) { 
                if($dataHoliday['holidayDate'] == $arrWorkDate[$j][0]){
                    $arrWorkDate[$j][1] = 3;
                }
            }
        }
    } else die("Failed to Get Holiday Record...");


    //get leave request
    $arrLeaveRequest = [[]];
    $sqlLeaveRequest = "SELECT * FROM leave_request WHERE employeeId = '$emId' 
        AND (startLeaveDateTime >= $yearSelected OR endLeaveDateTime < ($yearSelected+1))
        AND leaveStatus = 1";
    $rsLeaveRequest = $conn->query($sqlLeaveRequest);
    if($rsLeaveRequest->num_rows > 0){
        $arrLeaveRequestLength = count($arrLeaveRequest) - 1;
        for ($i=0; $i < $rsLeaveRequest->num_rows; $i++){ 
            $dataLeaveRequest = $rsLeaveRequest->fetch_assoc();
            $arrLeaveRequest[$arrLeaveRequestLength][0] = $dataLeaveRequest['leaveTypeId'];
            $arrLeaveRequest[$arrLeaveRequestLength][1] = $dataLeaveRequest['startLeaveDateTime'];
            $arrLeaveRequest[$arrLeaveRequestLength++][2] = $dataLeaveRequest['endLeaveDateTime'];
        }

        //count Leave taken
        for ($j=0; $j < count($arrLeaveRequest); $j++) {
            $startLeaveDT = date("Y-m-d", strtotime($arrLeaveRequest[$j][1]));
            $endLeaveDT = date("Y-m-d", strtotime($arrLeaveRequest[$j][2]));

            for ($k=0; $k < count($arrWorkDate); $k++) { 
                $workDate = $arrWorkDate[$k][0];
                
                if($workDate >= $startLeaveDT && $workDate <= $endLeaveDT) {
                    $arrWorkDate[$k][1] = 2;
                }
            }
        }

        showTable($arrWorkDate);
    } else if($rsLeaveRequest->num_rows == 0) showTable($arrWorkDate);
    else echo_txt("Failed to Get Leave History...");


    function showTable($arrAtt){
        echo "<tr class='text-center'>";
            echo_txt_tag("Description", "th");
            echo_txt_tag("Detail", "th");
        echo "<tr>";

        echo "<tr>";
            echo_txt_tag("Attendance", "td");

            echo "<td class='text-center'>";
                $leave = $present = 0;
                for ($i=0; $i < count($arrAtt); $i++) { 
                    if($arrAtt[$i][1] != 0) $present++;
                    if($arrAtt[$i][1] == 2) $leave++;
                }
                echo_txt($present . "/" . count($arrAtt));
                if($leave != 0) echo_txt(" (" . $leave . " leave)");
            echo_tag("td", 1);
        echo_tag("tr", 1);

        echo "<tr>";
            echo_txt_tag("Absent Date", "td");

            echo "<td class='text-center'>";
                for ($i=0; $i < count($arrAtt); $i++) { 
                    if($arrAtt[$i][1] == 0) {
                        echo_txt($arrAtt[$i][0]);
                        echo "<br>";
                    }
                }
            echo "</td>";
        echo "</tr>";
    }

    function get_all_work_date($work_day, $month, $year){
        $arrDate = [[]];
        $countNum = 0;
        $arrWorkDay = str_split($work_day); // seperate & store in array
        $totalDayInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $firstDayInMonth = date("N", strtotime($year . "-" . $month . "-" . 1));
        for ($wd=0; $wd < count($arrWorkDay); $wd++) {
            $c = ($firstDayInMonth - $arrWorkDay[$wd]) * -1;
            if($c < 0) $c+=7;
            for ($i=$c+1; $i < $totalDayInMonth; $i+=7) {
                $arrDate[$countNum][0] = date("Y-m-d", strtotime($year . "-" . $month . "-" . $i));
                $arrDate[$countNum++][1] = 0;
            }
        }
        sort($arrDate);
        return $arrDate;
    }
?>