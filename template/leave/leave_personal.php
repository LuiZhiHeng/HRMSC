<div class="col-12 mb-2">
    <form action="leave.php" method="GET">
        <button type="submit" class="btn btn-dark" name="history">View History</button>
        <button type="submit" class="btn btn-danger" name="apply">Apply Leave</button>
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
    $uId = get_logged_user_id();
    $sql = "SELECT leave_request.leaveId,
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
            WHERE leave_request.leaveStatus = 3 AND employee.employeeId = '$uId'";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            for ($j=1; $j < count($data); $j++) {
                if($j == 5){
                    $tempFileName = isset($data[$j]) ? "view" : "";
                    echo '<td><a type="submit" class="" data-bs-toggle="modal" data-bs-target="#fileModalFile" data-bs-file="'. filterOutput($data[$j]) .'">' . $tempFileName . '</a></td>';
                } else echo_td($data[$j]);
            }
?>
                    <td class="btn-group">
                        <form style="display: inline-block" action="leave.php" method="POST" onsubmit="return confirms('delete the request')">
                            <input type="hidden" name="lId" value="<?= $data[0] ?>" hidden>
                            <input type="hidden" name="file" value="<?= $data[5] ?>" hidden>
                            <button type="submit" name="delete" class="btn btn-secondary text-light">
                                <i class="fas fa-trash"></i>
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
                <form id="modalForm" action="leave.php" method="GET">
                    <input type="hidden" name="emName" id="emName" value="<?= $uId ?>" hidden>
                    <label for="year">Year:</label>
                    <input type="number" min="1900" max="3000" class="form-control mb-2" id="year" name="year" onkeyup="getLeaveLeft(this.value)" required>
                </form>
                <table id="leaveTable" class="table table-bordered">
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Leave Left Modal End -->

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