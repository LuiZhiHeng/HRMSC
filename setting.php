<?php
include('layout/initial.php');
start_HTML_header("Setting");

if(isset($_SESSION['employee'])){
    require_once('function/employee/editPassword.php');

    if(isset($_GET['changePass'])){
        set_h1("Change Password");
        breadcrumb(0, "Setting");
        include('template/change_password.php');
    }
} elseif(isset($_SESSION['admin'])) {

    $arrPermission = [];
    $rsPermission = $conn->query("SELECT * FROM permission");
    if($rsPermission->num_rows >= 0){
        for ($i=0; $i < $rsPermission->num_rows; $i++) { 
            $dataPermission = $rsPermission->fetch_assoc();
            $arrPermission[$i] = $dataPermission['permissionLevel'];
        }
    }

    if(isset($_GET['changePass'])){
        require_once('function/changePassword.php');
        
        set_h1("Change Password");
        breadcrumb(array("Setting" => "setting.php"), "Change Password");
        include('template/change_password.php');

    } elseif(isset($_GET['permission'])){
        if($logged_user_id == 1){
            require_once('function/config/editPermission.php');
            
            set_h1("Manage Permission");
            breadcrumb(array("Setting" => "setting.php"), "Permission");
            include('template/config/permission.php');
        } else noPermission();

    } elseif(isset($_GET['allowance'])) {
        if($logged_user_id <= $arrPermission[0]){
            require_once('function/config/allowance/addAllowance.php');
            require_once('function/config/allowance/editAllowance.php');
        
            set_h1("Allowance List");
            breadcrumb(array("Setting" => "setting.php"), "Allowance");
            include('template/config/allowance_view.php');
        } else noPermission();

    } elseif(isset($_GET['claim_type'])) {
        if($logged_user_id <= $arrPermission[1]){
            require_once('function/config/claim/addClaimType.php');
            require_once('function/config/claim/editClaimType.php');

            set_h1("Claim Type");
            breadcrumb(array("Setting" => "setting.php"), "Claim");
            include('template/config/claim_type_view.php');
        } else noPermission();

    } elseif(isset($_GET['holiday'])) {
        if($logged_user_id <= $arrPermission[2]){
            if($_GET['holiday'] == "history"){
                set_h1("Public Holiday History");
                breadcrumb(array("Setting" => "setting.php", "Holiday" => "setting.php?holiday="), "History");
                include('template/config/holiday_history.php');
            } else {
                require_once('function/config/holiday/addHoliday.php');
                require_once('function/config/holiday/editHoliday.php');
                require_once('function/config/holiday/deleteHoliday.php');        
                
                set_h1("Public Holiday");
                breadcrumb(array("Setting" => "setting.php"), "Holiday");
                include('template/config/holiday_view.php');
            }
        } else noPermission();

    } elseif(isset($_GET['leave_rule'])) {
        if($logged_user_id <= $arrPermission[3]){
            require_once('function/config/leave/addLeaveRule.php');
            require_once('function/config/leave/editLeaveRule.php');

            set_h1(isset($_GET['name']) ? "Leave Rule (" . filterOutput($_GET['name']) . ")" : "Leave Rule");
            breadcrumb(array("Setting" => "setting.php", "Leave Type" => "setting.php?leave_type="), "Leave Rule");
            include('template/config/leave_rule_view.php');
        } else noPermission();

    } elseif(isset($_GET['leave_type'])) {
        if($logged_user_id <= $arrPermission[3]){
            require_once('function/config/leave/addLeaveType.php');
            require_once('function/config/leave/editLeaveType.php');
        
            set_h1("Leave Type List");
            breadcrumb(array("Setting" => "setting.php"), "Leave Type");
            include('template/config/leave_type_view.php');
        } else noPermission();

    } elseif(isset($_GET['overtime_rule'])) {
        if($logged_user_id <= $arrPermission[4]){
            require_once('function/config/overtime/addOvertimeRule.php');
            require_once('function/config/overtime/editOvertimeRule.php');
        
            set_h1(isset($_GET['name']) ? "Overtime Rule (" . filterOutput($_GET['name']) . ")" : "Overtime Rule");
            breadcrumb(array("Setting" => "setting.php", "Overtime Type" => "setting.php?overtime_type="), "Overtime Rule");
            include('template/config/overtime_rule_view.php');
        } else noPermission();

    } elseif(isset($_GET['overtime_type'])) {
        if($logged_user_id <= $arrPermission[4]){
            require_once('function/config/overtime/addOvertimeType.php');
            require_once('function/config/overtime/editOvertimeType.php');
    
            set_h1("Overtime List");
            breadcrumb(array("Setting" => "setting.php"), "Overtime Type");
            include('template/config/overtime_type_view.php');
        } else noPermission();

    } elseif(isset($_GET['payroll_type'])) {
        if($logged_user_id <= $arrPermission[5]){
            require_once('function/config/payroll/addPayrollType.php');
            require_once('function/config/payroll/editPayrollType.php');
    
            set_h1("Payroll Type List");
            breadcrumb(array("Setting" => "setting.php"), "Payroll Type");
            include('template/config/payroll_type_view.php');
        } else noPermission();

    } elseif(isset($_GET['payroll_rule'])) {
        if($logged_user_id <= $arrPermission[5]){
            require_once('function/config/payroll/addPayrollRule.php');
            require_once('function/config/payroll/editPayrollRule.php');
    
            set_h1(isset($_GET['name']) ? "Payroll Rule (" . filterOutput($_GET['name']) . ")" : "Payroll Rule");
            breadcrumb(array("Setting" => "setting.php", "Payroll Type" => "setting.php?payroll_type="), "Overtime Rule");
            include('template/config/payroll_rule_view.php');
        } else noPermission();

    } elseif(isset($_GET['state'])) {
        if($logged_user_id <= $arrPermission[6]){
            require_once('function/config/state/addState.php');
            require_once('function/config/state/editState.php');
        
            set_h1("State List");
            breadcrumb(array("Setting" => "setting.php"), "State");
            include('template/config/state_view.php');
        } else noPermission();

    } elseif(isset($_GET['status'])) {
        if($logged_user_id <= $arrPermission[7]){
            require_once('function/config/status/addStatus.php');
            require_once('function/config/status/editStatus.php');
        
            set_h1("Status List");
            breadcrumb(array("Setting" => "setting.php"), "Status");
            include('template/config/status_view.php');
        } else noPermission();

    } else {
        set_h1("Setting");
        breadcrumb(0, "Setting");
        include("template/config/setting_list.php");
    }
}

function noPermission(){
    echo "<h3 class='mt-3'>You don't have permission to view this page !!!</h3>";
}

include('layout/footer.php');
?>
