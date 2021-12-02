<?php //employee.php
include('layout/initial.php');

if(isset($_SESSION['admin'])){
    start_HTML_header("Employee");
    require_once('function/employee/editEmployee.php');
    require_once('function/employee/addEmployee.php');

    if(isset($_GET['add'])) {
        set_h1('Add Employee');
        include("template/employee/employee_add.php");

    } else if(isset($_GET['id']) && isset($_GET['edit'])){
        set_h1("Edit Employee");
        include("template/employee/employee_edit.php");

    } else { //view
        set_h1("Employee List");
        include("template/employee/employee_view.php");
        
    }
} else if(isset($_SESSION['employee'])){
    start_HTML_header("Profile");
    set_h1("Profile");
    include("template/employee/employee_profile.php");
    
}
include('layout/footer.php');
?>