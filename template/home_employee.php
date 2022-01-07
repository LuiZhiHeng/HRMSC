<div class="row">
    <?php 
        set_h1("Leave Request"); 
        $uId = get_logged_user_id();
        $today = get_date_now();
        show_request("Approved", "leave.php", "<i class='fas fa-business-time'></i>", "success", "SELECT count(*) FROM leave_request WHERE leaveStatus=1 AND employeeId='$uId'");
        show_request("Pending", "leave.php", "<i class='fas fa-business-time'></i>", "warning", "SELECT count(*) FROM leave_request WHERE leaveStatus=3 AND employeeId='$uId'");
        show_request("Rejected", "leave.php", "<i class='fas fa-business-time'></i>", "danger", "SELECT count(*) FROM leave_request WHERE leaveStatus=2 AND employeeId='$uId'");
    ?>
</div>
<div class="row">
    <?php 
        set_h1("Claim Request"); 
        show_request("Approved", "claim.php", "<i class='fas fa-coins'></i>", "success", "SELECT count(*) FROM claim_request WHERE claimStatus=1 AND employeeId='$uId'");
        show_request("Pending", "claim.php", "<i class='fas fa-coins'></i>", "warning", "SELECT count(*) FROM claim_request WHERE claimStatus=3 AND employeeId='$uId'");
        show_request("Rejected", "claim.php", "<i class='fas fa-coins'></i>", "danger", "SELECT count(*) FROM claim_request WHERE claimStatus=2 AND employeeId='$uId'");
    ?>
</div>
<?php
function show_request($head, $link, $icon, $bgColour, $sql){
    global $conn;
?>
<div class="col-4 mb-4">
    <div class="card bg-<?= $bgColour ?> text-white h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="me-3">
                    <div class="text-white-75 small"><?= $head ?></div>
                    <?php
                    $rs = $conn->query($sql);
                    if(!$rs) echo "00";
                    elseif($rs->num_rows > 0){
                        $data = $rs->fetch_array(MYSQLI_NUM);
                        echo '<div class="text-lg fw-bold">' . $data[0] . '</div>';
                    } else echo '0';
                    ?>
                </div>
                <?= $icon ?>
            </div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between small">
            <a class="text-white stretched-link" href="<?= $link ?>">Manage Request</a>
            <i class="fas fa-angle-right"></i>
        </div>
    </div>
</div>
<?php
}
?>