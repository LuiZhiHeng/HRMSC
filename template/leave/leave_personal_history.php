<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
            Leave History List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Leave Type</th>
                    <th>Reason</th>
                    <th>Leave From</th>
                    <th>Leave Until</th>
                    <th>File</th>
                    <th>Apply Time</th>
                    <th>Approve Time</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    $uId = get_logged_user_id();
    $sql = "SELECT leave_request.leaveId,
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
            JOIN status_type ON status_type.statusTypeId = leave_request.leaveStatus
            JOIN employee ON employee.employeeId = leave_request.employeeId
            WHERE (leave_request.leaveStatus = 1 OR leave_request.leaveStatus = 2 )AND employee.employeeId = '$uId'";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            for ($j=1; $j < count($data); $j++) {
                if($j == 5) echo '<td><a type="submit"  class="" data-bs-toggle="modal" data-bs-target="#fileModalFile" data-bs-file="'. $data[$j] .'">' . $data[$j] . '</a></td>';
                else echo_td($data[$j]);
            }
            echo "</tr>";
        }
    }
?>
            </tbody>
        </table>
        <div class="col-12 text-end">
            <form action="leave.php" method="GET">
                <button type="submit" class="btn btn-danger" name="apply">Apply Leave</button>
            </form>
        </div>
    </div>
</div>

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