<div class="row mb-2 form-inline">
    <form>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= $payrollTypeId; ?>" data-bs-salary="" data-bs-age="" data-bs-percentemployee="" data-bs-percentemployer="" data-bs-valid="">
            <i class="fas fa-plus-circle"></i> Add
        </button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Payroll Rule List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Min Salary</th>
                    <th>Min Age</th>
                <?php
                    $payrollTypeId = $_GET['id'];
                    $payrollTypeName = $_GET['name'];
                    if($payrollTypeId == 3) {
                ?>
                    <th>Employee Contribution (RM)</th>
                    <th>Employer Contribution (RM)</th>
                <?php } else { ?>
                    <th>Employee Percent (%)</th>
                    <th>Employer Percent (%)</th>
                <?php } ?>
                    <th>Active From</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    $rs = $conn->query("SELECT * FROM payroll_item WHERE payrollItemTypeId = '$payrollTypeId' ORDER BY payrollItemStartFrom DESC, minSalary DESC, minAge DESC");
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i+1);
            for ($j=2; $j < count($data); $j++) { 
                if($j == 4 || $j == 5){
                    if($payrollTypeId == 3) echo "<td>" . round($data[$j], 2) . "</td>";
                    else echo "<td>" . ($data[$j] * 100) . "</td>";
                }
                else echo "<td>" . $data[$j] . "</td>";
            }
?>
                <td>
                    <form style="display: inline-block" action="setting.php?payroll_rule=" method="POST">
                        <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= $data[0]; ?>" data-bs-salary="<?= $data[2]; ?>" data-bs-age="<?= $data[3]; ?>" data-bs-percentemployee="<?= $data[4]; ?>" data-bs-percentemployer="<?= $data[5]; ?>" data-bs-valid="<?= $data[6]; ?>">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </form>
                </td>
            </tr>
<?php
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
                <h5 id="title" class="modal-title">Adding New Payroll Rule (<?= $payrollTypeName ?>)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="setting.php?id=<?= $payrollTypeId ?>&name=<?= $payrollTypeName ?>&payroll_rule=" method="POST" onsubmit="return confirms('Add Payroll Rule')">
                    <input type="hidden" id="id" name="id" value="<?= $payrollTypeId ?>" hidden>
                    <label for="minSalary">Min Salary (RM):</label>
                    <input type="number" min="0" id="minSalary" class="form-control mb-2" name="minSalary" required>
                    <label for="minAge">Min Age:</label>
                    <input type="number" min="0" id="minAge" class="form-control mb-2" name="minAge" required>
                    <label id="label1" for="percentEmployee">Percentage Employee (%):</label>
                    <input type="number" min="0" step="0.01" id="percentEmployee" class="form-control mb-2" name="percentEmployee" required>
                    <label id="label2" for="percentEmployer">Percentage Employer (%):</label>
                    <input type="number" min="0" step="0.01" id="percentEmployer" class="form-control mb-2" name="percentEmployer" required>
                    <label for="valid">Valid From:</label>
                    <input type="date" id="valid" class="form-control mb-2" name="valid" required>
                    <input type="submit" id="bttn" class="btn btn-danger form-control" name="add" value="Add Payroll Rule">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->

<script>
    var exampleModal = document.getElementById('fileModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-bs-id');
        var salary = button.getAttribute('data-bs-salary');
        var age = button.getAttribute('data-bs-age');
        var percentEmployee = button.getAttribute('data-bs-percentemployee');
        var percentEmployer = button.getAttribute('data-bs-percentemployer');
        var valid = button.getAttribute('data-bs-valid');
        var inputId = exampleModal.querySelector('.modal-body form #id');
        var inputSalary = exampleModal.querySelector('.modal-body form #minSalary');
        var inputAge = exampleModal.querySelector('.modal-body form #minAge');
        var inputPercentEmployee = exampleModal.querySelector('.modal-body form #percentEmployee');
        var inputPercentEmployer = exampleModal.querySelector('.modal-body form #percentEmployer');
        var inputValid = exampleModal.querySelector('.modal-body form #valid');
        var label1 = exampleModal.querySelector('.modal-body form #label1');
        var label2 = exampleModal.querySelector('.modal-body form #label2');
        
        if(salary != "" && age != "" && percentEmployee != "" && percentEmployer != "" && valid != ""){
            title.innerText = "Editing Payroll Rule (<?= $payrollTypeName ?>)";
            inputId.value = id;
            inputSalary.value = salary;
            inputAge.value = age;
            if(<?= $payrollTypeId ?> == 3) {
                label1.innerText = "Employee Contribution (RM)";
                label2.innerText = "Employer Contribution (RM)";
                inputPercentEmployee.value = percentEmployee;
                inputPercentEmployer.value = percentEmployee;
            } else {
                inputPercentEmployee.value = percentEmployee * 100;
                inputPercentEmployer.value = percentEmployer * 100;
            }
            inputValid.value = valid;
            bttn.name = "edit";
            bttn.value = "Edit Payroll Rule";
            document.getElementById("modalForm").onsubmit = function() {return confirms("Edit Payroll Rule")};
        } else {
            title.innerText = "Adding Payroll Rule (<?= $payrollTypeName ?>)";
            inputId.value = <?= $payrollTypeId ?>;
            inputSalary.value = "";
            inputAge.value = "";
            if(id == 3) {
                label1.innerText = "Employee Contribution (RM)";
                label2.innerText = "Employer Contribution (RM)";
            }
            inputPercentEmployee.value = "";
            inputPercentEmployer.value = "";
            inputValid.value = "";
            bttn.name = "add";
            bttn.value = "Add Payroll Rule";
            document.getElementById("modalForm").onsubmit = function() {return confirms("Add Payroll Rule")};
        }
    });
</script>