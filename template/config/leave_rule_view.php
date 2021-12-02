<div class="row mb-2 form-inline">
    <form>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-c="<?= $leaveTypeId; ?>" data-bs-id="" data-bs-data="" data-bs-valid="">
            <i class="fas fa-plus-circle"></i> Add
        </button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Leave Rule List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Leave Type Name</th>
                    <th>min Worked Year</th>
                    <th>Total Leave Day Offered</th>
                    <th>Active From</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    $leaveTypeId = $_GET['id'];
    $leaveTypeName = $_GET['name'];
    $rs = $conn->query("SELECT * FROM leave_item WHERE leaveTypeId = '$leaveTypeId'");
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i+1);
            for ($j=1; $j < count($data); $j++) { 
                if($data[$j] == 1 && $j == 1) echo "<td>" . $leaveTypeName . "</td>";
                else echo "<td>" . $data[$j] . "</td>";
            }
?>
                <td>
                    <form style="display: inline-block" action="setting.php?leave_rule=" method="POST">
                        <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-c="<?= $data[0] ?>" data-bs-id="<?= $data[2]; ?>" data-bs-data="<?= $data[3] ?>" data-bs-valid="<?= $data[4] ?>">
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
                <h5 id="title" class="modal-title">Adding New Leave Rule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="setting.php?id=<?= $leaveTypeId ?>&name=<?= $leaveTypeName ?>&leave_rule=" method="POST" onsubmit="return confirms('Add Leave Rule')">
                    <input type="hidden" id="id" name="id" value="<?= $leaveTypeId; ?>" hidden>
                    <label for="minWorkYear">Min Worked Year:</label>
                    <input type="number" min="0" id="minWorkYear" class="form-control mb-2" name="minWorkYear" required>
                    <label for="leaveDay">Total Day of Leave Offered:</label>
                    <input type="number" min="0" id="leaveDay" class="form-control mb-2" name="leaveDay" required>
                    <label for="valid">Valid From:</label>
                    <input type="date" id="valid" class="form-control mb-2" name="valid" required>
                    <input type="submit" id="bttn" class="btn btn-danger form-control" name="add" value="Add Leave Rule">
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
        var c = button.getAttribute('data-bs-c');
        var id = button.getAttribute('data-bs-id');
        var data = button.getAttribute('data-bs-data');
        var valid = button.getAttribute('data-bs-valid');
        var inputC = exampleModal.querySelector('.modal-body form #id');
        var inputWorkYear = exampleModal.querySelector('.modal-body form #minWorkYear');
        var inputDay = exampleModal.querySelector('.modal-body form #leaveDay');
        var inputValid = exampleModal.querySelector('.modal-body form #valid');

        if(id != "" && data != "" && valid != ""){
            title.innerText = "Editing Leave Rule";
            inputC.value = c;
            inputWorkYear.value = id;
            inputDay.value = data;
            inputValid.value = valid;
            bttn.name = "edit";
            bttn.value = "Edit Leave Rule";
            document.getElementById("modalForm").onsubmit = function() {return confirms("Edit Leave Rule")};
        } else {
            inputC.value = c;
            inputWorkYear.value = "";
            inputDay.value = "";
            inputValid.value = "";
            bttn.name = "add";
            bttn.value = "Add Leave Rule";
            document.getElementById("modalForm").onsubmit = function() {return confirms("Add Leave Rule")};
        }
    });
</script>