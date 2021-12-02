<?php
if(isset($_GET['id']) && isset($_GET['edit'])){
    $emId = filterInput($_GET['id']);
    $rsEmployee = $conn->query("SELECT * FROM employee WHERE employeeId='$emId'");
    for ($i=0; $i < $rsEmployee->num_rows; $i++) {
        $dataEm = $rsEmployee->fetch_assoc();

?>

<div class="container">
    <form method="POST" action="employee.php">
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <legend class="text-center bg-secondary text-light mt-5 p-1">-- Personal Data --</legend>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="emId" class="form-label">Employee ID</label>
                <input type="text" class="form-control" name="emId" id="emId" value="<?= echo_txt($dataEm['employeeId']) ?>" readonly>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= echo_txt($dataEm['employeeName']) ?>" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= echo_txt($dataEm['email']) ?>" required>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" name="phone" id="phone" value="<?= echo_txt($dataEm['phone']) ?>" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" class="form-control" name="birthday" id="birthday" value="<?= echo_txt($dataEm['birthday']) ?>" required>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control form-select" name="gender" id="gender">
                    <option value="Male" 
                    <?php
                    if(filterOutput($dataEm['gender']) == "Male") echo ' selected';
                    ?>
                    >Male</option>
                    <option value="Female" 
                    <?php
                    if(filterOutput($dataEm['gender']) == "Female") echo ' selected';
                    ?>
                    >Female</option>
                </select>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <legend class="text-center bg-secondary text-light mt-5 p-1">-- Address --</legend>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <label for="address1" class="form-label">Address</label>
                <input type="text" class="form-control mb-2" name="address1" id="address1" value="<?= echo_txt($dataEm['address1']) ?>" placeholder="Address Line 1" required>
                <input type="text" class="form-control mb-2" name="address2" id="address" value="<?= echo_txt($dataEm['address2']) ?>" placeholder="Address Line 2" required>
                <input type="text" class="form-control mb-2" name="address3" id="address" value="<?= echo_txt($dataEm['address3']) ?>" placeholder="Address Line 3" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="state" class="form-label">State</label>
                <select class="form-control form-select" name="state" id="state">
                    <?php
                        $rsState = $conn->query("SELECT * FROM state_type");
                        for ($i=0; $i < $rsState->num_rows; $i++) { 
                            $state = $rsState->fetch_array(MYSQLI_NUM);
                            echo '<option value="'. filterOutput($state[0]) . '" ';
                            if($dataEm['stateTypeId'] == $state[0]) echo ' selected';
                            echo '>' . filterOutput($state[1]) . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="postCode" class="form-label">Post Code</label>
                <input type="number" class="form-control" name="postCode" id="postCode" min="0" value="<?= echo_txt($dataEm['postcode']) ?>" placeholder="XXXXX" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" name="city" id="city" value="<?= echo_txt($dataEm['city']) ?>" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <legend class="text-center bg-secondary text-light mt-5 p-1">-- Payroll --</legend>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <label for="epf" class="form-label">EPF ID</label>
                <input type="text" class="form-control mb-2" name="epf" id="epf" value="<?= echo_txt($dataEm['epfAcc']) ?>" required>
                <label for="socso" class="form-label">SOCSO ID</label>
                <input type="text" class="form-control mb-2" name="socso" id="socso" value="<?= echo_txt($dataEm['socsoAcc']) ?>" required>
                <label for="eis" class="form-label">EIS ID</label>
                <input type="text" class="form-control mb-2" name="eis" id="eis" value="<?= echo_txt($dataEm['eisAcc']) ?>" required>
                <label for="pcb" class="form-label">PCB ID</label>
                <input type="text" class="form-control mb-2" name="pcb" id="pcb" value="<?= echo_txt($dataEm['pcbAcc']) ?>" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <legend class="text-center bg-secondary text-light mt-5 p-1">-- Recruitment --</legend>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="position" class="form-label">Position</label>
                <select class="form-control form-select" name="position" id="position">
                    <?php
                        $rs = $conn->query("SELECT recruitmentId, position FROM recruitment");
                        for ($i=0; $i < $rs->num_rows; $i++) {
                            $job = $rs->fetch_assoc();
                            echo'<option value="' . filterOutput($job['recruitmentId']) . '" ';
                            if($dataEm['recruitmentId'] == $job['recruitmentId']) echo ' selected';
                            echo '>' . filterOutput($job['position']) . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
            </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="startDate" class="form-label">Start Working Date</label>
                <input type="date" class="form-control" name="startDate" id="startDate" value="<?= echo_txt($dataEm['startWorkDate']) ?>" required>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="endDate" class="form-label">End Working Date</label>
                <input type="date" class="form-control" name="endDate" id="endDate" value="<?= echo_txt($dataEm['endWorkDate']) ?>">
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12 text-end">
                <button type="submit" class="btn btn-success" name="edit">Save</button>
            </div>
        </div>
    </form>    
</div>
<?php
    }
}
?>