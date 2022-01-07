<div class="row form-inline mb-2">
    <form action="claim.php" method="GET">
        <button type="submit" class="btn btn-dark" name="view">View Request</button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Claim List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Claim Type</th>
                    <th>Detail</th>
                    <th>Amount (RM)</th>
                    <th>File</th>
                    <th>Apply On</th>
                    <th>Approve On</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    $uId = get_logged_user_id();
    $sql = "SELECT 
                claim_request.claimId,
                employee.employeeName,
                claim_type.claimName,
                claim_request.claimDetail,
                claim_request.claimAmount,
                claim_request.claimFileName,
                claim_request.applyClaimDateTime,
                claim_request.approveClaimDateTime,
                claim_request.comment,
                status_type.statusName,
                status_type.statusTypeId
            FROM claim_request 
            JOIN claim_type ON claim_type.claimTypeId = claim_request.claimTypeId
            JOIN status_type ON status_type.statusTypeId = claim_request.claimStatus
            JOIN employee ON employee.employeeId = claim_request.employeeId
            WHERE claim_request.claimStatus = 2 OR claim_request.claimStatus = 5 OR claim_request.claimStatus = 6 AND claim_request.employeeId = $uId";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $claim = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i + 1);
            for ($j=1; $j < count($claim)-1; $j++) { 
                if($j == 5) echo '<td><a type="submit"  class="" data-bs-toggle="modal" data-bs-target="#fileModalFile" data-bs-file="'. $claim[$j] .'">view</a></td>';
                else echo_td($claim[$j]);
            }
                
            ?>
                <td class="btn-group">
                    <form class="me-1" style="display: inline-block" action="claim.php" method="POST">
                        <button type="button" name="Comment" class="btn btn-primary mb-1 form-control" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= $claim[0] ?>" data-bs-comment="<?= $claim[7] ?>">
                            <i class="fas fa-comment"></i>
                        </button>
                    </form>
                </td>
            <?php 
            echo "</tr>";
        }
    }
?>
            </tbody>
        </table>

        <!-- Comment Modal -->
        <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="title" class="modal-title">Manage Comment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="modalForm" action="claim.php" method="POST" onsubmit="return confirms('Comment')">
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

            // file
            var fileModal = document.getElementById('fileModalFile')
            fileModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget
                var recipient = button.getAttribute('data-bs-file')
                var modalTitle = fileModal.querySelector('.modal-title')
                var modalBodyInput = fileModal.querySelector('.modal-body img')
                modalTitle.textContent = 'File: ' + recipient;
                modalBodyInput.src = "upload/claim/" + recipient;
            })
        </script>
    </div>
</div>