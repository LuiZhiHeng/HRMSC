<?php
    if(isset($_POST['id']) && isset($_POST['minSalary']) && isset($_POST['minAge']) && isset($_POST['percentEmployee']) && isset($_POST['percentEmployer']) && isset($_POST['valid']) && isset($_POST['add'])){
        $id = filterInput($_POST['id']);
        $minSalary = filterInput($_POST['minSalary']);
        $minAge = filterInput($_POST['minAge']);
        $percentEmployee = ($id==3) ? (filterInput($_POST['percentEmployee'])) : (filterInput($_POST['percentEmployee']) / 100);
        $percentEmployer = ($id==3) ? (filterInput($_POST['percentEmployer'])) : (filterInput($_POST['percentEmployer']) / 100);
        $valid = filterInput($_POST['valid']);

        $sql = "INSERT INTO payroll_item VALUES (NULL, '$id', '$minSalary', '$minAge', '$percentEmployee', '$percentEmployer', '$valid')";
        swal_result($sql, "Add Payroll Rule", "", "");
    }
?>