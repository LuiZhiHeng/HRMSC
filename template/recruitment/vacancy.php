<h1 class="mt-4">Job Vacancy</h1>
<hr>
<div class="card mb-3">
    <div class="card-body text-center border border-danger border-4" style="background-color: lightgoldenrodyellow">
        Please kindly email your resume to&nbsp;<a href="mailto:hrmsc@gmail.com">hrmsc@gmail.com</a>
        <br>
        <b>-- OR --</b>
        <br>
        Contact <a href="https://wa.me/0123456789">012-3456789</a> for more details
    </div>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Job Vacancy List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
        <thead>
                <tr>
                    <th>#</th>
                    <th>Position</th>
                    <th>Position Detail</th>
                    <th>Requirement</th>
                    <th>Working Day</th>
                    <th>Working Time</th>
                    <th>Salary</th>
                    <th>Allowance</th>
                    <th>Allowance Amount</th>
                </tr>
            </thead>
            <tbody>
            <?php
    $rsEm = $conn->query("SELECT recruitmentId From employee");
    $dataEmReId = $rsEm->fetch_array(MYSQLI_NUM);
    
    $sql = "SELECT 
                recruitment.recruitmentId,
                recruitment.position,
                recruitment.positionDetail,
                recruitment.requirement,
                recruitment.workDay,
                recruitment.startJobTime,
                recruitment.endJobTime,
                recruitment.salary,
                recruitment.peopleLimit
            FROM recruitment";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        $countNum = 0;
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);

            $rsE = $conn->query("SELECT employeeId FROM employee WHERE recruitmentId='$data[0]'");
            $numPeopleJobTaken = $rsE->num_rows;
            if($numPeopleJobTaken < $data[8]){
                echo "<tr>";
                echo_td(++$countNum);
                echo_td_pre($data[1]);
                echo_td_pre($data[2]);
                echo_td_pre($data[3]);
                $tempWorkDay = str_split($data[4]);
                echo "<td>";
                for ($wd=0; $wd < count($tempWorkDay); $wd++) { 
                    echo $tempWorkDay[$wd];
                    if($wd != count($tempWorkDay)-1) echo ", ";
                }
                echo "</td>";
                echo_td_pre($data[5] . " - " . $data[6]);
                echo_td("RM " . $data[7]);

                $sqlAllow = "SELECT * FROM allowance JOIN allowance_type ON allowance_type.allowanceTypeId = allowance.allowanceTypeId WHERE allowance.recruitmentId = '$data[0]'";
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
                        echo_td_pre($allowName);
                        echo_td($allowAmount);
                    }
                }
            }
            echo "</tr>";
        }
    }
?>
            </tbody>
        </table>
    </div>
</div>