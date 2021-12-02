<?php
include('layout/initial.php');
start_HTML_header("");
set_h1("");

include('layout/footer.php');
?>

<!-- Taken -->
<i class="fas fa-hand-holding-usd"></i>
<!-- Prepared -->
<i class="fas fa-vote-yea"></i>
<!-- add -->
<i class="fas fa-plus-circle"></i>
<!-- edit -->
<i class="fas fa-edit"></i>
<i class="fas fa-pencil-ruler"></i>
<!-- delete -->
<i class="fas fa-trash"></i>
<!-- Comment -->
<i class="fas fa-comment"></i>
<!-- approve -->
<i class="fas fa-check-square"></i>
<i class="fas fa-check-circle"></i>
<i class="fas fa-check"></i>
<!-- reject -->
<i class="fas fa-window-close"></i>
<i class="fas fa-times-circle"></i>
<i class="fas fa-times"></i>
<!-- history -->
<i class="fas fa-clock"></i>
<i class="fas fa-history"></i>
<!-- Search -->
<i class="fas fa-eye"></i>
<i class="fab fa-sistrix"></i>
<i class="fas fa-search"></i>
<!-- payroll -->
<i class="fas fa-file-invoice-dollar"></i>


<?php
//eis 0.2%
function countEIS($salary) {
    if($salary >= 4000) return 7.9;
    elseif($salary >= 3000) return 5.9;
    elseif($salary >= 2000) return 3.9;
    elseif($salary >= 1000) return 1.9;
}

//EPF (1Employer 0Employee)
// epf XX XXX 1234567 123 1234567
//13% 11%
//13% 9% (2021)
function countEPFpercentage($user){
    if($user == 0) {
        if(date("Y") == "2021") return 0.09;
        else return 0.11;
    } else return 0.13;
}

//socso (1Employer 0Employee)
// socso X 1234567890 X
//>=60 = 1.25% 0%
//<60 = 1.75% 0.5%
function countSOCSOpercentage($age, $user){
    if($age >= 60 && $user != 0) return 0.0125;
    elseif($age < 60 && $user != 0) return 0.0175;
    elseif($age < 60 && $user == 0) return 0.005;
    else return 0;
}

function get_OT_payrate($worked_hour, $working_hour, $day_type){
    if($day_type == 0){ //normal day
        if($worked_hour > $working_hour) return 1.5;
        else return 1;
    } else if($day_type == 1){ //rest day
        if($worked_hour > $working_hour) return 2;
        else if($worked_hour >= ($working_hour/2)) return 1;
        else return 0.5;
    } else if ($day_type == 2) { //public holiday
        if($worked_hour > $working_hour) return 3;
        else return 2;
    } else return 1;
}



?>