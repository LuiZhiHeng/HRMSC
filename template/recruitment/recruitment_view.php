<div class="row form-inline mb-2">
    <form action="recruitment.php" method="GET">
        <button type="submit" class="btn btn-dark" name="history">View History</button>
        <button type="submit" class="btn btn-danger" name="add">Add Job</button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Job List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Position</th>
                    <th>Position Detail</th>
                    <th>Requirement</th>
                    <th>People Limit</th>
                    <th>Working Day</th>
                    <th>Working Time</th>
                    <th>Salary</th>
                    <th>Allowance</th>
                    <th>Allowance Amount</th>
                    <th>Action</th>
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
                recruitment.peopleLimit,
                recruitment.workDay,
                recruitment.startJobTime,
                recruitment.endJobTime,
                recruitment.salary
            FROM recruitment";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        $countNum = 0;
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);

            $rsE = $conn->query("SELECT employeeId FROM employee WHERE recruitmentId='$data[0]'");
            $numPeopleJobTaken = $rsE->num_rows;
            if($numPeopleJobTaken < $data[4]){
                echo "<tr>";
                for ($j=0; $j < count($data); $j++) {
                    if($j == 0) echo_td(++$countNum);
                    elseif($j == 4) echo_td($numPeopleJobTaken . "/" . $data[4]);
                    elseif($j == 5){
                        $tempWorkDay = str_split($data[5]);
                        echo "<td>";
                        for ($wd=0; $wd < count($tempWorkDay); $wd++) { 
                            echo $tempWorkDay[$wd];
                            if($wd != count($tempWorkDay)-1) echo ", ";
                        }
                        echo "</td>";
                    } elseif($j == 6) echo "<td>" . filterOutput($data[6]) . " - ";
                    elseif($j == 7) echo filterOutput($data[7]) . "</td>";
                    elseif($j == 8) echo_td("RM " . $data[8]);
                    else echo_td($data[$j]);
                }

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
                        echo_td($allowName);
                        echo_td($allowAmount);
                    }
                }
?>
            <td>
                <form action="recruitment.php" method="GET">
                    <input type="hidden" name="id" value="<?= $data[0] ?>" hidden>
                    <button class="btn btn-success form-control mb-1" type="submit" name="edit">Edit</button>
                    <button class="btn btn-warning form-control mb-1" type="submit" name="editAllowance">Edit Allowance</button>
                </form>
            </td>
<?php
                echo "</tr>";
            }
        }
    }
?>
            </tbody>
        </table>
    </div>
</div>