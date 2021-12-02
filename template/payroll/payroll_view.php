<div class="row form-inline mb-2">
    <form action="payroll.php" method="POST">
        <a href="payroll.php" class="btn btn-dark">Payroll History</a>
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
                    <th>Allowance (RM)</th>
                    <th>Net Pay (RM)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    $yearSelected = $_GET["year"];
    $monthSelected = $_GET["month"];
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
            JOIN employee ON employee.employeeId = payroll.employeeId WHERE year='$yearSelected' AND month='$monthSelected'";
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
                <form class="me-1" style="display: inline-block">
                    <input type="button" value="Manage Cheque" class="btn btn-success mb-1 form-control" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= $data[0] ?>" data-bs-cheque="<?= $data[5] ?>">
                </form>
                <form class="me-1" style="display: inline-block" action="payroll.php" method="POST" target="_blank">
                    <input type="hidden" name="pId" value="<?= $data[0] ?>" hidden>
                    <input type="hidden" name="uId" value="<?= $data[1] ?>" hidden>
                    <input class="btn btn-primary mb-1 form-control" type="submit" name="view" value="View">
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

<!-- Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="payroll.php?month=<?= $monthSelected; ?>&year=<?= $yearSelected; ?>&view=" method="POST">
                <input type="hidden" class="form-control id mb-1" id="id" name="id" hidden>
                <label for="che">Cheque ID :</label>
                <input type ="text" class="form-control mb-1" id="che" name="chequeNo">
                <input type="submit" class="btn btn-danger form-control" name="saveEdit" value="Save">
            </form>
        </div>
    </div>
</div>
<!-- Modal End -->
<script>
    var exampleModal = document.getElementById('fileModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-bs-id');
        var cheque = button.getAttribute('data-bs-cheque');
        var modalTitle = exampleModal.querySelector('.modal-title');
        var modalBodyInputId = exampleModal.querySelector('.modal-body form #id');
        var modalBodyInputCheque = exampleModal.querySelector('.modal-body form #che');

        modalTitle.textContent = "Edit Cheque";
        modalBodyInputId.value = id;
        modalBodyInputCheque.value = cheque;
    })
</script>