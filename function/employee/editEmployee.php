<?php

    if(isset($_POST['emId']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['birthday']) && isset($_POST['gender']) &&
        isset($_POST['address1']) && isset($_POST['address2']) && isset($_POST['address3']) && isset($_POST['state']) && isset($_POST['postCode']) && isset($_POST['city']) &&
        isset($_POST['epf']) && isset($_POST['socso']) && isset($_POST['eis']) && isset($_POST['pcb']) &&
        isset($_POST['position']) && isset($_POST['startDate'])
    ){
        $emId = filterInput($_POST['emId']);
        $employeeName = filterInput($_POST['name']);
        $email = filterInput($_POST['email']);
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

        if(isset($_POST['endDate'])) $endWorkDate = filterInput($_POST['endDate']);
        else $endWorkDate = NULL;

        $sql = "UPDATE employee SET employeeName='$employeeName', email='$email', phone='$phone', birthday='$birthday', gender='$gender',
            address1='$address1', address2='$address2', address3='$address3', stateTypeId='$stateTypeId', postcode='$postCode', city='$city',
            epfAcc='$epfAcc', socsoAcc='$socsoAcc', eisAcc='$eisAcc', pcbAcc='$pcbAcc', startWorkDate='$startWorkDate', endWorkDate='$endWorkDate', recruitmentId='$recruitmentId' WHERE employeeId='$emId'";
        swal_result($sql, "Edit Employee", "Employee \'" . $employeeName . "\' is edited!", "");
    }
?>