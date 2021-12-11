<?php
    //get employee who work today
    $dateNow = get_date_now();
    $dayNow = get_day_now();
    $dayNow += 0;
    $dayNow = strval($dayNow);
    $sql = "SELECT employee.employeeId FROM recruitment 
            JOIN employee ON employee.recruitmentId = recruitment.recruitmentId 
            WHERE employee.startWorkDate <= '$dateNow' AND recruitment.workDay LIKE '%$dayNow%'
            AND (employee.endWorkDate = NULL OR employee.endWorkDate = '0000-00-00' OR employee.endWorkDate >= '$dateNow')
            ";
    $rs = $conn->query($sql);
    $arrEmId = [];
    if(!$rs) console("Fail to get Recruitment Data");
    elseif($rs->num_rows >= 0){
        for ($i=0; $i < $rs->num_rows; $i++) {
            $arrEmId[$i] = $rs->fetch_array(MYSQLI_NUM)[0];
        }
    } else console("Fail to get Recruitment Data");

    //get attendance today
    $inOT = $outOT = $in = $out = 0;
    $rs = $conn->query("SELECT * FROM attendance WHERE attendanceDate = '$dateNow'");
    if(!$rs) console("Fail to get Attendance Data");
    elseif($rs->num_rows >= 0){
        for ($i=0; $i < $rs->num_rows; $i++) {
            $data = $rs->fetch_assoc();
            $empId = $data['employeeId'];
            $outDT = $data['punchOutDateTime'];
            for ($j=0; $j < count($arrEmId); $j++) { 
                if($arrEmId[$j] == $empId){
                    $in++;
                    if($outDT != "0000-00-00 00:00:00" && $outDT != NULL) $out++;
                    break;
                } elseif($j == count($arrEmId) - 1){
                    $inOT++;
                    if($outDT != "0000-00-00 00:00:00" && $outDT != NULL) $outOT++;
                }
            }
        }
    } else console("Fail to get Attendance Data");
?>
<script src="asset/js/chart.js" type="text/javascript"></script>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Attendance Type', 'Total'],
    <?php if(count($arrEmId) == 0){ ?>
        ['No work', 1],
    <?php } else { ?>
        ['notuse', 0],
    <?php } ?>
        ['Absent', <?= (count($arrEmId) - $in) ?>],
        ['Punched In', <?= $in - $out ?>],
        ['Punched Out', <?= $out ?>],
        ['OT Punched In', <?= $inOT - $outOT ?>],
        ['OT Punched Out', <?= $outOT ?>]
    ]);

    var options = {
        pieHole: 0.4,
        pieSliceText: 'value',
        chartArea: {'width': '100%', 'height': '80%'},
        slices: {
            0: { color: '#6c757d' },
            1: { color: '#dc3545' },
            2: { color: '#ffc107' },
            3: { color: '#198754' },
            4: { color: '#fd7e14' },
            5: { color: '#20c997' }
        }
    };

    var chartAtt = document.getElementById('chart_att')
    var chart = new google.visualization.PieChart(chartAtt);
    chart.draw(data, options);
    }
</script>

<div class="row">
<?php
    show_request("Leave Request", "leave.php?request=", '<i class="fas fa-business-time"></i>', "danger", "SELECT count(leaveId) FROM leave_request WHERE leaveStatus=3");
    show_request("Claim Request", "claim.php", '<i class="fas fa-coins"></i>', "warning", "SELECT count(claimId) FROM claim_request WHERE claimStatus=3");
    show_request("Unprepared Claim Request", "claim.php", '<i class="fas fa-coins"></i>', "success", "SELECT count(claimId) FROM claim_request WHERE claimStatus=5");
?>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-pie me-1"></i>
                Attendance Today (<?= display_date(); ?>)
            </div>
            <div class="card-body">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div id="chart_att"></div>
                    </div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                    <div id="chart_att"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-sm-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Employee On Leave
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Employee</th>
                        <th>From</th>
                        <th>Until</th>
                    </tr>
<?php
    $nowDT1 = get_date_now() . " 00:00:00";
    $nowDT2 = date("Y-m-") . (date("d")+1) . " 11:59:59";
    $sql = "SELECT employee.employeeName, 
                leave_request.startLeaveDateTime, 
                leave_request.endLeaveDateTime 
            FROM leave_request
            JOIN employee ON leave_request.employeeId = employee.employeeId
            WHERE startLeaveDateTime >= '$nowDT1' AND endLeaveDateTime <= '$nowDT2'
            OR startLeaveDateTime <= '$nowDT1' AND endLeaveDateTime >= '$nowDT1'
            OR startLeaveDateTime <= '$nowDT2' AND endLeaveDateTime >= '$nowDT2'
            OR startLeaveDateTime <= '$nowDT1' AND endLeaveDateTime >= '$nowDT2'
            ;
    ";
    $rs = $conn->query($sql);
    if(!$rs) console("Fail to get Leave Data");
    elseif($rs->num_rows >= 0) {
        echo "<tr>";
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            for ($j=0; $j < count($data); $j++) { 
                echo_td($data[$j]);
            }
        }
        if($rs->num_rows == 0) echo "<td colspan='3' class='text-center'>No Result...</td>";
        echo "</tr>";
    } else console("Fail to get Leave Data");

?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php

function show_request($head, $link, $icon, $bgColour, $sql){
    global $conn;
?>
<div class="col-4 mb-4">
    <div class="card bg-<?= $bgColour ?> text-white h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="me-3">
                    <div class="text-white-75 small"><?= $head ?></div>
                    <?php
                    $rs = $conn->query($sql);
                    if(!$rs) echo "00";
                    elseif($rs->num_rows > 0){
                        $data = $rs->fetch_array(MYSQLI_NUM);
                        echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                    } else echo '0';
                    ?>
                </div>
                <?= $icon ?>
            </div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between small">
            <a class="text-white stretched-link" href="<?= $link ?>">Manage Request</a>
            <i class="fas fa-angle-right"></i>
        </div>
    </div>
</div>
<?php
}
?>