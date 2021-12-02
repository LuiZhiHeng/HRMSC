<div class="row mb-2 form-inline">
    <form>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="" data-bs-hour="" data-bs-rate="" data-bs-valid="">
            <i class="fas fa-plus-circle"></i> Add
        </button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Overtime Rule List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Min Working Hour</th>
                    <th>Payrate</th>
                    <th>Active From</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    $dayTypeId = $_GET['id'];
    $dayTypeName = $_GET['name'];
    $rs = $conn->query("SELECT * FROM overtime_payrate WHERE dayTypeId = '$dayTypeId' ORDER BY overtimePayrateStartFrom DESC, minWorkedHour DESC");
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i+1);
            for ($j=2; $j < count($data); $j++) { 
                echo "<td>" . $data[$j] . "</td>";
            }
?>
                <td>
                    <form style="display: inline-block" action="setting.php?overtime_rule=" method="POST">
                        <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= $data[0]; ?>" data-bs-hour="<?= $data[2]; ?>" data-bs-rate="<?= $data[3]; ?>" data-bs-valid="<?= $data[4]; ?>">
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
                <h5 id="title" class="modal-title">Adding New Overtime Rule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="setting.php?id=<?= $dayTypeId ?>&name=<?= $dayTypeName ?>&overtime_rule=" method="POST" onsubmit="return confirms('Add Overtime Rule')">
                    <input type="hidden" id="id" name="id" value="<?= $dayTypeId ?>" hidden>
                    <label for="minWorkHour">Min Worked Hour:</label>
                    <input type="number" min="0" id="minWorkHour" class="form-control mb-2" name="minWorkHour" required>
                    <label for="payrate">Payrate:</label>
                    <input type="number" step="0.01" min="0" id="payrate" class="form-control mb-2" name="payrate" required>
                    <label for="valid">Valid From:</label>
                    <input type="date" id="valid" class="form-control mb-2" name="valid" required>
                    <input type="submit" id="bttn" class="btn btn-danger form-control" name="add" value="Add Overtime Rule">
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
        var hour = button.getAttribute('data-bs-hour');
        var rate = button.getAttribute('data-bs-rate');
        var valid = button.getAttribute('data-bs-valid');
        var inputId = exampleModal.querySelector('.modal-body form #id');
        var inputWorkHour = exampleModal.querySelector('.modal-body form #minWorkHour');
        var inputRate = exampleModal.querySelector('.modal-body form #payrate');
        var inputValid = exampleModal.querySelector('.modal-body form #valid');
        
        if(id != "" && hour != "" && rate != "" && valid != ""){
            title.innerText = "Editing Overtime Rule";
            inputId.value = id;
            inputWorkHour.value = hour;
            inputRate.value = rate;
            inputValid.value = valid;
            bttn.name = "edit";
            bttn.value = "Edit Overtime Rule";
            document.getElementById("modalForm").onsubmit = function() {return confirms("Edit Overtime Rule")};
        } else {
            title.innerText = "Adding Overtime Rule";
            inputId.value = <?= $dayTypeId ?>;
            inputWorkHour.value = "";
            inputRate.value = "";
            inputValid.value = "";
            bttn.name = "add";
            bttn.value = "Add Overtime Rule";
            document.getElementById("modalForm").onsubmit = function() {return confirms("Add Overtime Rule")};
        }
    });
</script>