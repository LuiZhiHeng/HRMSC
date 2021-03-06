<div class="container">
    <form class="row g-3" method="POST" action="leave.php" enctype="multipart/form-data">
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="emId" class="form-label">Employee ID</label>
                <select class="form-control form-select" name="emId" id="emId" onchange="getLeaveLeft(this.value)">
                    <option value="0" hidden> -- Select Employee -- </option>
                <?php
                    $rsEm = $conn->query("SELECT employeeId, employeeName FROM employee");
                    for ($i=0; $i < $rsEm->num_rows; $i++) {
                        $dataEm = $rsEm->fetch_assoc();
                        echo '<option value="' . filterOutput($dataEm['employeeId']) . '">' . filterOutput($dataEm['employeeName']) . '</option>';
                    }
                ?>
                </select>
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
                <input class="form-control" type="file" name="fileToUpload" accept="image/jpg, image/jpeg, image/png" id="file" required>
            </div>
        </div>
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" name="comment" id="comment" placeholder="Comment from admin here..."></textarea>
            </div>
        </div>
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12 text-end">
                <button type="submit" class="btn btn-danger" name="add">Assign Leave</button>
            </div>
        </div>
        
        
        <script>
            document.getElementById("start").onchange = function () {
                var input = document.getElementById("end");
                input.min = this.value;
            }

            function getLeaveLeft(id) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("leaveLeft").value = this.responseText;
                    }
                };
                var leaveType = document.getElementById("type").value;
                xmlhttp.open("GET", "function/leave/getLeaveLeft.php?q=" + id + "&leaveType=" + leaveType, true);
                xmlhttp.send();
            }

            function getLeave(leaveType) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("leaveLeft").value = this.responseText;
                    }
                };
                var id = document.getElementById("emId").value;
                xmlhttp.open("GET", "function/leave/getLeaveLeft.php?q=" + id + "&leaveType=" + leaveType, true);
                xmlhttp.send();
            }
        </script>
    </form>
</div>