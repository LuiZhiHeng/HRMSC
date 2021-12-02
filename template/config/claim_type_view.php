<div class="row mb-2 form-inline">
    <form>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="" data-bs-data="">
            <i class="fas fa-plus-circle"></i> Add
        </button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Claim Type List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Claim Type Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    $rs = $conn->query("SELECT * FROM claim_type");
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i+1);
            for ($j=1; $j < count($data); $j++) { 
                echo "<td>" . $data[$j] . "</td>";
            }
?>
                <td>
                    <form style="display: inline-block" action="setting.php?claim_type" method="POST">
                        <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= $data[0] ?>" data-bs-data="<?= $data[1] ?>">
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
                <h5 id="title" class="modal-title">Adding New Claim Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="setting.php?claim_type=" method="POST" onsubmit="return confirms('Add Claim Type')">
                    <label for="claimTypeName">Claim Type Name:</label>
                    <input type="hidden" id="id" name="id" hidden>
                    <input type="hidden" id="data0" class="form-control mb-2" name="claimTypeNameOld" hidden>
                    <input type="text" id="data" class="form-control mb-2" name="claimTypeName" required autofocus>
                    <input type="submit" id="bttn" class="btn btn-danger form-control" name="add" value="Add Claim Type">
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
        var data = button.getAttribute('data-bs-data');
        var modalBodyInputId = exampleModal.querySelector('.modal-body form #id');
        var modalBodyInputData0 = exampleModal.querySelector('.modal-body form #data0');
        var modalBodyInputData = exampleModal.querySelector('.modal-body form #data');

        if(id != "" && data != ""){
            title.innerText = "Editing Claim Type"
            modalBodyInputId.value = id;
            modalBodyInputData0.value = data;
            modalBodyInputData.value = data;
            bttn.name = "edit";
            bttn.value = "Edit Claim Type";
            document.getElementById("modalForm").onsubmit = function() {return confirms("Edit Claim Type")};
        } else {
            modalBodyInputId.value = "";
            modalBodyInputData0.value = "";
            modalBodyInputData.value = "";
            bttn.name = "add";
            bttn.value = "Add Claim Type";
            document.getElementById("modalForm").onsubmit = function() {return confirms("Add Claim Type")};
        }
    });
</script>