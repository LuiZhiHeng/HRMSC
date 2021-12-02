<div class="row mb-2 form-inline">
    <form action="setting.php" action="GET">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="" data-bs-data="">
            <i class="fas fa-plus-circle"></i> Add
        </button>
        <button type="submit" class="btn btn-dark" name="holiday" value="history">
            <i class="fas fa-history"></i> History
        </button>
        <button type="button" class="btn btn-dark float-end" data-bs-toggle="modal" data-bs-target="#holidayModal">Check Yearly Holiday</button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Holiday List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Holiday Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    if(isset($_GET['year'])) $yearNow = $_GET['year'];
    else $yearNow = get_year_now();
    $yearNow = get_first_day($yearNow, 1);
    $yearNext = get_first_day((int)$yearNow + 1, 1);
    $rs = $conn->query("SELECT holidayId, holidayDate, holidayName FROM holiday WHERE holidayDate >= '$yearNow' AND holidayDate < '$yearNext' ORDER BY holidayDate DESC");
    if(!$rs) console("Failed to get holiday record");
    elseif($rs->num_rows >= 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i+1);
            for ($j=1; $j < count($data); $j++) { 
                echo "<td>" . $data[$j] . "</td>";
            }
?>
                <td>
                    <form style="display: inline-block" action="setting.php?holiday=" method="POST">
                        <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= $data[0] ?>" data-bs-data="<?= $data[1] ?>" data-bs-date="<?= $data[2] ?>">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </form>
                    <form style="display: inline-block" action="setting.php?holiday=" method="POST" onsubmit="return confirms('Delete Holiday')">
                        <input type="hidden" name="hid" value="<?= $data[0] ?>" hidden>
                        <button type="submit" name="delete" class="btn btn-secondary text-light">
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

<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title" class="modal-title">Adding New Holiday</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="setting.php?holiday=" method="POST" onsubmit="return confirms('Add Holiday')">
                    <label for="holidayName">Public Holiday:</label>
                    <input type="hidden" id="id" name="id" hidden>
                    <input type="date" id="date" class="form-control mb-2" name="holidayDate" required>
                    <input type="text" id="data" class="form-control mb-2" name="holidayName" required>
                    <input type="submit" id="bttn" class="btn btn-danger form-control" name="add" value="Add Holiday">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="holidayModal" tabindex="-1" aria-labelledby="holidayModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title" class="modal-title">View Holiday</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="setting.php" method="GET">
                    <label for="year">Year:</label>
                    <input type="number" class="form-control mb-2" id="year" name="year" required>
                    <input type="hidden" name="holiday" hidden>
                    <button type="submit" class="btn btn-danger form-control">
                        View History
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var exampleModal = document.getElementById('fileModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-bs-id');
        var data = button.getAttribute('data-bs-data');
        var date = button.getAttribute('data-bs-date');
        var inputId = exampleModal.querySelector('.modal-body form #id');
        var inputData = exampleModal.querySelector('.modal-body form #data');
        var inputDate = exampleModal.querySelector('.modal-body form #date');


        if(id != "" && data != ""){
            title.innerText = "Editing Holiday"
            inputId.value = id;
            inputData.value = data;
            inputDate.value = date;
            bttn.name = "edit";
            bttn.value = "Edit Holiday";
            document.getElementById("modalForm").onsubmit = function() {return confirms("Edit Holiday")};
        } else {
            inputId.value = "";
            inputDate.value = "";
            inputData.value = "";
            bttn.name = "add";
            bttn.value = "Add Holiday";
            document.getElementById("modalForm").onsubmit = function() {return confirms("Add Holiday")};
        }
    });
</script>