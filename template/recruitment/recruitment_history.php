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
                    <th>Allowance Amount</th>
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
                for ($j=0; $j < count($data); $j++) {
                    if($j == 5) echo_td($numPeopleJobTaken . "/" . $data[$j]);
                    elseif($j == 6){
                        $tempWorkDay = str_split($data[$j]);
                        echo "<td>";
                        for ($wd=0; $wd < count($tempWorkDay); $wd++) { 
                            echo_txt($tempWorkDay[$wd]);
                            if($wd != count($tempWorkDay)-1) echo ", ";
                        }
                        echo "</td>";
                    } elseif($j == 7) echo "<td>" . filterOutput($data[$j]) . " - ";
                    elseif($j == 8) echo $data[$j] . "</td>";
                    elseif($j == 9) echo_td("RM " . $data[$j]);
                    elseif($j != 1) echo_td($data[$j]);
                }

                $sqlAllow = "SELECT * FROM allowance JOIN allowance_type ON allowance_type.allowanceTypeId = allowance.allowanceTypeId WHERE allowance.recruitmentId = '$data[1]'";
                $rsAllow = $conn->query($sqlAllow);
                
                $allowName = $allowAmount = "";
                for ($j=0; $j < $rsAllow->num_rows; $j++) { 
                    $dataAllow = $rsAllow->fetch_assoc();
                    
                    $allowName .= $dataAllow['allowanceName'];
                    $allowAmount .= $dataAllow['allowanceAmount'];
                    
                    if($j != $rsAllow->num_rows - 1){
                        $allowName .= ", ";
                        $allowAmount .= ", ";
                    } else {
                        echo_td($allowName);
                        echo_td($allowAmount);
                    }
                }
                echo "</tr>";
            }
        }
    }
?>
            </tbody>
        </table>
    </div>
</div>