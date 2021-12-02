<div class="row">
    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card bg-danger text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Leave Request</div>
                        <?php
                        $rs = $conn->query("SELECT count(leaveId) FROM leave_request WHERE leaveStatus=3");
                        
                        if($rs->num_rows > 0){
                            $data = $rs->fetch_array(MYSQLI_NUM);
                            echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                        } else echo '00';
                        ?>
                    </div>
                    <i class="fas fa-business-time"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="leave.php?request=">Manage Request</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Claiming Request</div>
                        <?php
                        $rs = $conn->query("SELECT count(claimId) FROM claim_request WHERE claimStatus=3");
                        
                        if($rs->num_rows > 0){
                            $data = $rs->fetch_array(MYSQLI_NUM);
                            echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                        } else echo '00';
                        ?>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="claim.php">Manage Request</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Wait Prepared Claim Request</div>
                        <?php
                        $rs = $conn->query("SELECT count(claimId) FROM claim_request WHERE claimStatus=5");
                        
                        if($rs->num_rows > 0){
                            $data = $rs->fetch_array(MYSQLI_NUM);
                            echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                        } else echo '00';
                        ?>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="claim.php">Manage Request</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>
</div>