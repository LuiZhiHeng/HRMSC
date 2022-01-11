<div class="row form-inline mb-2">
    <form>
        <a href="attendance.php?punch=" type="button" class="btn btn-danger me-1 float-start">
            Punch
        </a>
        <button type="button" class="btn btn-dark me-1 float-end" data-bs-toggle="modal" data-bs-target="#viewModal">
            Check Monthly Attendance
        </button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Personal Attendance Record
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Punch In</th>
                    <th>Punch Out</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
<?php
    $uId = get_logged_user_id();
    $sql = "SELECT attendanceDate, punchInDateTime, punchOutDateTime FROM attendance WHERE employeeId = '$uId' ORDER BY attendanceDate DESC";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo_tag("tr", 0);
            echo_td($i+1);
            for ($j=0; $j < count($data); $j++) { 
                echo_td($data[$j]);
            }
            if($data[2] != NULL) {
                $timeDif = strtotime($data[2]) - strtotime($data[1]) - 27000;
                $timeDif = date("H\h i\m s\s", $timeDif);
                echo_td($timeDif);
            }
            echo_tag("tr", 1);
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
                <input type="hidden" name="emName" id="emName" value="<?= get_logged_user_id() ?>" hidden>
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
</script>