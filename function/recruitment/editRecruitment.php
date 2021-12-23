<?php
    if( isset($_POST['reId']) && isset($_POST['position']) && isset($_POST['limit']) &&
        isset($_POST['detail']) && isset($_POST['requirement']) &&
        isset($_POST['salary']) && isset($_POST['workDay']) && 
        isset($_POST['timeStart']) && isset($_POST['timeEnd']) &&
        isset($_POST['edit'])
        ){
        $reId = filterInput(($_POST['reId']));
        $position = filterInput(($_POST['position']));
        $limit = filterInput(($_POST['limit']));
        $detail = filterInput(($_POST['detail']));
        $requirement = filterInput(($_POST['requirement']));
        $salary = filterInput(($_POST['salary']));
        $workDay = "";
        foreach ($_POST['workDay'] as $day) $workDay .= filterInput($day);
        $timeStart = filterInput(($_POST['timeStart']));
        $timeEnd = filterInput(($_POST['timeEnd']));

        $sql = "UPDATE recruitment SET position='$position', positionDetail='$detail', requirement='$requirement', salary='$salary', peopleLimit='$limit', workDay='$workDay', startJobTime='$timeStart', endJobTime='$timeEnd' WHERE recruitmentId='$reId'";
        swal_result($sql, "Edit Recruitment", "\'" . $position . "\' is edited successfully", "\'" . $position . "\' is fail to edit");
    }
?>