<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
            Leave History List
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
                    <th>Approve Time</th>
                    <th>Comment</th>
                    <th>Status</th>
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
                leave_request.approveLeaveDateTime,
                leave_request.comment,
                status_type.statusName
            FROM leave_request
            JOIN leave_type ON leave_request.leaveTypeId = leave_type.leaveTypeId 
            JOIN employee ON leave_request.employeeId = employee.employeeId 
            JOIN status_type ON status_type.statusTypeId = leave_request.leaveStatus
            WHERE leave_request.leaveStatus = 1 OR leave_request.leaveStatus = 2";
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
                    <td>
                        <input type="button" value="Comment" class="btn btn-primary mb-1 form-control" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= filterOutput($data[0]) ?>" data-bs-comment="<?= filterOutput($data[10]) ?>">
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
</script>