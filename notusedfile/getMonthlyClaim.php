<?php
    require('../../db/connectDB.php');
    require('../filterOutput.php');
    $emId = (int) $_REQUEST["n"];
    $monthSelected = (int) $_REQUEST["m"];
    $yearSelected = (int) $_REQUEST["y"];
    if($monthSelected < 1 || $monthSelected > 12) die("Invalid Month");
    elseif($monthSelected > get_month_now()) die("No record yet..");
    if($yearSelected < 1900) die("Invalid Year");
    elseif($yearSelected > get_year_now()) die("No record yet...");

    $dateSelected = date("Y-m-d", strtotime($yearSelected . "-" . $monthSelected . "-1 00:00:00"));
    $dateNext = date("Y-m-d", strtotime($yearSelected . "-" . $monthSelected+1 . "-1 00:00:00"));

    $arrClaim = [[]];
    $rsClaim = $conn->query("SELECT * FROM claim_request WHERE employeeId = '$emId' AND applyClaimDateTime >= '$dateSelected' AND applyClaimDateTime < '$dateNext'");
    if($rsClaim->num_rows >= 0){
        for ($i=0; $i < $rsClaim->num_rows; $i++){ 
            $dataClaim = $rsClaim->fetch_assoc();
            $arrClaim[$i][0] = $dataClaim['applyClaimDateTime'];
            $arrClaim[$i][1] = $dataClaim['claimAmount'];
            $arrClaim[$i][2] = $dataClaim['claimStatus'];
        }
        showTable($arrClaim);
    } else die("Failed to Get Claim Data...");


    function showTable($arrClaim){
        echo_tag("tr class='text-center'", 0);
            echo_txt_tag("Request Type", "th");
            echo_txt_tag("Total", "th");
            echo_tag("th style='overflow: hidden; white-space: nowrap;'", 0);
                echo_txt("Amount (RM)");
            echo_tag("th", 1);
        echo_tag("tr", 1);

        showRow($arrClaim, 3, "Pending");
        showRow($arrClaim, 1, "Approved");
        showRow($arrClaim, 5, "Prepared");
        showRow($arrClaim, 6, "Taken");
    }

    function showRow($arrClaim, $statusType, $statusName){
        $arr = checkClaim($arrClaim, $statusType);
        $amount = 0;
        if($arr != [[]]){
            $arrNum = count($arr);
            for ($i=0; $i < $arrNum; $i++) $amount += $arr[$i][1];
        } else $arrNum = 0;

        $amount = number_format($amount, 2);
        
        echo_tag("tr", 0);
            echo_td($statusName);
            echo_tag("td class='text-center'", 0);
                echo_txt($arrNum);
            echo_tag("td", 1);
            echo_tag("td class='text-end'", 0);
                echo_txt($amount);
            echo_tag("td", 1);
        echo_tag("tr", 1);
    }

    function checkClaim($arrClaim, $statusType){
        $arrTemp = [[]];
        $countNum = 0;
        if($arrClaim != [[]]){
            for ($i=0; $i < count($arrClaim); $i++) {
                $status = $arrClaim[$i][2];
                if($status == $statusType) $arrTemp[$countNum++] = $arrClaim[$i];
            }
        }
        return $arrTemp;
    }
?>