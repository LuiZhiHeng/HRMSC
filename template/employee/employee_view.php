<div class="row form-inline mb-2">
    <form action="employee.php" method="GET">
        <button type="submit" class="btn btn-danger" name="add">Add Employee</button>
    </form>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Employee List
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Job Position</th>
                    <th class="text-center">EPF Acc</th>
                    <th class="text-center">SOCSO Acc</th>
                    <th class="text-center">EIS Acc</th>
                    <th class="text-center">PCB Acc</th>
                    <th class="text-center">Start Work Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
<?php
    $sql = "SELECT employee.*, recruitment.position FROM employee JOIN recruitment ON recruitment.recruitmentId = employee.recruitmentId";
    $rs = $conn->query($sql);
    if($rs->num_rows > 0) {
        for ($i=0; $i < $rs->num_rows; $i++) { 
            $data_user = $rs->fetch_array(MYSQLI_ASSOC);
            echo_tag("tr", 0);
            echo_td($i + 1);
            echo_td($data_user['employeeName']);
            echo_td($data_user['email']);
            echo_td($data_user['phone']);
            echo_td($data_user['position']);
            echo_td($data_user['epfAcc']);
            echo_td($data_user['socsoAcc']);
            echo_td($data_user['eisAcc']);
            echo_td($data_user['pcbAcc']);
            echo_td($data_user['startWorkDate']);
?>
            <td>
                <form action="employee.php?id=id" method="GET">
                    <input type="hidden" name="id" value="<?= echo_txt($data_user['employeeId']) ?>" hidden>
                    <button class="btn btn-success form-control" type="submit" name="edit">Edit</button>
                </form>
            </td>
<?php
            echo_tag("tr", 1);
        }
    }
?>
            </tbody>
        </table>
    </div>
</div>
