<?php
    if(isset($_POST['hid']) && isset($_POST['delete'])){
        $hid = filterInput($_POST['hid']);

        $sql = "DELETE FROM holiday WHERE holidayId = '$hid'";
        swal_result($sql, "Delete Holiday", "", "");
    }
?>