<?php
if(isset($_GET['id'])){
    $id = filterInput($_GET['id']);
    $rsRe = $conn->query("SELECT position FROM recruitment WHERE recruitmentId = '$id'");
    $reName = $rsRe->fetch_array(MYSQLI_NUM);
    if($reName){
        set_h1("Edit Allowance <small>(" . $reName[0] . ")    </small>");
        breadcrumb(array("Recruitment" => "recruitment.php"), "Allowance");
?>
<div class="row mb-2 form-inline">
    <form>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus-circle"></i> Add
        </button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Allowance List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Allowance Name</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
        $sql = "SELECT allowance_type.allowanceName, allowance.* FROM allowance 
                JOIN allowance_type ON allowance_type.allowanceTypeId = allowance.allowanceTypeId
                WHERE allowance.recruitmentId = '$id'";
        $rs = $conn->query($sql);
        if($rs->num_rows > 0) {
            for ($i=0; $i < $rs->num_rows; $i++) { 
                $data = $rs->fetch_assoc();
                echo "<tr>";
                echo_td($data['allowanceName']);
                echo_td($data['allowanceAmount']);
?>
                <td>
                    <form style="display: inline-block" action="recruitment.php?id=<?= $id; ?>&editAllowance=" method="POST">
                        <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= $data['allowanceId'] ?>"  data-bs-name="<?= $data['allowanceName'] ?>" data-bs-data="<?= $data['allowanceAmount'] ?>">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </form>
                    <form style="display: inline-block" action="recruitment.php?id=<?= $id; ?>&editAllowance=" method="POST">
                        <input type="hidden" name="id" value="<?= $data['allowanceId'] ?>" hidden>
                        <button type="submit" class="btn btn-secondary text-light" name="delete">
                            <i class="fas fa-trash"></i> Delete
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
                <h5 id="title" class="modal-title">Editing Allowance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="recruitment.php?id=<?= $id; ?>&editAllowance=" method="POST" onsubmit="return confirms('Edit ALlowance')">
                    <label id="label" for="allowanceName">Allowance:</label>
                    <input type="hidden" id="id" name="id" hidden>
                    <input type="number" step="0.01" id="data" class="form-control mb-2" name="allowanceAmount" required autofocus>
                    <input type="submit" id="bttn" class="btn btn-danger form-control" name="edit" value="Edit Allowance">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title" class="modal-title">Adding Allowance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="recruitment.php?id=<?= $id; ?>&editAllowance=" method="POST" onsubmit="return confirms('Edit Allowance')">
                    <input type="hidden" id="id" name="id" value="<?= $id; ?>" hidden>
                    <select class="form-control form-select" name="allowance" id="allowance">
                    <?php
                        $rsA = $conn->query("SELECT * FROM allowance_type");
                        for ($i=0; $i < $rsA->num_rows; $i++) { 
                            $dataA = $rsA->fetch_assoc();
                            echo '<option value="' . $dataA['allowanceTypeId'] . '">' . $dataA['allowanceName'] . '</option>';
                        }

                    ?>
                    </select>
                    <label class="mt-2" for="allowanceAmount">Allowance:</label>
                    <input type="number" step="0.01" id="data" class="form-control mb-2" name="allowanceAmount" required autofocus>
                    <input type="submit" id="bttn" class="btn btn-danger form-control" name="add" value="Add Allowance">
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
        var name = button.getAttribute('data-bs-name');
        var modalBodyLabel = exampleModal.querySelector('.modal-body form #label');
        var modalBodyInputId = exampleModal.querySelector('.modal-body form #id');
        var modalBodyInputData = exampleModal.querySelector('.modal-body form #data');

        if(id != "" && data != ""){
            title.innerText = "Editing Allowance"
            modalBodyInputId.value = id;
            modalBodyInputData.value = data;
            modalBodyLabel.innerText = "Amount for " + name;
        }
    });
</script>
<?php 
    } 
}
?>
