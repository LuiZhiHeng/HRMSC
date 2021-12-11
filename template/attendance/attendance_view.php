<div class="row form-inline mb-2">
    <form action="attendance.php" method="GET">
        <button type="submit" class="btn btn-dark" name="history">View History</button>
        <button type="button" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#attModal">
            Update Attendance
        </button>
        <button type="button" class="btn btn-dark me-1 float-end" data-bs-toggle="modal" data-bs-target="#viewModal">
            Check Monthly Attendance
        </button>
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
                </tr>
            </thead>
            <tbody>
<?php
    $dateNow = get_date_now();
    $sql = "SELECT 
                attendance.attendanceId,
                employee.employeeName, 
                attendance.punchInDateTime,
                attendance.punchOutDateTime
            FROM attendance 
            JOIN employee ON employee.employeeId = attendance.employeeId
            WHERE attendanceDate = '$dateNow'
            ORDER BY attendance.punchInDateTime DESC";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i+1);
            for ($j=1; $j < count($data); $j++) { 
                echo_td($data[$j]);
            }
            if($data[3] != NULL) {
                $timeDif = strtotime($data[3]) - strtotime($data[2]) - 27000;
                $timeDif = date("H\h i\m s\s", $timeDif);
                echo_td($timeDif);
            }
            echo "</tr>";
        }
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