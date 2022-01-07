<?php
    if(isset($_POST['month']) && isset($_POST['year']) && isset($_POST['generate'])){
        $monthSelected = filterInput($_POST['month']);
        $yearSelected = filterInput($_POST['year']);

        //check is existed?
        $rsCheck = $conn->query("SELECT month, year FROM payroll where month = '$monthSelected' AND year = '$yearSelected'");
        if(!$rsCheck) console("Fail to check payroll");
        elseif($rsCheck->num_rows > 0) swal("Generate Payroll failed!", "Payroll for '" . $monthSelected . "/" . $yearSelected . "' is already generated before", "warning");
        elseif($rsCheck->num_rows == 0){// data not exist == generate payroll
            $status = create_payroll($monthSelected, $yearSelected, 0);
            if($status == 0) swal("Generate Payroll Failed!", "Fail to generate payroll for \'" . $monthSelected . "/" . $yearSelected . "\'", "error");
            elseif($status == 5) swal("Generate Payroll Failed!", "No data is existed to generate payroll for \'" . $monthSelected . "/" . $yearSelected . "\'", "error");
            else swal("Generate Payroll Successfully!", "Succcessful generate payroll for \'" . $monthSelected . "/" . $yearSelected . "\'", "success");
        }
    }
?>