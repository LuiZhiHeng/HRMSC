<?php
include('layout/initial.php');
start_HTML_header("Setting");

if(isset($_SESSION['employee'])){
    require_once('function/employee/editPassword.php');

    if(isset($_GET['changePass'])){
        set_h1("Change Password");
        include('template/change_password.php');
    }
} elseif(isset($_SESSION['admin'])) {

    $arrPermission = [];
    $invalid = 0;
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
        include('template/change_password.php');

    } elseif(isset($_GET['permission'])){
        if($logged_user_id == 1){
            require_once('function/config/editPermission.php');
            
            set_h1("Manage Permission");
            include('template/config/permission.php');
        } else noPermission();

    } elseif(isset($_GET['allowance'])) {
        if($logged_user_id <= $arrPermission[0]){
            require_once('function/config/allowance/addAllowance.php');
            require_once('function/config/allowance/editAllowance.php');
        
            set_h1("Allowance List");        
            include('template/config/allowance_view.php');
        } else noPermission();

    } elseif(isset($_GET['claim_type'])) {
        if($logged_user_id <= $arrPermission[1]){
            require_once('function/config/claim/addClaimType.php');
            require_once('function/config/claim/editClaimType.php');

            set_h1("Claim Type");
            include('template/config/claim_type_view.php');
        } else noPermission();

    } elseif(isset($_GET['holiday'])) {
        if($logged_user_id <= $arrPermission[2]){
            if($_GET['holiday'] == "history"){
                set_h1("Public Holiday History");
                include('template/config/holiday_history.php');
            } else {
                require_once('function/config/holiday/addHoliday.php');
                require_once('function/config/holiday/editHoliday.php');
                require_once('function/config/holiday/deleteHoliday.php');        
                
                set_h1("Public Holiday");
                include('template/config/holiday_view.php');
            }
        } else noPermission();

    } elseif(isset($_GET['leave_rule'])) {
        if($logged_user_id <= $arrPermission[3]){
            require_once('function/config/leave/addLeaveRule.php');
            require_once('function/config/leave/editLeaveRule.php');

            set_h1(isset($_GET['name']) ? "Leave Rule (" . filterOutput($_GET['name']) . ")" : "Leave Rule");
            include('template/config/leave_rule_view.php');
        } else noPermission();

    } elseif(isset($_GET['leave_type'])) {
        if($logged_user_id <= $arrPermission[3]){
            require_once('function/config/leave/addLeaveType.php');
            require_once('function/config/leave/editLeaveType.php');
        
            set_h1("Leave Type List");
            include('template/config/leave_type_view.php');
        } else noPermission();

    } elseif(isset($_GET['overtime_rule'])) {
        if($logged_user_id <= $arrPermission[4]){
            require_once('function/config/overtime/addOvertimeRule.php');
            require_once('function/config/overtime/editOvertimeRule.php');
        
            set_h1(isset($_GET['name']) ? "Overtime Rule (" . filterOutput($_GET['name']) . ")" : "Overtime Rule");
            include('template/config/overtime_rule_view.php');
        } else noPermission();

    } elseif(isset($_GET['overtime_type'])) {
        if($logged_user_id <= $arrPermission[4]){
            require_once('function/config/overtime/addOvertimeType.php');
            require_once('function/config/overtime/editOvertimeType.php');
    
            set_h1("Overtime List");
            include('template/config/overtime_type_view.php');
        } else noPermission();

    } elseif(isset($_GET['payroll_type'])) {
        if($logged_user_id <= $arrPermission[5]){
            require_once('function/config/payroll/addPayrollType.php');
            require_once('function/config/payroll/editPayrollType.php');
    
            set_h1("Payroll Type List");
            include('template/config/payroll_type_view.php');
        } else noPermission();

    } elseif(isset($_GET['payroll_rule'])) {
        if($logged_user_id <= $arrPermission[5]){
            require_once('function/config/payroll/addPayrollRule.php');
            require_once('function/config/payroll/editPayrollRule.php');
    
            set_h1(isset($_GET['name']) ? "Payroll Rule (" . filterOutput($_GET['name']) . ")" : "Payroll Rule");
            include('template/config/payroll_rule_view.php');
        } else noPermission();

    } elseif(isset($_GET['state'])) {
        if($logged_user_id <= $arrPermission[6]){
            require_once('function/config/state/addState.php');
            require_once('function/config/state/editState.php');
        
            set_h1("State List");
            include('template/config/state_view.php');
        } else noPermission();

    } elseif(isset($_GET['status'])) {
        if($logged_user_id <= $arrPermission[7]){
            require_once('function/config/status/addStatus.php');
            require_once('function/config/status/editStatus.php');
        
            set_h1("Status List");
            include('template/config/status_view.php');
        } else noPermission();

    }
}

function noPermission(){
    echo "<h3 class='mt-3'>You don't have permission to view this page !!!</h3>";
}

include('layout/footer.php');
?>
