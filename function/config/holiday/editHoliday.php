<?php
    if(isset($_POST['id']) && isset($_POST['holidayName']) && isset($_POST['holidayDate']) && isset($_POST['edit'])){
        $id = filterInput($_POST['id']);
        $holidayName = filterInput($_POST['holidayName']);
        $holidayDate = filterInput($_POST['holidayDate']);

        $sql = "UPDATE holiday SET holidayName = '$holidayName', holidayDate = '$holidayDate' WHERE holidayId = '$id'";
        swal_result($sql, "Edit Holiday", "The holiday \'" . $holidayName . "\' (" . $holidayDate . ") has been edited", "");
    }

?>