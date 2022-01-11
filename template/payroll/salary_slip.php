<?php
$pId = filterInput($_POST['pId']);
$uId = filterInput($_POST['uId']);
$sql = "SELECT 
            payroll.payrollId,
            payroll.employeeId,
            payroll.month,
            payroll.year,
            employee.employeeName,
            payroll.cheque,
            payroll.basicPay,
            payroll.deduction,
            payroll.netPay,
            employee.recruitmentId
        FROM payroll
        JOIN employee ON employee.employeeId = payroll.employeeId
        WHERE payroll.payrollId='$pId'";
$rs = $conn->query($sql);
if($rs->num_rows > 0){
    $data = $rs->fetch_assoc();
    $monthSelected = $data['month'];
    $yearSelected = $data['year'];
    set_h1("Salary Slip  - " . $data['employeeName'] . " (" . $monthSelected . "/" . $yearSelected . ")");
    breadcrumb(array("Payroll" => "payroll.php"), "Salary Slip");
    $arrPayroll = create_payroll($monthSelected, $yearSelected, $uId);
    $countArr = 0;
?>
<div class="mb-2 text-end d-print-none">
    <button class="btn btn-primary" type="button" onclick="window.print()">
        <i class="fas fa-download"></i>
        Download Salary Slip
    </button>
</div>
<div id="payroll" class="card mb-4 border-dark border-2">                            
    <div class="card-header bg-warning pt-3">
        <div class="row text-center">
            <h2>SALARY SLIP</h2>
        </div>
    </div>
    <div class="card-header">
        <div class="row">
            <div class="col-3 text-end">
                <b>PAY TO : </b>
                <br>
                <b>CHEQUE NO : </b>
            </div>
            <div class="col-3">
                <?= $data['employeeName'] ?>
                <br>
                <?= $data['cheque'] ?>
            </div>
            <div class="col-3 text-end">
                <b>YEAR : </b>
                <br>
                <b>MONTH :</b>
            </div>
            <div class="col-3">
                <?= $yearSelected ?>
                <br>
                <?= $monthSelected ?>
            </div>
        </div>
    </div>

    <div class="card-body row">
        <div class="col-6 border-dark border-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="table-dark text-uppercase" colspan="2">Earnings</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Basic Pay</th>
                        <td class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></td>
                    </tr>
                    <tr>
                        <th>Overtime (<?= $arrPayroll[$countArr++] . "h"; ?>)</th>
                        <td class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></td>
                    </tr>
                    <tr>
                        <th>Allowance</th>
                        <td class="text-end"><?php $countArr++; ?></td>
                    </tr>
                    <?php
                        $reId = $data['recruitmentId'];
                        $sqlAllow = "SELECT 
                                    allowance_type.allowanceName,
                                    allowance.allowanceAmount
                                FROM allowance
                                JOIN allowance_type ON allowance_type.allowanceTypeId = allowance.allowanceTypeId
                                WHERE allowance.recruitmentId = '$reId'
                        ";
                        $rsAllow = $conn->query($sqlAllow);
                        for ($i=0; $i < $rsAllow->num_rows; $i++) { 
                            $allow = $rsAllow->fetch_array(MYSQLI_NUM);
                            echo '<tr>';
                                echo '<td class="ps-3"><b>-</b> ' . $allow[0] . '</td>';
                                echo '<td class="text-end">' . $allow[1] . '</td>';
                            echo '</tr>';
                        }
                    ?>
                    <tr class="table-secondary">
                        <th class="text-end text-uppercase">Gross Pay :</th>
                        <th class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></th>
                    </tr>
                    <tr><td colspan="2"></td></tr>
                </tbody>

                <thead>
                    <tr>
                        <th class="table-dark text-uppercase" colspan="2">Deductions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>EPF - Employee (<?= $arrPayroll[$countArr++]; ?>%)</th>
                        <td class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></td>
                    </tr>
                    <tr>
                        <th>SOCSO</th>
                        <td class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></td>
                    </tr>
                    <tr>
                        <th>EIS</th>
                        <td class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></td>
                    </tr>
                    <tr>
                        <th>Absent (<?= $arrPayroll[$countArr++] . " Day"; ?>)</th>
                        <td class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++] ); ?></td>
                    </tr>
                    <tr class="table-secondary">
                        <th class="text-end text-uppercase w-75">Total Deductions :</th>
                        <th class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></th>
                    </tr>
                    <tr><td colspan="2"></td></tr>
                </tbody>
                <!-- 
                <thead>
                    <tr>
                        <th class="table-dark text-uppercase" colspan="2">Additions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Reimbursement</th>
                        <td class="text-end"><?= 0 ?></td>
                    </tr>
                    <tr class="table-secondary">
                        <th class="text-end text-uppercase w-75">Total Additions</th>
                        <th class="text-end"><?= 0 ?></th>
                    </tr>
                    <tr><td colspan="2"></td></tr>
                </tbody>
                -->

                <tfoot>
                    <tr class="table-dark">
                        <th class="text-uppercase" colspan="2">Net Pay</th>
                    </tr>
                    <tr class="text-end">
                        <th class="table-secondary">Total (RM)</th>
                        <th><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></th>
                    </tr>
                </tfoot>
            </div>
        </table>
        <p><?= date("Y-m-d h:i:s A"); ?></p>
    </div>
    <div class="col-6">
        <table class="table table-bordered">
            <tr>
                <th class="table-dark text-uppercase" colspan="4">Overtime Detail</th>
            </tr>
            <tr class="text-center table-secondary text-uppercase">
                <th>Day</th>
                <th>Hours</th>
                <th>Rates</th>
                <th>Amount</th>
            </tr>
            <?php
                $otTotalHour = $otTotalAmount = 0;
                for ($iot=0; $iot < 3; $iot++) { 
                    echo '<tr class="text-end">';
                    if($iot == 0) echo '<th>Normal</th>';
                    elseif($iot == 1) echo '<th>Rest</th>';
                    elseif($iot == 2) echo '<th>Holiday</th>';
                    echo '<td>' . $arrPayroll[$countArr++] . '</td>';
                    echo '<td>' . sprintf('%0.1f', $arrPayroll[$countArr++]) . '</td>';
                    echo '<td>' . sprintf('%0.2f', $arrPayroll[$countArr++]) . '</td>';
                    echo '</tr>';
                }
            ?>
            <tr class="table-secondary text-end">
                <th>TOTAL</th>
                <th><?= $arrPayroll[$countArr++]; ?></th>
                <th>-</th>
                <th><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></th>
            </tr>
        </table>
    
        <table class="table table-bordered">
            <tr>
                <th colspan="2" class="table-dark text-uppercase">Contribution (Employer)</th>
            </tr>
            <tr>
                <th>EPF (<?= $arrPayroll[$countArr++]; ?>%)</th>
                <td class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></td>
            </tr>
            <tr>
                <th>SOCSO</th>
                <td class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></td>
            </tr>
            <tr>
                <th>EIS</th>
                <td class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></td>
            </tr>
            <tr class="table-secondary">
                <th class="text-end text-uppercase w-75">Total Contribution</th>
                <th class="text-end"><?= sprintf('%0.2f', $arrPayroll[$countArr++]); ?></th>
            </tr>
        </table>

        <!-- PIC -->
        <table class="table table-stripped">
            <tr>
                <th colspan="2" class="table-dark w-50 text-uppercase">Signature</th>
            </tr>
            <tr>
                <th class="table-secondary w-50 text-end ">Prepared By : <br><span class="text-light">.</span></th>
                <td></td>
            </tr>
            <tr>
                <th class="table-secondary w-50 text-end">Approved By : <br><span class="text-light">.</span></th>
                <td></td>
            </tr>
            <tr>
                <th class="table-secondary w-50 text-end">Employee's <br>Signature :</th>
                <td></td>
            </tr>
        </table>
    </div>
</div>
<?php
}

?>