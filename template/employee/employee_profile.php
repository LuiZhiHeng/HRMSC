<?php
if(isset($_SESSION['employee'])){
    $emId = get_logged_user_id();
    $rsEmployee = $conn->query("SELECT * FROM employee WHERE employeeId='$emId'");
    for ($i=0; $i < $rsEmployee->num_rows; $i++) {
        $dataEm = $rsEmployee->fetch_assoc();
?>
<div class="container">
    <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button style="font-weight: 500" class="nav-link active" id="nav-personal-tab" data-bs-toggle="tab" data-bs-target="#nav-personal" type="button" role="tab" aria-controls="nav-personal" aria-selected="true">Info</button>
        <button style="font-weight: 500" class="nav-link" id="nav-address-tab" data-bs-toggle="tab" data-bs-target="#nav-address" type="button" role="tab" aria-controls="nav-address" aria-selected="false">Address</button>
        <button style="font-weight: 500" class="nav-link" id="nav-payroll-tab" data-bs-toggle="tab" data-bs-target="#nav-payroll" type="button" role="tab" aria-controls="nav-payroll" aria-selected="false">Payroll</button>
        <button style="font-weight: 500" class="nav-link" id="nav-recruitment-tab" data-bs-toggle="tab" data-bs-target="#nav-recruitment" type="button" role="tab" aria-controls="nav-recruitment" aria-selected="false">Job</button>
    </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-personal" role="tabpanel" aria-labelledby="nav-personal-tab">
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="row g-3 mb-3 d-flex justify-content-center">
                    <div class="col-lg-6 col-md-12">
                        <legend class="text-center bg-secondary text-light p-1">-- Personal Info --</legend>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= echo_txt($dataEm['employeeName']) ?>" disabled>
                </div>
            </div>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?= echo_txt($dataEm['email']) ?>" disabled>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" name="phone" id="phone" value="<?= echo_txt($dataEm['phone']) ?>" disabled>
                </div>
            </div>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <label for="birthday" class="form-label">Birthday</label>
                    <input type="date" class="form-control" name="birthday" id="birthday" value="<?= echo_txt($dataEm['birthday']) ?>" disabled>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <input type="text" class="form-control" name="gender" id="gender" value="<?= echo_txt($dataEm['gender']) ?>" disabled>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="nav-address" role="tabpanel" aria-labelledby="nav-address-tab">
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <legend class="text-center bg-secondary text-light p-1">-- Address --</legend>
                </div>
            </div>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <label for="address1" class="form-label">Address</label>
                    <input type="text" class="form-control mb-2" name="address1" id="address1" value="<?= echo_txt($dataEm['address1']) ?>" disabled>
                    <input type="text" class="form-control mb-2" name="address2" id="address" value="<?= echo_txt($dataEm['address2']) ?>" disabled>
                    <input type="text" class="form-control mb-2" name="address3" id="address" value="<?= echo_txt($dataEm['address3']) ?>" disabled>
                </div>
            </div>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <label for="state" class="form-label">State</label>
                    <?php
                        $state = $dataEm['stateTypeId'];
                        $rsState = $conn->query("SELECT stateName FROM state_type WHERE stateTypeId='$state'");
                        for ($i=0; $i < $rsState->num_rows; $i++) { 
                            $stateName = $rsState->fetch_array(MYSQLI_NUM);
                    ?>
                        <input type="text" class="form-control mb-2" name="state" id="state" value="<?= echo_txt($stateName[0]) ?>" disabled>
                    <?php
                        }
                    ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label for="postCode" class="form-label">Post Code</label>
                    <input type="number" class="form-control" name="postCode" id="postCode" min="0" value="<?= echo_txt($dataEm['postcode']) ?>" placeholder="XXXXX" disabled>
                </div>
            </div>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" name="city" id="city" value="<?= echo_txt($dataEm['city']) ?>" disabled>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="nav-payroll" role="tabpanel" aria-labelledby="nav-payroll-tab">
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <legend class="text-center bg-secondary text-light p-1">-- Payroll --</legend>
                </div>
            </div>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <label for="epf" class="form-label">EPF ID</label>
                    <input type="text" class="form-control mb-2" name="epf" id="epf" value="<?= echo_txt($dataEm['epfAcc']) ?>" disabled>
                    <label for="socso" class="form-label">SOCSO ID</label>
                    <input type="text" class="form-control mb-2" name="socso" id="socso" value="<?= echo_txt($dataEm['socsoAcc']) ?>" disabled>
                    <label for="eis" class="form-label">EIS ID</label>
                    <input type="text" class="form-control mb-2" name="eis" id="eis" value="<?= echo_txt($dataEm['eisAcc']) ?>" disabled>
                    <label for="pcb" class="form-label">PCB ID</label>
                    <input type="text" class="form-control mb-2" name="pcb" id="pcb" value="<?= echo_txt($dataEm['pcbAcc']) ?>" disabled>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="nav-recruitment" role="tabpanel" aria-labelledby="nav-recruitment-tab">
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <legend class="text-center bg-secondary text-light p-1">-- Job Detail --</legend>
                </div>
            </div>
        <?php
            $reId = $dataEm['recruitmentId'];
            $rs = $conn->query("SELECT * FROM recruitment WHERE recruitmentId='$reId'");
            for ($i=0; $i < $rs->num_rows; $i++) {
                $job = $rs->fetch_assoc();
        ?>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" name="position" id="position" value="<?= echo_txt($job['position']) ?>" disabled>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label for="startDate" class="form-label">Start Working Date</label>
                    <input type="date" class="form-control" name="startDate" id="startDate" value="<?= echo_txt($dataEm['startWorkDate']) ?>" disabled>
                </div>
            </div>
                <?php if($dataEm['endWorkDate'] != "0000-00-00"){ ?>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <label for="endDate" class="form-label">End Working Date</label>
                        <input type="date" class="form-control" name="endDate" id="endDate" value="<?= echo_txt($dataEm['endWorkDate']) ?>" disabled>
                </div>
                <div class="col-lg-3 col-md-6">
                </div>
            </div>
                <?php } ?>
                <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-md-12 col-lg-6">
                    <label for="detail" class="form-label">Position Detail</label>
                    <textarea class="form-control" style="min-height: 6em" row="5" name="detail" id="detail" disabled><?= echo_txt($job['positionDetail']) ?></textarea>
                </div>
            </div>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-md-12 col-lg-6">
                    <label for="requirement" class="form-label">Requirement</label>
                    <textarea class="form-control" row="5" style="min-height: 6em" name="requirement" id="requirment" disabled><?= echo_txt($job['requirement']) ?></textarea>
                </div>
            </div>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-md-12 col-lg-6">
                    <label for="salary" class="form-label">Salary</label>
                    <input type="number" class="form-control" name="salary" id="salary" min="0" value="<?= echo_txt($job['salary']) ?>" disabled>
                </div>
            </div>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-md-12 col-lg-6">
                    <label for="workDay" class="form-label">Working Day</label>
                    <?php
                        $tempWorkDay = str_split(filterOutput($job['workDay']));
                        $workDay = "";
                        for ($wd=0; $wd < count($tempWorkDay); $wd++) { 
                            $workDay .= $tempWorkDay[$wd];
                            if($wd != count($tempWorkDay)-1) $workDay .= ", ";
                        }
                    ?>
                    <input type="text" class="form-control" name="workDay" id="workDay" min="0" value="<?= echo_txt($workDay) ?>" disabled>
                </div>
            </div>
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <label for="timeStart" class="form-label">Working Time (From)</label>
                    <input type="time" class="form-control" name="timeStart" id="timeStart" value="<?= echo_txt($job['startJobTime']) ?>" disabled>
                </div>
                <div class="col-lg-3 col-sm-6">
                <label for="timeEnd" class="form-label">Working Time (Until)</label>
                    <input type="time" class="form-control" name="timeEnd" id="timeEnd" value="<?= echo_txt($job['endJobTime']) ?>" disabled>
                </div>
            </div>
        </div>
    </div>        
</div>
<?php
        }
    }
}
?>