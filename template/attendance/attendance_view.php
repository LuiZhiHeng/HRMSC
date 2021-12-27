<div class="row form-inline mb-2">
    <form action="attendance.php" method="GET">
        <button type="submit" class="btn btn-dark" name="history">View History</button>
        <button type="button" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#attModal">
            Update Attendance
        </button>
        <button type="button" class="btn btn-dark me-1 float-end" data-bs-toggle="modal" data-bs-target="#viewModal">
            Check Monthly Attendance
        </button>
        <a href="attendance.php?qr=" class="btn btn-primary me-1 float-end">
            <i class="fas fa-qrcode"></i>
            QR Code
        </a>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Attendance Record List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Punch In</th>
                    <th>Punch Out</th>
                    <th>Duration</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
<?php
    //get employee who work today
    $arrAtt = [[]]; // 0-id 1-name 2-leaveYN 3-in 4-out
    $arrAttLen = 0;
    $dateNow = get_date_now();
    // $dateNow = "2021-12-13"; #test purpose only
    $dayNow = date('w');
    if($dayNow == 0) $dayNow += 7;
    // $dayNow = 1; #test purpose only
    $sql = "SELECT employee.employeeId, employee.employeeName FROM recruitment 
            JOIN employee ON employee.recruitmentId = recruitment.recruitmentId 
            WHERE employee.startWorkDate <= '$dateNow' AND recruitment.workDay LIKE '%$dayNow%'
            AND (employee.endWorkDate = NULL OR employee.endWorkDate = '0000-00-00' OR employee.endWorkDate >= '$dateNow')
            ";
    $rs = $conn->query($sql);
    if(!$rs) console("Fail to get Recruitment Data");
    elseif($rs->num_rows >= 0){
        for ($i=0; $i < $rs->num_rows; $i++) {
            $dataEmWork = $rs->fetch_array(MYSQLI_NUM);
            $arrAtt[$i][0] = $dataEmWork[0];
            $arrAtt[$i][1] = $dataEmWork[1];
            $arrAttLen++;
        }
    }

    //get leave record
    $nowDT1 = $dateNow . " 00:00:00";
    $nowDT2 = date("Y-m-") . (date("d")) . " 11:59:59";
    // $nowDT2 = "2021-12-13 11:59:59"; #test purpose only
    $sql = "SELECT employee.employeeId FROM leave_request
            JOIN employee ON leave_request.employeeId = employee.employeeId
            WHERE startLeaveDateTime >= '$nowDT1' AND endLeaveDateTime <= '$nowDT2'
            OR startLeaveDateTime <= '$nowDT1' AND endLeaveDateTime >= '$nowDT1'
            OR startLeaveDateTime <= '$nowDT2' AND endLeaveDateTime >= '$nowDT2'
            OR startLeaveDateTime <= '$nowDT1' AND endLeaveDateTime >= '$nowDT2';
    ";
    $rsLeave = $conn->query($sql);
    $leaveNum = (!$rsLeave) ? 0 : $rsLeave->num_rows;
    if($leaveNum > 0){
        for ($i=0; $i < $leaveNum; $i++) { 
            $dataLeave = $rsLeave->fetch_array(MYSQLI_NUM);
            for ($j=0; $j < $arrAttLen; $j++) { 
                if(isset($arrAtt[$j][0]) && $arrAtt[$j][0] == $dataLeave[0]) {
                    $arrAtt[$j][2] = 1; //on leave
                }
            }
        }
    }

    //get attendance today
    $rs = $conn->query("SELECT attendance.*, employee.employeeName FROM attendance JOIN employee ON employee.employeeId = attendance.employeeId WHERE attendanceDate = '$dateNow'");
    if(!$rs) console("Fail to get Attendance Data");
    elseif($rs->num_rows >= 0){
        for ($i=0; $i < $rs->num_rows; $i++) {
            $data = $rs->fetch_array(MYSQLI_NUM);
            for ($j=0; $j < $arrAttLen; $j++) { 
                if(isset($arrAtt[$j][0]) && $arrAtt[$j][0] == $data[1]){
                    $arrAtt[$j][3] = $data[3]; //inDT
                    $arrAtt[$j][4] = $data[4]; //outDT
                    if(!isset($arrAtt[$j][2])) $arrAtt[$j][2] = 0; //leaveYN
                    $arrAttLen++;
                    break;
                } elseif($j == $arrAttLen-1){ //ot
                    $arrAtt[$arrAttLen][0] = $data[1]; //id
                    $arrAtt[$arrAttLen][1] = $data[5]; //name
                    $arrAtt[$arrAttLen][2] = 2;
                    $arrAtt[$arrAttLen][3] = $data[3]; //inDt
                    $arrAtt[$arrAttLen++][4] = $data[4]; //outDT
                }
            }
        }
    }

    //display
    for ($i=0; $i < $arrAttLen; $i++) { 
        echo "<tr>";
        
        if($numStart == 0) echo_td($i+1); //num
        elseif($numStart == 1) echo_td($i);
        echo_td($arrAtt[$i][1]); //name
        if(!isset($arrAtt[$i][3])) echo "<td class='text-center'>-</td>"; //inDT
        else echo_td($arrAtt[$i][3]);
        if(!isset($arrAtt[$i][4])) echo "<td class='text-center'>-</td>"; //outDT
        else echo_td($arrAtt[$i][4]);

        //cal & echo duration
        if(isset($arrAtt[$i][3]) && isset($arrAtt[$i][4])){
            $timeDif = strtotime($arrAtt[$i][4]) - strtotime($arrAtt[$i][3]) - 27000;
            $timeDif = date("H\h i\m s\s", $timeDif);
            echo_td($timeDif);
        } else echo "<td class='text-center'>-</td>";

        //echo status
        if(isset($arrAtt[$i][2]) && $arrAtt[$i][2] == 1) echo "<td class='text-center text-secondary fw-bold'>Leave</td>";
        elseif(isset($arrAtt[$i][4]) && $arrAtt[$i][2] == 0) echo "<td class='text-center text-success fw-bold'>Punched Out</td>";
        elseif(isset($arrAtt[$i][4]) && $arrAtt[$i][2] == 2) echo "<td class='text-center text-success fw-bold'>OT Punched Out</td>";
        elseif(isset($arrAtt[$i][3]) && $arrAtt[$i][2] == 0) echo "<td class='text-center text-warning fw-bold'>Punched In</td>";
        elseif(isset($arrAtt[$i][4]) && $arrAtt[$i][2] == 2) echo "<td class='text-center text-success fw-bold'>OT Punched In</td>";
        else echo "<td class='text-center text-danger fw-bold'>Absent</td>";

        echo "</tr>";
    }
?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title" class="modal-title">View Monthly Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <label for="emName">Employee:</label>
                <select class="form-control form-select mb-2" name="emName" id="emName" onchange="getAttendance()">
                <?php
                    $yearNow = get_year_now();
                    $sql = "SELECT employeeId, employeeName FROM employee WHERE startWorkDate >= $yearNow AND endWorkDate = '0000-00-00'";
                    $rs = $conn->query($sql);
                    if ($rs->num_rows > 0){
                        for ($i=0; $i < $rs->num_rows; $i++){ 
                            $emData = $rs->fetch_array(MYSQLI_NUM);
                            echo '<option value="' . filterOutput($emData[0]) . '">' . filterOutput($emData[1]) . '</option>';
                        }
                    }
                ?>
                </select>
                <label for="month">Month:</label>
                <input type="number" class="form-control mb-2" min="1" max="12" id="month" name="month" onkeyup="getAttendance()" required>
                <label for="year">Year:</label>
                <input type="number" min="1900" max="3000" class="form-control mb-2" id="year" name="year" onkeyup="getAttendance()" required>
                <table id="attendanceTable" class="table table-bordered">
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attModal" tabindex="-1" aria-labelledby="attModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title" class="modal-title">Add Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="attendance.php" method="POST" onsubmit="return confirms('Update Attendance')">
                    <label for="emN">Employee:</label>
                    <select class="form-control form-select mb-2" name="emN" id="emN" onchange="getPunchTime()">
                    <?php
                        $yearNow = get_year_now();
                        $sql = "SELECT employeeId, employeeName FROM employee WHERE startWorkDate >= $yearNow AND endWorkDate = '0000-00-00'";
                        $rs = $conn->query($sql);
                        if ($rs->num_rows > 0){
                            for ($i=0; $i < $rs->num_rows; $i++){ 
                                $emData = $rs->fetch_array(MYSQLI_NUM);
                                echo '<option value="' . filterOutput($emData[0]) . '">' . filterOutput($emData[1]) . '</option>';
                            }
                        }
                    ?>
                    </select>
                    <label for="attDate">Date:</label>
                    <input type="date" class="form-control mb-2" id="attDate" name="attDate" onchange="getPunchTime()" required>
                    <label for="check-in">Check-In Time: <span id="inYN"></span></label>
                    <input type="time" class="form-control mb-2" id="check-in" name="check-in" required>
                    <label for="check-out">Check-Out Time: <span id="outYN"></span></label>
                    <input type="time" class="form-control mb-2" id="check-out" name="check-out" required>
                    <button type="submit" class="form-control btn btn-danger" name="addAtt">Update Attendance</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function getAttendance() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("attendanceTable").innerHTML = this.responseText;
            }
        };
        var id = document.getElementById("emName").value;
        var month = document.getElementById("month").value;
        var year = document.getElementById("year").value;
        
        xmlhttp.open("GET", "function/attendance/getMonthlyAttendance.php?n=" + id + "&m=" + month + "&y=" + year, true);
        xmlhttp.send();
    }

    function getPunchTime() {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText.length == 12){
                    document.getElementById("check-in").value = this.responseText.substr(0, 5);
                    document.getElementById("check-out").value = this.responseText.substr(5, 5);
                    if(this.responseText.substr(10, 1) == 1) document.getElementById("inYN").innerText = "(Checked In)";
                    else document.getElementById("inYN").innerText = "";
                    if(this.responseText.substr(11, 1) == 1) document.getElementById("outYN").innerText = "(Checked Out)";
                    else document.getElementById("outYN").innerText = "";
                }
            }
        };
        var id = document.getElementById("emN").value;
        var date = document.getElementById("attDate").value;
        ajax.open("GET", "function/attendance/getPunchTime.php?n=" + id + "&d=" + date, true);
        ajax.send();
    }
</script>