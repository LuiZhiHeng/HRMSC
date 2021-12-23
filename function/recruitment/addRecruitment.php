<?php
    if( isset($_POST['position']) && isset($_POST['limit']) &&
        isset($_POST['detail']) && isset($_POST['requirement']) &&
        isset($_POST['salary']) && 
        isset($_POST['allowance']) && isset($_POST['allowanceAmount']) &&
        isset($_POST['workDay']) && 
        isset($_POST['timeStart']) && isset($_POST['timeEnd']) &&
        isset($_POST['add'])
        ){
        $position = filterInput(($_POST['position']));
        $limit = filterInput(($_POST['limit']));
        $detail = filterInput(($_POST['detail']));
        $requirement = filterInput(($_POST['requirement']));

        $salary = filterInput(($_POST['salary']));
        $allowance = filterInput(($_POST['allowance']));
        $allowanceAmount = filterInput(($_POST['allowanceAmount']));
        
        $allowance = filterInput(($_POST['allowance']));
        $allowanceAmount = filterInput(($_POST['allowanceAmount']));

        $workDay = "";
        foreach ($_POST['workDay'] as $day) $workDay .= filterInput($day);
        $timeStart = filterInput(($_POST['timeStart']));
        $timeEnd = filterInput(($_POST['timeEnd']));

        $rsTF = true;

        // add recruitment
        $sql = "INSERT INTO recruitment VALUES (NULL, '$position', '$detail', '$requirement', '$salary', '$limit', '$workDay', '$timeStart', '$timeEnd')";
        $rs = $conn->query($sql);
        if(!$rs) $rsTF = false;
        else {
            $rs = $conn->query("SELECT recruitmentId FROM recruitment");
            if(!$rs) $rsTF = false;
            else {
                if($rs->num_rows == 0) $recruitmentId = 1;
                else $recruitmentId = $rs->num_rows;
                
                $rs = $conn->query("INSERT INTO allowance VALUES (NULL, '$recruitmentId', '$allowance', '$allowanceAmount')");
                if(!$rs) $rsTF = false;
                else {
                    $maxAllow = filterInput(($_POST['maxAllow']));
                    if($maxAllow > 0){
                        for ($i=1; $i <= $maxAllow; $i++) { 
                            $tempAllowanceId = "allowance" . $i;
                            $tempAllowanceAmount = "allowanceAmount" . $i;        
                            if(isset($_POST[$tempAllowanceId])) $temp0 = filterInput($_POST[$tempAllowanceId]);
                            if(isset($_POST[$tempAllowanceAmount])) $temp1 = filterInput($_POST[$tempAllowanceAmount]);
                            if(isset($_POST[$tempAllowanceId]) && isset($_POST[$tempAllowanceAmount])) {
                                $rs = $conn->query("INSERT INTO allowance VALUES (NULL, '$recruitmentId', '$temp0', '$temp1')");
                                if(!$rs) $rsTF = false;
                            }
                        }
                    }
                }
            }
        }
        
        if($rsTF) swal("Add Recruitment Successfully", "\'" . $position . "\' is added successfully", "success");
        else swal("Add Recruitment Failed", " ", "error");
    }
?>