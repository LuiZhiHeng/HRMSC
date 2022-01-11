<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Payroll List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Month/Year</th>
                    <th>Employee Name</th>
                    <th>Cheque No</th>
                    <th>Basic Pay (RM)</th>
                    <th>Deduction (RM)</th>
                    <th>Net Pay (RM)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    $uId = get_logged_user_id();
    $sql = "SELECT 
                payroll.payrollId,
                payroll.employeeId,
                payroll.month,
                payroll.year,
                employee.employeeName,
                payroll.cheque,
                payroll.basicPay,
                payroll.deduction,
                payroll.netPay
            FROM payroll
            JOIN employee ON employee.employeeId = payroll.employeeId
            WHERE payroll.employeeId = '$uId'
            ORDER BY payroll.year DESC, payroll.month DESC;
            ";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i + 1);
            for ($j=2; $j < count($data); $j++) {
                if($j == 2) echo "<td>" . $data[$j] . "/";
                elseif($j == 3) echo $data[$j] . "</td>";
                else echo_td($data[$j]);
            }
?>
            <td>
                <form action="payroll.php" method="POST">
                    <input type="hidden" name="pId" value="<?= $data[0] ?>" hidden>
                    <input type="hidden" name="uId" value="<?= $data[1] ?>" hidden>
                    <button class="btn btn-primary mb-1" type="submit" name="view">View </button>
                </form>                                
            </td>
<?php
            echo "</tr>";
        }
    }
?>
            </tbody>
        </table>
    </div>
</div>