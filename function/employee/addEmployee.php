<?php

    if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['birthday']) && isset($_POST['gender']) &&
        isset($_POST['address1']) && isset($_POST['address2']) && isset($_POST['address3']) && isset($_POST['state']) && isset($_POST['postCode']) && isset($_POST['city']) &&
        isset($_POST['epf']) && isset($_POST['socso']) && isset($_POST['eis']) && isset($_POST['pcb']) &&
        isset($_POST['position']) && isset($_POST['startDate'])
    ){
        $employeeName = filterInput($_POST['name']);
        $email = filterInput($_POST['email']);
        $pwd = filterInput($_POST['password']);
        $pwdSha = sha1($pwd);
        $phone = filterInput($_POST['phone']);
        $birthday = filterInput($_POST['birthday']);
        $gender = filterInput($_POST['gender']);

        $address1 = filterInput($_POST['address1']);
        $address2 = filterInput($_POST['address2']);
        $address3 = filterInput($_POST['address3']);
        $stateTypeId = filterInput($_POST['state']);
        $postCode = filterInput($_POST['postCode']);
        $city = filterInput($_POST['city']);

        $epfAcc = filterInput($_POST['epf']);
        $socsoAcc = filterInput($_POST['socso']);
        $eisAcc = filterInput($_POST['eis']);
        $pcbAcc = filterInput($_POST['pcb']);

        $startWorkDate = filterInput($_POST['startDate']);
        $recruitmentId = filterInput($_POST['position']);

        $rs = $conn->query("INSERT INTO employee VALUES (NULL, '$employeeName', '$email', '$pwdSha', '$phone', '$birthday', '$gender',
            '$address1', '$address2', '$address3', '$stateTypeId', '$postCode', '$city',
            '$epfAcc', '$socsoAcc', '$eisAcc', '$pcbAcc', '$startWorkDate', '0000-00-00', '$recruitmentId')");
        if($rs) {
            send_mail($email, "HRMSC account", "Your password: " . $pwd);
            swal("Add Employee Successfully!", "The employee data has been added", "success");
        } else swal("Add Employee Failed!", "Failed to add employee!", "error");
    }
?>