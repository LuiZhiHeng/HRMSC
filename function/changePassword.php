<?php
    if(isset($_POST['id']) && isset($_POST['oldPass']) && isset($_POST['newPass']) && isset($_POST['changePass'])){
        $uId = filterInput($_POST['id']);
        $oldPwd = filterInput($_POST['oldPass']);
        $newPwd = filterInput($_POST['newPass']);

        $encOld = sha1(filterInput($_POST['oldPass']));
        $encNew = sha1(filterInput($_POST['newPass']));

        $rsOld = $conn->query("SELECT pwd FROM admin WHERE adminId = '$uId'");
        if($rsOld){
            $data = $rsOld->fetch_array(MYSQLI_NUM);
            if($encOld != $data[0]) swal("Your Old Password is incorrect!", "", "error");
            else {
                $sql = "UPDATE admin SET pwd='$encNew' WHERE adminId = '$uId'";
                swal_result($sql, "Change Password", "", "");
            }
        } else swal("Change Password Failed!", "", "error");
    }
?>