<?php
    if(isset($_POST['id']) && isset($_POST['oldPass']) && isset($_POST['newPass']) && isset($_POST['changePass'])){
        $uId = filterInput($_POST['id']);
        $oldPwd = filterInput($_POST['oldPass']);
        $newPwd = filterInput($_POST['newPass']);

        $encOld = sha1(filterInput($_POST['oldPass']));
        $encNew = sha1(filterInput($_POST['newPass']));

        $rsOld = $conn->query("SELECT pwd FROM employee WHERE employeeId = '$uId'");
        if($rsOld){
            $data = $rsOld->fetch_array(MYSQLI_NUM);
            if($encOld == $data[0]) {
                $sql = "UPDATE employee SET pwd='$encNew' WHERE employeeId = '$uId'";
                swal_result($sql, "Change Password", "", "");
            } else swal("Your Old Password is not correct!", "", "error");
        } else swal("Change Password Failed!", "Fail to change your password...", "error");
    }
?>