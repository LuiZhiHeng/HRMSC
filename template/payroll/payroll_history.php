<div class="btn-group mb-2">
    <form action="payroll.php" method="GET">
        <button type="button" class="btn btn-dark me-1" data-bs-toggle="modal" data-bs-target="#viewModal">
            Check Monthly Payroll
        </button>
    </form>
    <form>
        <button type="button" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#fileModal">
            Generate Payroll
        </button>
    </form>
</div>
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
            ORDER BY payroll.year DESC, payroll.month DESC
            ";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i+1);
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

<!-- Modal Start -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title" class="modal-title">Generate Payroll</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="payroll.php" method="POST" onsubmit="return confirms('Generate Payroll')">
                    <label for="month">Month:</label>
                    <input type="number" class="form-control mb-2" min="1" max="12" id="month" name="month" required>
                    <label for="year">Year:</label>
                    <input type="number" min="1900" max="3000" class="form-control mb-2" id="year" name="year" required>
                    <input type="submit" id="bttn" class="btn btn-danger form-control" name="generate" value="Generate Payroll">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title" class="modal-title">View Monthly Payroll</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="payroll.php" method="GET">
                    <label for="month">Month:</label>
                    <input type="number" class="form-control mb-2" min="1" max="12" id="month" name="month" required>
                    <label for="year">Year:</label>
                    <input type="number" min="1900" max="3000" class="form-control mb-2" id="year" name="year" required>
                    <button type="submit" id="bttn" class="btn btn-danger form-control" name="view">
                        View Payroll
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->
