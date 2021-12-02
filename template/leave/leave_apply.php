<div class="container">
    <form class="row g-3" method="POST" action="leave.php" enctype="multipart/form-data">
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="emId" class="form-label">Employee Name</label>
                <?php
                    $uId = get_logged_user_id();
                    $rsEm = $conn->query("SELECT employeeName FROM employee WHERE employeeId='$uId'");
                    for ($i=0; $i < $rsEm->num_rows; $i++) {
                        $dataEm = $rsEm->fetch_assoc();
                ?>
                    <input type="hidden" id="id" name="id" value="<?= $uId ?>" hidden>
                    <input class="form-control" name="emId" id="emId" value="<?= echo_txt($dataEm['employeeName']) ?>" readonly>
                <?php
                    }
                ?>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="leaveLeft" class="form-label">Leave Left (Left/Total)</label>
                <input type="text" class="form-control" name="leaveLeft" id="leaveLeft" readonly>
            </div>
        </div>
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="start" class="form-label">Date (Start)</label>
                <input type="datetime-local" class="form-control" name="start" id="start" required>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="end" class="form-label">Date (End)</label>
                <input type="datetime-local" class="form-control" name="end" id="end" required>
            </div>
        </div>
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="type" class="form-label">Leave Type</label>
                <select class="form-control form-select" name="type" id="type" onchange="getLeave(this.value)">
                    <?php
                        $sql = "SELECT * FROM leave_type";
                        $rs = $conn->query($sql);
                        if ($rs->num_rows > 0){
                            for ($i=0; $i < $rs->num_rows; $i++){ 
                                $leaveType = $rs->fetch_array(MYSQLI_NUM);
                                echo '<option value="' . filterOutput($leaveType[0]) . '">' . filterOutput($leaveType[1]) . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="reason" class="form-label">Reason</label>
                <input class="form-control" name="reason" id="reason" placeholder="Enter reason here...">
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-md-12 col-lg-6">
                <label for="file" class="form-label">File</label><br>
                <input class="form-control" type="file" name="fileToUpload" accept="image/jpg, image/jpeg, image/png" id="file">
            </div>
        </div>
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12 text-end">
                <button type="submit" class="btn btn-danger" name="apply">Apply</button>
            </div>
        </div>
        
        
        <script>

            function getLeave(leaveType) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("leaveLeft").value = this.responseText;
                    }
                };
                var id = document.getElementById("id").value;
                xmlhttp.open("GET", "function/leave/getLeaveLeft.php?q=" + id + "&leaveType=" + leaveType, true);
                xmlhttp.send();
            }
        </script>
    </form>
</div>