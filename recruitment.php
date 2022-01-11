<?php
include('layout/initial.php');

if (isset($_SESSION['admin'])){
    start_HTML_header("Recruitment");

    require_once('function/recruitment/addRecruitment.php');
    require_once('function/recruitment/editRecruitment.php');
    require_once('function/recruitment/addRecruitmentAllowance.php');
    require_once('function/recruitment/editRecruitmentAllowance.php');
    require_once('function/recruitment/deleteRecruitmentAllowance.php');
    
    if (isset($_GET['add'])){
        set_h1("Add Recruitment");
        breadcrumb(array("Recruitment" => "recruitment.php"), "Add");
        include('template/recruitment/recruitment_add.php');
    
    } elseif (isset($_GET['editAllowance']) && isset($_GET['id']) ){
        include('template/recruitment/recruitment_allowance_edit.php');
        
    } elseif (isset($_GET['edit']) && isset($_GET['id']) ){
        set_h1("Edit Recruitment");
        breadcrumb(array("Recruitment" => "recruitment.php"), "Edit");
        include('template/recruitment/recruitment_edit.php');
        
    } elseif(isset($_GET['history'])) {
        set_h1("Recruitment History");
        breadcrumb(array("Recruitment" => "recruitment.php"), "History");
        include('template/recruitment/recruitment_history.php');

    } else { //view
        set_h1("Recruitment");
        breadcrumb(0, "Recruitment");
        include('template/recruitment/recruitment_view.php');
    }
} else {
    start_HTML_header("Vacancy");
    include('template/recruitment/vacancy.php');
}
include('layout/footer.php');
?>