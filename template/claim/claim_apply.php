<div class="container">
    <form method="POST" action="claim.php" enctype="multipart/form-data">
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="emId" class="form-label">Employee Name</label>
                <?php
                    $uId = get_logged_user_id();
                    $rsEm = $conn->query("SELECT employeeName FROM employee WHERE employeeId='$uId'");
                    for ($i=0; $i < $rsEm->num_rows; $i++) {
                        $dataEm = $rsEm->fetch_assoc();
                ?>
                    <input type="hidden" id="id" name="id" value="<?= $uId ?>" hidden>
                    <input class="form-control" name="emName" id="emName" value="<?= $dataEm['employeeName'] ?>" readonly>
                <?php
                    }
                ?>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="type" class="form-label">Leave Type</label>
                <select class="form-control form-select" name="type" id="type">
                    <?php
                        $sql = "SELECT * FROM claim_type";
                        $rs = $conn->query($sql);
                        if ($rs->num_rows > 0){
                            for ($i=0; $i < $rs->num_rows; $i++){ 
                                $leaveType = $rs->fetch_array(MYSQLI_NUM);
                                echo '<option value="' . $leaveType[0] . '">' . $leaveType[1] . '</option>';
                            }
                        }

                    ?>
                </select>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="detail" class="form-label">Claim Detail</label>
                <input class="form-control" name="detail" id="detail" placeholder="Enter claim detail here...">
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="amount" class="form-label">Amount (RM)</label>
                <input type="number" step=".01" class="form-control" name="amount" id="amount" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-md-12 col-lg-6">
                <label for="file" class="form-label">File</label><br>
                <input class="form-control" type="file" name="fileToUpload" accept="image/jpg, image/jpeg, image/png" id="file" required>
            </div>
        </div>
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-xl-6 col-lg-3 text-end">
                <button type="submit" class="btn btn-danger" name="apply">Apply</button>
            </div>
        </div>
    </form>
</div>