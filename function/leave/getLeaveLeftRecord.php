<?php
    require('../../db/connectDB.php');
    require('../filter.php');
    $emId = (int) $_REQUEST["n"];
    $yearSelected = (int) $_REQUEST["y"];
    if($yearSelected < 1900) die("Invalid Year");
    elseif($yearSelected > get_year_now()) die("No record yet...");
    $yearPrevious = $yearSelected - 1;
    $yearNext = $yearSelected + 1;

    //get leave id & name
    $arrLeave = get_leave_type();

    //get employee data
    $startWorkDate = "0000-00-00";
    $workDay = "";
    $yearWorked = 0;
    $sqlEmData = "SELECT employee.startWorkDate, recruitment.workDay FROM employee
        JOIN recruitment ON recruitment.recruitmentId = employee.recruitmentId
        WHERE employee.employeeId = '$emId';
    ";
    $rsEmData = $conn->query($sqlEmData);
    if($rsEmData->num_rows > 0){
        $dataEmData = $rsEmData->fetch_assoc();
        $startWorkDate = $dataEmData['startWorkDate'];
        $workDay = $dataEmData['workDay'];
        
        //count worked year
        $dateNow = get_date_now();
        $yearWorked = round(((strtotime($dateNow) - strtotime($startWorkDate)) / 31556952), 2);
    } else die("Failed to Get Start Work Date & Work Day Record...");
    

    $arrWorkDate = get_all_work_date($workDay, $yearSelected);

    //get leave rule
    $arrLeaveRule = [[]];
    $rsLeaveRule = $conn->query("SELECT * FROM leave_item WHERE minWorkedYear <= $yearWorked ORDER BY minWorkedYear DESC, leaveItemStartFrom DESC");
    if($rsLeaveRule->num_rows > 0){
        $arrLeaveRuleLength = count($arrLeaveRule) - 1;
        for ($i=0; $i < $rsLeaveRule->num_rows; $i++){ 
            $dataLeaveRule = $rsLeaveRule->fetch_assoc();
            $arrLeaveRule[$arrLeaveRuleLength][0] = $dataLeaveRule['leaveTypeId'];
            $arrLeaveRule[$arrLeaveRuleLength][1] = $dataLeaveRule['minWorkedYear'];
            $arrLeaveRule[$arrLeaveRuleLength++][2] = $dataLeaveRule['day'];
        }
    } elseif($rsLeaveRule->num_rows == 0) die("No Leave Rule Data Exist!");
    else die("Failed to Get Leave Rule...");


    //get available leave
    for ($i=0; $i < count($arrLeave); $i++) { 
        for ($j=0; $j < count($arrLeaveRule); $j++) { 
            if($arrLeave[$i][0] == $arrLeaveRule[$j][0]){
                $arrLeave[$i][2] = $arrLeaveRule[$j][2];
                break;
            }
        }
    }

    //get holiday
    $arrHoliday = [];
    $rsHoliday = $conn->query("SELECT * FROM holiday WHERE holidayDate >= '$yearSelected'");
    if($rsHoliday->num_rows >= 0){
        for ($i=0; $i < $rsHoliday->num_rows; $i++) { 
            $dataHoliday = $rsHoliday->fetch_assoc();
            $arrHoliday[$i] = $dataHoliday['holidayDate'];
        }
    } else die("Failed to Get Holiday Record...");


    //get leave request
    $arrLeaveRequest = [[]];
    $sqlLeaveRequest = "SELECT * FROM leave_request 
        WHERE employeeId = '$emId' 
        AND (startLeaveDateTime >= $yearSelected OR endLeaveDateTime < $yearNext)
        AND leaveStatus = 1
    ";
    $rsLeaveRequest = $conn->query($sqlLeaveRequest);
    if($rsLeaveRequest->num_rows > 0){
        $arrLeaveRequestLength = count($arrLeaveRequest) - 1;
        for ($i=0; $i < $rsLeaveRequest->num_rows; $i++){ 
            $dataLeaveRequest = $rsLeaveRequest->fetch_assoc();
            $arrLeaveRequest[$arrLeaveRequestLength][0] = $dataLeaveRequest['leaveTypeId'];
            $arrLeaveRequest[$arrLeaveRequestLength][1] = $dataLeaveRequest['startLeaveDateTime'];
            $arrLeaveRequest[$arrLeaveRequestLength++][2] = $dataLeaveRequest['endLeaveDateTime'];
        }

        //count Leave Left
        for ($i=0; $i < count($arrLeave); $i++) {
            for ($j=0; $j < count($arrLeaveRequest); $j++) {
                if($arrLeave[$i][0] == $arrLeaveRequest[$j][0]){
                    $startLeaveDT = date("Y-m-d", strtotime($arrLeaveRequest[$j][1]));
                    $endLeaveDT = date("Y-m-d", strtotime($arrLeaveRequest[$j][2]));

                    for ($k=0; $k < count($arrWorkDate); $k++) { 
                        $workDate = $arrWorkDate[$k];
                        if($workDate >= $startLeaveDT && $workDate <= $endLeaveDT) {
                            $arrLeave[$i][3]++; // +1 if leave taken

                            for ($l=0; $l < count($arrHoliday); $l++) { 
                                if($workDate == $arrHoliday[$l]) $arrLeave[$i][3]--; //-1 if leave taken date is holiday
                            }
                        }
                    }
                }
            }
        }

        showTable($arrLeave);
    } elseif($rsLeaveRequest->num_rows == 0) showTable($arrLeave);
    else echo_txt("Failed to Get Leave History...");

    // view_arrLeave($arrLeave);
    function view_arrLeave($arrLeave){
        for ($i=0; $i < count($arrLeave); $i++){
            echo "<br>";
            for ($j=0; $j < count($arrLeave[$i]); $j++) { 
                echo "<br>" . $arrLeave[$i][$j];
            }
        }
    }


    function showTable($arrLeave){
        echo_tag("tr class='text-center'", 0);
        echo_txt_tag("Leave Type", "th");
        echo_txt_tag("Leave Left", "th");
        echo_tag("tr", 1);

        for ($i=0; $i < count($arrLeave); $i++){
            if($i != count($arrLeave) - 1) echo_tag("tr", 0);
            echo_td($arrLeave[$i][1]);
            echo_tag("td class='text-center'", 0);
            if($arrLeave[$i][2] != 0) echo_txt(($arrLeave[$i][2] - $arrLeave[$i][3]) . "/" . $arrLeave[$i][2]);
            else echo_txt("Applied Leave: " . $arrLeave[$i][3]);
            echo_tag("td", 1);
            if($i != 0) echo_tag("tr", 1);
        }
    }

    function get_leave_type(){
        $arrLeave = [[]]; //0 leaveTypeId, 1 leaveName, 2 Total Available Leave, 3 Applied Leave
        global $conn;
        $rsLeaveType = $conn->query("SELECT * FROM leave_type");
        if($rsLeaveType->num_rows > 0){
            $arrLeaveLength = count($arrLeave) - 1;
            for ($i=0; $i < $rsLeaveType->num_rows; $i++){ 
                $dataLeave = $rsLeaveType->fetch_assoc();
                $arrLeave[$arrLeaveLength][0] = $dataLeave['leaveTypeId'];
                $arrLeave[$arrLeaveLength][1] = $dataLeave['leaveName'];
                $arrLeave[$arrLeaveLength][2] = 0;
                $arrLeave[$arrLeaveLength++][3] = 0;
            }
            return $arrLeave;
        } elseif($rsLeaveType->num_rows == 0) die("No Leave Type Data Exist!");
        else die("Failed to get Leave Type Existed..");
    }

    function get_all_work_date($work_day, $year){
        $arrDate = [];
        for ($month=1; $month <= 12; $month++) { 
            $arrWorkDay = str_split($work_day); // seperate & store in array
            $totalDayInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $firstDayInMonth = date("N", strtotime($year . "-" . $month . "-" . 1));
            for ($wd=0; $wd < count($arrWorkDay); $wd++) {
                $c = ($firstDayInMonth - $arrWorkDay[$wd]) * -1;
                if($c < 0) $c+=7;
                for ($i=$c+1; $i < $totalDayInMonth; $i+=7) {
                    $arrDate[count($arrDate)] = date("Y-m-d", strtotime($year . "-" . $month . "-" . $i));
                }
            }
        }
        sort($arrDate);
        return $arrDate;
    }
?>