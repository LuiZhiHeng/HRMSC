<?php
    if(isset($_POST['holidayName']) && isset($_POST['holidayDate']) && isset($_POST['add'])){
        $holidayName = filterInput($_POST['holidayName']);
        $holidayDate = filterInput($_POST['holidayDate']);

        $sql = "INSERT INTO holiday VALUES (NULL, '$holidayName', '$holidayDate')";
        swal_result($sql, "Add Holiday", "The holiday \'" . $holidayName . "\' (" . $holidayDate . ") has been added!", "");
    }
?>