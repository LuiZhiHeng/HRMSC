<div class="row">
    <?php 
        set_h1("Leave Request"); 
        $uId = get_logged_user_id();
        $today = get_date_now();
    ?>
    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Approved Leave Request</div>
                        <?php
                        $sql = "SELECT count(*) FROM leave_request WHERE leaveStatus=1 AND employeeId='$uId' AND endLeaveDateTime>='$today'";
                        $rs = $conn->query($sql);
                        
                        if($rs->num_rows > 0){
                            $data = $rs->fetch_array(MYSQLI_NUM);
                            echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                        }
                        ?>
                    </div>
                    <i class="fas fa-business-time"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="leave.php">View Request</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Pending Leave Request</div>
                        <?php
                        $sql = "SELECT count(*) FROM leave_request WHERE leaveStatus=3 AND employeeId='$uId'";
                        $rs = $conn->query($sql);
                        
                        if($rs->num_rows > 0){
                            $data = $rs->fetch_array(MYSQLI_NUM);
                            echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                        }
                        ?>
                    </div>
                    <i class="fas fa-business-time"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="leave.php">View Request</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card bg-danger text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Rejected Leave Request</div>
                        <?php
                        $sql = "SELECT count(*) FROM leave_request WHERE leaveStatus=2 AND employeeId='$uId' AND endLeaveDateTime<='$today'";
                        $rs = $conn->query($sql);
                        
                        if($rs->num_rows > 0){
                            $data = $rs->fetch_array(MYSQLI_NUM);
                            echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                        }
                        ?>
                    </div>
                    <i class="fas fa-business-time"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="leave.php">View Request</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>
</div>
<!-- Claim -->
<div class="row">
    <?php set_h1("Claim Request"); ?>
    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Approved Claim Request</div>
                        <?php
                        $sql = "SELECT count(*) FROM claim_request WHERE claimStatus=1 AND employeeId='$uId'";
                        $rs = $conn->query($sql);
                        
                        if($rs->num_rows > 0){
                            $data = $rs->fetch_array(MYSQLI_NUM);
                            echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                        }
                        ?>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="claim.php">View Request</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Pending Claim Request</div>
                        <?php
                        $sql = "SELECT count(*) FROM claim_request WHERE claimStatus=3 AND employeeId='$uId'";
                        $rs = $conn->query($sql);
                        
                        if($rs->num_rows > 0){
                            $data = $rs->fetch_array(MYSQLI_NUM);
                            echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                        }
                        ?>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="claim.php">View Request</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card bg-danger text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Rejected Claim Request</div>
                        <?php
                        $sql = "SELECT count(*) FROM claim_request WHERE claimStatus=2 AND employeeId='$uId'";
                        $rs = $conn->query($sql);
                        
                        if($rs->num_rows > 0){
                            $data = $rs->fetch_array(MYSQLI_NUM);
                            echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                        }
                        ?>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="claim.php?r=y">View Request</a>
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
    </div>
</div>
