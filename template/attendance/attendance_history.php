<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Attendance History List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Employee Name</th>
                    <th>Punch In</th>
                    <th>Punch Out</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
<?php
    $sql = "SELECT 
                attendance.attendanceDate,
                employee.employeeName, 
                attendance.punchInDateTime,
                attendance.punchOutDateTime
            FROM attendance 
            JOIN employee ON employee.employeeId = attendance.employeeId
            ORDER BY attendance.attendanceDate DESC";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i+1);
            for ($j=0; $j < count($data); $j++) { 
                echo_td($data[$j]);
            }
            if($data[3] != NULL && $data[3] != "0000-00-00 00:00:00") {
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