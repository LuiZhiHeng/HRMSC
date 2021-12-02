<?php
    if(isset($_POST['save'])){
        $rs = $conn->query("SELECT * FROM permission");
        if($rs->num_rows > 0) {
            for ($i=0; $i < $rs->num_rows; $i++) { 
                $data = $rs->fetch_assoc();
                $page = $data['name'];
                $lvl = isset($_POST[$page]) ? 2 : 1;
                $sql = "UPDATE permission SET permissionLevel = '$lvl' WHERE name = '$page'";
                swal_result($sql, "Edit Permission", "", "");
            }
        }
    }
?>