<div class="col-12 mb-2">
    <form action="leave.php" method="GET">
        <button type="submit" class="btn btn-dark" name="history">View History</button>
        <button type="submit" class="btn btn-danger" name="assign">Assign Leave</button>
        <button type="button" class="btn btn-dark float-end" data-bs-toggle="modal" data-bs-target="#leaveLeftModal">Check Leave Left</button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
            Leave Request List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Reason</th>
                    <th>Leave From</th>
                    <th>Leave Until</th>
                    <th>File</th>
                    <th>Apply Time</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    $sql = "SELECT leave_request.leaveId,
                employee.employeeId,
                employee.employeeName,
                leave_type.leaveName,
                leave_request.leaveDetail,
                leave_request.startLeaveDateTime,
                leave_request.endLeaveDateTime,
                leave_request.leaveFileName,
                leave_request.applyLeaveDateTime,
                leave_request.comment
            FROM leave_request
            JOIN leave_type ON leave_request.leaveTypeId = leave_type.leaveTypeId 
            JOIN employee ON leave_request.employeeId = employee.employeeId 
            WHERE leave_request.leaveStatus = 3";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo_tag("tr", 0);
            echo_td($i + 1);
            for ($j=0; $j < count($data); $j++) {
                if($j == 7){
                    $tempFileName = isset($data[$j]) ? "view" : "";
                    echo '<td><a type="submit" class="" data-bs-toggle="modal" data-bs-target="#fileModalFile" data-bs-file="'. filterOutput($data[$j]) .'">' . $tempFileName . '</a></td>';
                } elseif($j > 1) echo_td($data[$j]);
            }
?>
                    <td class="btn-group">
                        <form class="me-1" style="display: inline-block" action="leave.php" method="POST" onsubmit="return confirms('approve the request')">
                            <input type="hidden" name="lId" value=<?= echo_txt($data[0]) ?> hidden required>
                            <button type="submit" name="approve" class="btn btn-success text-light">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </form>
                        <form class="me-1" style="display: inline-block" action="leave.php" method="POST">
                            <button type="button" value="Comment" class="btn btn-primary mb-1 form-control" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= $data[0] ?>" data-bs-comment="<?= $data[9] ?>">
                                <i class="fas fa-comment"></i>
                            </button>
                        </form>
                        <form class="me-1" style="display: inline-block" action="leave.php" method="POST" onsubmit="return confirms('reject the request')">
                            <input type="hidden" name="lId" value=<?= echo_txt($data[0]) ?> hidden required>
                            <button type="submit" name="reject" class="btn btn-danger text-light">
                                <i class="fas fa-times-circle"></i>
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



<!-- Comment Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title" class="modal-title">Manage Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="leave.php" method="POST" onsubmit="return confirms('Comment')">
                    <label for="commentName">Comment:</label>
                    <input type="hidden" id="id" name="id" hidden>
                    <input type="text" id="data" class="form-control mb-2" name="commentName">
                    <input type="submit" id="bttn" class="btn btn-danger form-control" name="comment" value="Save Comment">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Comment Modal End -->

<!-- File Modal -->
<div class="modal fade" id="fileModalFile" tabindex="-1" aria-labelledby="fileModalFile" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <img alt="File Image" class="img-thumbnail">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
<!-- File Modal End -->

<!-- Leave Left Modal Start -->
<div class="modal fade" id="leaveLeftModal" tabindex="-1" aria-labelledby="leaveLeftModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title" class="modal-title">View Remaining Leave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="emName">Employee:</label>
                <select class="form-control form-select" name="emName" id="emName" onchange="getLeaveLeft(document.getElementById('year').value)">
                <?php
                    $yearNow = get_year_now();
                    $sql = "SELECT employeeId, employeeName FROM employee WHERE startWorkDate >= $yearNow AND endWorkDate = '0000-00-00'";
                    $rs = $conn->query($sql);
                    if ($rs->num_rows > 0){
                        for ($i=0; $i < $rs->num_rows; $i++){ 
                            $emData = $rs->fetch_array(MYSQLI_NUM);
                            echo '<option value="' . filterOutput($emData[0]) . '">' . filterOutput($emData[1]) . '</option>';
                        }
                    }
                ?>
                </select>
                <label for="year">Year:</label>
                <input type="number" min="1900" max="3000" class="form-control mb-2" id="year" name="year" onkeyup="getLeaveLeft(this.value)" required>
                <table id="leaveTable" class="table table-bordered">
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Leave Left Modal End -->

<script>
    //comment
    var exampleModal = document.getElementById('fileModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-bs-id');
        var data = button.getAttribute('data-bs-comment');
        var modalBodyInputId = exampleModal.querySelector('.modal-body form #id');
        var modalBodyInputData = exampleModal.querySelector('.modal-body form #data');

        modalBodyInputId.value = id;
        modalBodyInputData.value = data;
    });

    //file
    var modalFile = document.getElementById('fileModalFile')
    modalFile.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var recipient = button.getAttribute('data-bs-file')
        var modalTitle = modalFile.querySelector('.modal-title')
        var modalBodyInput = modalFile.querySelector('.modal-body img')

        modalTitle.textContent = 'File: ' + recipient;
        modalBodyInput.src = "upload/leave/" + recipient;
    })

    function getLeaveLeft(year) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("leaveTable").innerHTML = this.responseText;
            }
        };
        var id = document.getElementById("emName").value;
        
        xmlhttp.open("GET", "function/leave/getLeaveLeftRecord.php?n=" + id + "&y=" + year, true);
        xmlhttp.send();
    }
</script>