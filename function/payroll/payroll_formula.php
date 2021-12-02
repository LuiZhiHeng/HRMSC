<?php

# start template method
    function console_log($data){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    function manage_rs($rs, $dataType){
        if(!$rs) console_log("Get " . $dataType . " failed!");
        elseif($rs->num_rows > 0) return $rs;
        elseif($rs->num_rows == 0) console_log("No " . $dataType . " record exist...");
        else console_log("Fail to get " . $dataType . " data!");
        return 0;
    }

# end template method

# start prepare payroll
    // $num 1=create, other=view
    function create_payroll($monthSelected, $yearSelected, $num){
        if($num == 0){
            $generateSuccess = 0;
            $rsEmRe = get_all_employee_recruitment_data($monthSelected, $yearSelected);
        } else {
            $sql = "SELECT
                        employee.employeeId,
                        employee.employeeName,
                        employee.startWorkDate,
                        employee.recruitmentId,
                        employee.birthday,
                        recruitment.salary,
                        recruitment.workDay,
                        recruitment.startJobTime,
                        recruitment.endJobTime
                    FROM employee
                    JOIN recruitment ON recruitment.recruitmentId = employee.recruitmentId
                    WHERE employee.employeeId = '$num'
                    ";
                    global $conn;
                $rsre = $conn->query($sql);
                $rsEmRe = manage_rs($rsre, "reem data");
        }
        if(!$rsEmRe) return 5;
        else {
            for ($i=0; $i < $rsEmRe->num_rows; $i++) { //get num total
                $arrEmRe = $rsEmRe->fetch_assoc();
                $emId = $arrEmRe['employeeId'];
                $emBirth = $arrEmRe['birthday'];
                $reWorkDay = $arrEmRe['workDay'];
                $reStartTime = $arrEmRe['startJobTime'];
                $reEndTime = $arrEmRe['endJobTime'];
                $workTimeTotal = get_work_time_total($reStartTime, $reEndTime);
                $salary = $arrEmRe['salary'];
                $allowance = get_allowance_total($arrEmRe['recruitmentId']);
                $arrWorkDate = get_all_work_date($reWorkDay, $monthSelected, $yearSelected);
                $arrNotWorkDate = get_not_work_date($reWorkDay, $monthSelected, $yearSelected);

            /** Start Earn */
                //get attendance record
                $rsAtt = get_attendance($emId, $monthSelected, $yearSelected);
                $present = $absent = $otNormal = $otRest = $otHoliday = $otPayNormal = $otPayRest = $otPayHoliday = 0;
                $otRateNormal = $otRateRest = $otRateHoliday = 0.0;
                $hourPay = get_hour_pay($salary, $reWorkDay, $workTimeTotal, $monthSelected, $yearSelected);
                if($rsAtt){
                    for ($loopAtt=0; $loopAtt < $rsAtt->num_rows; $loopAtt++) {
                        $arrAtt = $rsAtt->fetch_assoc();
                        $attDate = $arrAtt['attendanceDate'];
                        $punchIn = $arrAtt['punchInDateTime'];
                        $punchOut = $arrAtt['punchOutDateTime'];
                        $punchDuration = get_work_time_total($punchIn, $punchOut); 

                        // check attendance & check ot (Normal Day)
                        if(check_attend($attDate, $arrWorkDate)){// present
                            if($otHour = check_ot($punchDuration, $workTimeTotal) > 0) $otNormal += round($otHour);
                            $present++;
                        }

                        //check ot (Holiday)
                        if(check_ot_holiday($attDate)) $otHoliday += round($punchDuration);

                        // check ot (Rest Day)
                        if(check_attend($attDate, $arrNotWorkDate)) $otRest += round($punchDuration);
                        $otRest -= $otHoliday;
                    }
                
                    //ot payrate
                    $rsPayrate = get_ot_payrate();
                    for ($loopPayrate=0; $loopPayrate < $rsPayrate->num_rows; $loopPayrate++) { 
                        $arrPayrate = $rsPayrate->fetch_assoc();
                        $minHour = $arrPayrate['minWorkedHour'];
                        $rate = $arrPayrate['payrate'];
                        $dayType = $arrPayrate['dayTypeId'];
                        
                        if($dayType == 1){// Normal Day
                            if($otNormal >= $minHour) {
                                $otPayNormal += $otNormal * $rate  * $hourPay;
                                $otRateNormal += $rate;
                                break;
                            }
                        }
                    }
                
                    for ($loopPayrate=0; $loopPayrate < $rsPayrate->num_rows; $loopPayrate++) { 
                        $arrPayrate = $rsPayrate->fetch_assoc();
                        $minHour = $arrPayrate['minWorkedHour'];
                        $rate = $arrPayrate['payrate'];
                        $dayType = $arrPayrate['dayTypeId'];

                        if($dayType == 2){// Rest Day
                            if($otRest >= $minHour) {
                                $otPayRest += $otRest * $rate * $hourPay;
                                $otRateRest += $rate;
                                break;
                            }
                        }
                    }

                    for ($loopPayrate=0; $loopPayrate < $rsPayrate->num_rows; $loopPayrate++) { 
                        $arrPayrate = $rsPayrate->fetch_assoc();
                        $minHour = $arrPayrate['minWorkedHour'];
                        $rate = $arrPayrate['payrate'];
                        $dayType = $arrPayrate['dayTypeId'];
                        if($dayType == 3){// Normal Day
                            if($otHoliday >= $minHour) {
                                $otPayHoliday += $otHoliday * $rate * $hourPay;
                                $otRateHoliday += $rate;
                                break;
                            }
                        }
                    }
                } else {
                    $absent = count($arrWorkDate);
                }
                
                $otPay = $otPayNormal + $otPayRest + $otPayHoliday;
                $otHour = $otNormal + $otRest + $otHoliday;
            # basic pay
                $basicPay = round($salary + $allowance + $otPay, 2);
            /** End Earn */

            /** Start Deduct */
                $absent = count($arrWorkDate) - $present;
                $rsLeave = get_leave($emId);
                $totalLeave = 0;
                if(!$rsLeave) $totalLeave = 0;
                elseif($rsLeave->num_rows > 0) {
                    for ($k=0; $k < $rsLeave->num_rows; $k++) { 
                        $arrLeave = $rsLeave->fetch_array(MYSQLI_NUM);
                        if(check_attend($arrLeave[$i], $arrWorkDate)) {
                            $absent--;
                            $totalLeave++;
                        }
                    }
                }
                $absentDeduct = $absent * $hourPay * $workTimeTotal;
                $fakeBasicPay = $basicPay - $absentDeduct;

                //epf, socso, eis
                $rsPayrollRule = get_payroll_rule();
                $epfPercentEm = $epfPercentBoss = $epfEm = $socsoEm = $eisEm = $epfBoss = $socsoBoss = $eisBoss = 0;
                $ageEm = get_age($emBirth);
                for ($loopRule=0; $loopRule < $rsPayrollRule->num_rows; $loopRule++) { 
                    $arrRule = $rsPayrollRule->fetch_assoc();
                    $minSalary = $arrRule['minSalary'];
                    $minAge = $arrRule['minAge'];
                    $percentEm = $arrRule['percentEmployee'];
                    $percentBoss = $arrRule['percentEmployer'];
                    $ruleType = $arrRule['payrollItemTypeId'];
                
                    if($salary >= $minSalary && $ageEm >= $minAge){
                        if($ruleType == 1){ // EPF
                            $epfEm += $fakeBasicPay * $percentEm;
                            $epfBoss += $fakeBasicPay * $percentBoss;
                            $epfPercentEm += $percentEm * 100;
                            $epfPercentBoss += $percentBoss * 100;
                        } else if($ruleType == 2){ // SOCSO
                            $socsoEm += $fakeBasicPay * $percentEm;
                            $socsoBoss += $fakeBasicPay * $percentBoss;
                        } else if($ruleType == 3){ // EIS
                            $eisEm += $percentEm;
                            $eisBoss += $percentBoss;
                        }
                    }
                }

                $totalDeduct = round($epfEm + $socsoEm + $eisEm + $absentDeduct, 2);
            /** End Deduct */

                $contributionBoss = $epfBoss + $socsoBoss + $eisBoss;
                $netPay = round($basicPay - $totalDeduct, 2);

                if($num == 0){
                    if(add_payroll($emId, $monthSelected, $yearSelected, $basicPay, $totalDeduct, $netPay) == 0) $generateSuccess = 0;
                    else $generateSuccess = 1;
                }
            }
            if($num == 0) return $generateSuccess;
            else {
                return [$salary, $otHour, $otPay, $allowance, $basicPay, //0-3
                    $epfPercentEm, $epfEm, $socsoEm, $eisEm, $absent, $absentDeduct, //4-9
                    $totalDeduct, $netPay, //10-11
                    $otNormal, $otRateNormal, $otPayNormal, //12-14
                    $otRest, $otRateRest, $otPayRest, //15-17
                    $otHoliday, $otRateHoliday, $otPayHoliday, //18-20
                    $otHour, $otPay, //21 - 22
                    $epfPercentBoss, $epfBoss, $socsoBoss, $eisBoss, //23-26
                    $contributionBoss
                ];
            }
        }
    }

# end prepare payroll


    function add_payroll($emId, $month, $year, $basicPay, $deduct, $netPay){
        global $conn;
        $rs = $conn->query("INSERT INTO payroll VALUES (NULL, '$emId', '$month', '$year', NULL, '$basicPay', '$deduct', '$netPay');");
        if(!$rs) {
            console_log("generate payroll failed");
            return 0;
        } else return 1;
    }

    function check_attend($attDate, $arrWorkDate){
        for ($j=0; $j < count($arrWorkDate); $j++) {
            if($attDate == $arrWorkDate[$j]) return true;
        }
        return false;
    }

    function check_ot_holiday($attDate){
        $rsHoliday = get_holiday();
        for ($i=0; $i < $rsHoliday->num_rows; $i++) { 
            $arrHoliday = $rsHoliday->fetch_assoc();
            $holidayDate = $arrHoliday['holidayDate'];

            if($attDate == $holidayDate) return true;
        }
        return false;
    }

    function check_ot($punch, $work){
        if($ot = floor($punch - $work)) return $ot;
        else return 0;
    }

    function get_work_time_total($startTime, $endTime){
        return abs((strtotime($endTime) - strtotime($startTime))/3600);
    }


    function get_allowance_total($reId){
        $rsAllow = get_allowance_data($reId);
        $totalAllow = 0;
        for ($i=0; $i < $rsAllow->num_rows; $i++) { 
            $dataAllow = $rsAllow->fetch_assoc();
            $totalAllow += $dataAllow['allowanceAmount'];
        }
        return $totalAllow;
    }

// hour pay
    function get_hour_pay($month_pay, $work_day, $work_hour, $month, $year){
        $workDay = get_worked_day_total($work_day, $month, $year);
        $hour_pay = ($month_pay / $workDay)/ $work_hour;
        return $hour_pay;
    }

//ot payrate
    function get_ot_payrate(){
        global $conn;
        $sql = " SELECT * FROM overtime_payrate
                JOIN overtime_day_type ON overtime_day_type.dayTypeId = overtime_payrate.dayTypeId
                ORDER BY overtime_payrate.dayTypeId ASC, overtime_payrate.minWorkedHour DESC, overtime_payrate.overtimePayrateStartFrom DESC
                ";
        $rs = $conn->query($sql);
        return manage_rs($rs, "overtime payrate");
    }

// worked day
    // get total of day worked in a month
    function get_worked_day_total($work_day, $month, $year){
        $arrWorkDay = str_split($work_day); // seperate & store in array
        $totalDayInMonth = get_num_day_in_month($year, $month);
        $firstDayInMonth = get_day_by_date($year, $month);
        $countWorkedDay = 0;
        for ($wd=0; $wd < count($arrWorkDay); $wd++) {
            $c = ($firstDayInMonth - $arrWorkDay[$wd]) * -1;
            if($c < 0) $c+=7;
            for ($i=$c+1; $i < $totalDayInMonth; $i+=7) $countWorkedDay++;
        }
        return $countWorkedDay;
    }
    
    //get all work date
    function get_all_work_date($work_day, $month, $year){
        $arrWorkDay = str_split($work_day); // seperate & store in array
        $totalDayInMonth = get_num_day_in_month($year, $month);
        $firstDayInMonth = get_day_by_date($year, $month);
        $arrDate = [];
        for ($wd=0; $wd < count($arrWorkDay); $wd++) {
            $c = ($firstDayInMonth - $arrWorkDay[$wd]) * -1;
            if($c < 0) $c+=7;
            for ($i=$c+1; $i < $totalDayInMonth; $i+=7) {
                $arrDate[count($arrDate)] = date("Y-m-d", strtotime($year . "-" . $month . "-" . $i));
            }
        }
        sort($arrDate);
        return $arrDate;
    }

    function get_not_work_date($work_day, $month, $year){
        $tempSplit = str_split($work_day); // seperate & store in array
        $tempNum = "1234567";
        for ($i=0; $i < count($tempSplit); $i++) { 
            $tempNum = str_replace($tempSplit[$i], "", $tempNum);
        }
        $arrWorkDay = str_split($tempNum);
        $totalDayInMonth = get_num_day_in_month($year, $month);
        $firstDayInMonth = get_day_by_date($year, $month);
        $arrDate = [];
        for ($wd=0; $wd < count($arrWorkDay); $wd++) {
            $c = ($firstDayInMonth - $arrWorkDay[$wd]) * -1;
            if($c < 0) $c+=7;
            for ($i=$c+1; $i < $totalDayInMonth; $i+=7) {
                $arrDate[count($arrDate)] = date("Y-m-d", strtotime($year . "-" . $month . "-" . $i));
            }
        }
        sort($arrDate);
        return $arrDate;
    }

    function get_num_day_in_month($year, $month){
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }

    function get_day_by_date($year, $month, $day = 1){
        return date("N", strtotime($year."-".$month."-".$day));
    }




// employee recruitment
    function get_all_employee_recruitment_data($month, $year){
        global $conn;
        $date = date("Y-m-d", strtotime($year . '-'. ($month+1) . '-01'));
        $sql = "SELECT
                    employee.employeeId,
                    employee.employeeName,
                    employee.startWorkDate,
                    employee.recruitmentId,
                    employee.birthday,
                    recruitment.salary,
                    recruitment.workDay,
                    recruitment.startJobTime,
                    recruitment.endJobTime
                FROM employee
                JOIN recruitment ON recruitment.recruitmentId = employee.recruitmentId
                WHERE employee.endWorkDate = '0000-00-00' AND employee.startWorkDate < '$date'
                ";
        $rs = $conn->query($sql);
        return manage_rs($rs, "employee recruitment");
    }

// allowance
    function get_allowance_data($recruitmentId){
        global $conn;
        $sql = "SELECT 
                    * 
                FROM allowance
                JOIN allowance_type ON allowance_type.allowanceTYpeId = allowance.allowanceTypeId
                WHERE allowance.recruitmentId='$recruitmentId'
        
            ";
        $rs = $conn->query($sql);
        return manage_rs($rs, "allowance");
    }

// payroll rule
    function get_payroll_rule(){
        global $conn;
        $sql = " SELECT
                    *
                FROM payroll_item
                JOIN payroll_item_type ON payroll_item_type.payrollItemTypeId = payroll_item.payrollItemTypeId
                ORDER BY payroll_item.payrollItemTypeId ASC, payroll_item.minSalary DESC, payroll_item.minAge DESC, payroll_item.payrollItemStartFrom DESC
            ";
        $rs = $conn->query($sql);
        return manage_rs($rs, "payroll rule");
    }

// attendance
    function get_attendance($employeeId, $month, $year){
        global $conn;
        $firstday = date("Y-m-d", strtotime($year . '-' . $month . '-01'));
        $nextMonthFirstDay = date("Y-m-d", strtotime($year . '-' . ($month+1) . '-01'));
        $rs = $conn->query("SELECT * FROM attendance WHERE employeeId='$employeeId' AND punchOutDateTime != '0000-00-00 00:00:00' AND attendanceDate >= '$firstday' AND attendanceDate < '$nextMonthFirstDay'");
        return manage_rs($rs, "attendance");
    }

// leave
    function get_leave($employeeId){
        global $conn;
        $sql = "SELECT 
                    leaveTypeId,
                    startLeaveDateTime,
                    endLeaveDateTime
                FROM leave_request
                WHERE employeeId='$employeeId' AND leaveStatus = 1
        ";
        $rs = $conn->query($sql);
        return manage_rs($rs, "leave request");
    }

//holiday
    function get_holiday(){
        global $conn;
        $rs = $conn->query("SELECT * FROM holiday");
        return manage_rs($rs, "holiday");
    }

// leave item (total leave offered for dif type)
    function get_leave_item(){
        global $conn;
        $sql = "SELECT 
                *
                FROM leave_item
                JOIN leave_type ON leave_type.leaveTypeId = leave_item.leaveTypeId
                ";
        $rs = $conn->query($sql);
        return manage_rs($rs, "leave request");
    }

// count age
    function get_age($birth){
        return get_year_now() - date("Y", strtotime($birth));
    }

?>