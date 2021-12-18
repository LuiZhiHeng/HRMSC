<?php
    $date = get_date_now();
    $uId = get_logged_user_id();

    $sql = "SELECT attendance.*, employee.employeeName
            FROM attendance JOIN employee ON employee.employeeId = attendance.employeeId
            WHERE attendance.attendanceDate='$date' AND attendance.employeeId='$uId'";
    $rs = $conn->query($sql);
    if(!$rs) echo "Some Error is occured!";
    elseif ($rs->num_rows > 0){
        $att = $rs->fetch_assoc();
        if ($att['punchInDateTime'] != NULL) {
            if ($att['punchOutDateTime'] != NULL && $att['punchOutDateTime'] != "0000-00-00 00:00:00") { //punched out
                script('swal("You have Punched Out!", "Last Punch Out: ' . $att['punchOutDateTime'] . '", "warning")');
                $outMsg = "Punch Out Again";
            } else $outMsg = "Punch Out";
?>
        <div class="container d-flex justify-content-center">
            <form class="row g-3 border border-secondary border-1 rounded-3 p-3 mt-1" method="POST" action="attendance.php" onsubmit="return confirms('<?= $outMsg ?>')">
                <input type="hidden" name="emId" id="emId" value="<?= $uId ?>" hidden>
                <input type="text" class="form-control" name="emName" id="emName" value="<?= echo_txt($att['employeeName']); ?>" readonly>
                <input type="date" class="form-control" name="date" id="date" value="<?= echo_txt($date); ?>" readonly>
                <div id="time" class="form-control" readonly></div>
                <button type="submit" class="btn btn-danger form-control" name="punchOut">Punch Out</button>
            </form>
        </div>
    <?php
        }
    } else { // no result == no punch in yet
        $rsEm = $conn->query("SELECT employeeName FROM employee WHERE employeeId = '$uId'");
        $emName = $rsEm->fetch_assoc();
?>
        <div class="container d-flex justify-content-center">
            <form class="row g-3 border border-secondary border-1 rounded-3 p-3 mt-1" method="POST" action="attendance.php" onsubmit="return confirms('Punch In')">
                <input type="hidden" name="emId" id="emId" value="<?= $uId ?>" hidden>
                <input type="text" class="form-control" name="emName" id="emName" value="<?= echo_txt($emName['employeeName']); ?>" readonly>
                <input type="date" class="form-control" name="date" id="date" value="<?= echo_txt($date); ?>" readonly>
                <div id="time" class="form-control" readonly></div>
                <button type="submit" class="btn btn-danger form-control" name="punchIn">Punch In</button>
            </form>
        </div>        
<?php } ?>

<script>
    function checkTime(i) {
        if (i < 10) i = "0" + i;
        return i;
    }

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();

        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
        t = setTimeout(function() {
            startTime()
        }, 500);
    }

    startTime();
</script>