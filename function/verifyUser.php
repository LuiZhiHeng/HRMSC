<?php
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email = filterInput(strtolower($_POST['email']));
        $password = filterInput(sha1($_POST['password']));
        
        $rs = $conn->query("SELECT employeeName, employeeId FROM employee WHERE email='$email' AND pwd='$password'");
        if($rs->num_rows > 0){
            $data = $rs->fetch_array(MYSQLI_NUM);
            $nickName = explode(' ', trim($data[0]));
            set_session($nickName[0], 2, $data[1]);
        } else { //check is admin ?
            $rs = $conn->query("SELECT * FROM admin WHERE adminEmail='$email' AND pwd='$password'");
            if($rs->num_rows > 0){
                $admin = $rs->fetch_assoc();
                $adminName = ($admin['adminLevel'] == 1) ? "Admin" : "Staff";
                set_session($adminName, 1, $admin['adminId']);
            } else $_SESSION['login'] = 0;
        }
    }
?>