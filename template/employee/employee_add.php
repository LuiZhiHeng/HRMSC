<div class="container">
    <form method="POST" action="employee.php">
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <legend class="text-center bg-secondary text-light mt-5 p-1">-- Personal Data --</legend>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" name="password" id="password" onkeyup="check()" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <label for="password" class="form-label">Confirm Password</label>
                <input type="text" class="form-control" name="confirmPassword" id="confirmPassword" onkeyup="check()" required>
                <span id='message'></span>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" name="phone" id="phone" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-6">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" class="form-control" name="birthday" id="birthday" required>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control form-select" name="gender" id="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
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
                <input type="text" class="form-control mb-2" name="address1" id="address1" placeholder="Address Line 1" required>
                <input type="text" class="form-control mb-2" name="address2" id="address" placeholder="Address Line 2" required>
                <input type="text" class="form-control mb-2" name="address3" id="address" placeholder="Address Line 3" required>
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
                            echo '<option value="'. filterOutput($state[0]) . '">' . filterOutput($state[1]) . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="postCode" class="form-label">Post Code</label>
                <input type="number" class="form-control" name="postCode" id="postCode" min="0" placeholder="XXXXX" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" name="city" id="city" required>
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
                <input type="text" class="form-control mb-2" name="epf" id="epf" required>
                <label for="socso" class="form-label">SOCSO ID</label>
                <input type="text" class="form-control mb-2" name="socso" id="socso" required>
                <label for="eis" class="form-label">EIS ID</label>
                <input type="text" class="form-control mb-2" name="eis" id="eis" required>
                <label for="pcb" class="form-label">PCB ID</label>
                <input type="text" class="form-control mb-2" name="pcb" id="pcb" required>
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
                            $job = $rs->fetch_array(MYSQLI_NUM);
                            $numPeopleJobTaken = $conn->query("SELECT employeeId FROM employee WHERE recruitmentId='$job[0]'")->num_rows;
                            if($numPeopleJobTaken < $job[0]) echo '<option value="' . filterOutput($job[0]) . '">' . filterOutput($job[1]) . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="startDate" class="form-label">Start Working Date</label>
                <input type="date" class="form-control" name="startDate" id="startDate" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-6 col-md-12 text-end">
                <button type="submit" class="btn btn-danger" id="addN" name="addNew">Add Employee</button>
            </div>
        </div>
    </form>    
</div>
<script>
    var check = function() {
        var pw = document.getElementById('password');
        var cpw = document.getElementById('confirmPassword');
        var ms = document.getElementById('message');
        var btn = document.getElementById('addN');
        if (pw.value == "" && cpw.value == "") {
            ms.innerHTML = '';
        } else if (pw.value == cpw.value) {
            ms.style.color = 'green';
            ms.innerHTML = 'Matched';
            btn.disabled = false;

        } else {
            ms.style.color = 'red';
            ms.innerHTML = '"Password" and "Confirm Password" is not matching!';
            btn.disabled = true;
        }
    }
</script>