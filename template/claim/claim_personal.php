<div class="row form-inline mb-2">
    <form action="claim.php" method="GET">
        <button type="submit" class="btn btn-dark" name="history">View History</button>
        <button type="submit" class="btn btn-danger" name="apply">Apply Claim</button>
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
            WHERE (claim_request.claimStatus = 1 OR claim_request.claimStatus = 3 OR claim_request.claimStatus = 5) AND claim_request.employeeId = $uId";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $claim = $rs->fetch_array(MYSQLI_NUM);
            echo "<tr>";
            echo_td($i + 1);
            for ($j=1; $j < count($claim)-1; $j++) { 
                if($j == 4) echo '<td><a type="submit"  class="" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-file="'. $claim[$j] .'">view</a></td>';
                else echo_td($claim[$j]);
            }
                if($claim[9] == 3){// claim is pending
            ?>
                <td class="btn-group">
                    <form style="display: inline-block" action="claim.php" method="POST" onsubmit="return confirms('delete the claim request')">
                        <input type="hidden" name="id" value="<?= $claim[0] ?>" hidden>
                        <input type="hidden" name="file" value="<?= $claim[4] ?>" hidden>
                        <button type="submit" name="delete" class="btn btn-secondary text-light">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            <?php } elseif($claim[9] == 5){ //claim is prepared ?>
                <td class="btn-group">
                    <form action="claim.php" method="POST" onsubmit="return confirms('take the claim')">
                        <input type="hidden" name="id" value="<?= $claim[0] ?>" hidden>
                        <button class="btn btn-warning form-control mb-1 text-light" type="submit" name="take" value="Take">
                            <i class="fas fa-hand-holding-usd"></i>
                        </button>
                    </form>
                </td>
            <?php
                }
            echo "</tr>";
        }
    }
?>
            </tbody>
        </table>

        <!-- File Modal -->
        <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModal" aria-hidden="true">
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
            var exampleModal = document.getElementById('fileModal')
            exampleModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget
                var recipient = button.getAttribute('data-bs-file')
                var modalTitle = exampleModal.querySelector('.modal-title')
                var modalBodyInput = exampleModal.querySelector('.modal-body img')
                modalTitle.textContent = 'File: ' + recipient;
                modalBodyInput.src = "upload/claim/" + recipient;
            })
        </script>
    </div>
</div>