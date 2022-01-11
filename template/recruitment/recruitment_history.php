    <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Recruitment History List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Position</th>
                    <th>Position Detail</th>
                    <th>Requirement</th>
                    <th>People Limit</th>
                    <th>Working Day</th>
                    <th>Working Time</th>
                    <th>Salary</th>
                    <th>Allowance</th>
                </tr>
            </thead>
            <tbody>
<?php
    $sql = "SELECT
                employee.employeeName,
                recruitment.recruitmentId,
                recruitment.position,
                recruitment.positionDetail,
                recruitment.requirement,
                recruitment.peopleLimit,
                recruitment.workDay,
                recruitment.startJobTime,
                recruitment.endJobTime,
                recruitment.salary
            FROM recruitment
            JOIN employee ON employee.recruitmentId = recruitment.recruitmentId";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        $countNum = 0;
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);

            $rsE = $conn->query("SELECT employeeId FROM employee WHERE recruitmentId='$data[1]'");
            $numPeopleJobTaken = $rsE->num_rows;
            if($data[5] >= 1){
                echo "<tr>";
                echo_td(++$countNum);
                echo_td($data[0]);
                echo_td_pre($data[2]);
                echo_td_pre($data[3]);
                echo_td_pre($data[4]);
                echo_td($numPeopleJobTaken . "/" . $data[5]);
                $tempWorkDay = str_split($data[6]);
                echo "<td>";
                for ($wd=0; $wd < count($tempWorkDay); $wd++) { 
                    echo $tempWorkDay[$wd];
                    if($wd != count($tempWorkDay)-1) echo ", ";
                }
                echo "</td>";
                echo_td_pre($data[7] . " - " . $data[8]);
                echo_td("RM " . $data[9]);

                $sqlAllow = "SELECT * FROM allowance JOIN allowance_type ON allowance_type.allowanceTypeId = allowance.allowanceTypeId WHERE allowance.recruitmentId = '$data[1]'";
                $rsAllow = $conn->query($sqlAllow);
                
                $allowName = $allowAmount = "";
                for ($j=0, $allow_temp = ""; $j < $rsAllow->num_rows; $j++) { 
                    $dataAllow = $rsAllow->fetch_assoc();
                    $allowName = $dataAllow['allowanceName'];
                    $allowAmount = $dataAllow['allowanceAmount'];
                    $allow_temp .= "-" . $allowName . " (RM" . $allowAmount. ")" . "\n";
                }
                echo_td_pre($allow_temp);

                echo "</tr>";
            }
        }
    }
?>
            </tbody>
        </table>
    </div>
</div>