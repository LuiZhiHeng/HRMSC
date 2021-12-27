<?php
    if(isset($_POST['save'])){
        $rs = $conn->query("SELECT * FROM permission");
        if($rs->num_rows > 0) {
            $success = 0;
            for ($i=0; $i < $rs->num_rows; $i++) { 
                $data = $rs->fetch_assoc();
                $page = $data['name'];
                $lvl = isset($_POST[$page]) ? 2 : 1;
                if($conn->query("UPDATE permission SET permissionLevel = '$lvl' WHERE name = '$page'")) $success = 1;
                else $success = 0;
            }
            if($success == 1) swal("Edit Permission Successfully", "", "success");
            else swal("Edit Permission Failed", "", "error");
        }
    }
?>