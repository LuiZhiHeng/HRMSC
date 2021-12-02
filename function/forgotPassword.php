<?php
    if(isset($_POST['email']) && isset($_POST['reset'])){
        $email = filterInput($_POST['email']);

        function generate_password($max_length){
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $ran_str = "";
            for($i=0; $i< $max_length; $i++) $ran_str .= $permitted_chars[rand(0,strlen($permitted_chars)-1)];
            return $ran_str;
        }

        $newPwd = generate_password(6);
        $encPwd = sha1($newPwd);

        // $rsCheck = $conn->query("SELECT email FROM employee WHERE email='$email'");
        // if($rsCheck->num_rows > 0){
        //     $rs = $conn->query("UPDATE employee SET pwd='$encPwd' WHERE email='$email'");
        //     if(!$rs) swal("Reset password Failed!", "", "error");
        //     else {
        //         send_mail($email, "HRMSC account reset password", "Your password: " . $newPwd);
        //         swal("Reset password successfully!", "The new password has been sent to your email: \'" . $email ."\'", "success");
        //     }
        // } elseif($rsCheck->num_rows == 0){
        //     $rsCheck = $conn->query("SELECT adminEmail FROM admin WHERE adminEmail='$email'");
        //     if($rsCheck->num_rows > 0){
        //         $rs = $conn->query("UPDATE admin SET pwd='$encPwd' WHERE adminEmail='$email'");
        //         if(!$rs) swal("Reset password Failed!", "", "error");
        //         else {
        //             send_mail($email, "HRMSC account reset password", "Your password: " . $newPwd);
        //             swal("Reset password successfully!", "The new password has been sent to your email: \'" . $email ."\'", "success");
        //         }
        //     } else swal("Reset password Failed!", "", "error");
        // } else swal("Reset password Failed!", "", "error");

        $rsCheck = $conn->query("SELECT email FROM employee WHERE email='$email'");
        if($rsCheck->num_rows >= 0){
            if($rsCheck->num_rows > 0) $rs = $conn->query("UPDATE employee SET pwd='$encPwd' WHERE email='$email'");
            else {
                $rsCheck = $conn->query("SELECT adminEmail FROM admin WHERE adminEmail='$email'");
                if($rsCheck->num_rows > 0) $rs = $conn->query("UPDATE admin SET pwd='$encPwd' WHERE adminEmail='$email'");
                else swal("Reset password Failed!", "", "error");    
            }
            
            if(!$rs) swal("Reset password Failed!", "", "error");
            else {
                send_mail($email, "HRMSC account reset password", "Your password: " . $newPwd);
                swal("Reset password successfully!", "The new password has been sent to your email: \'" . $email ."\'", "success");
            }
        } else swal("Reset password Failed!", "", "error");
    }
?>