<?php
if(isset($_GET['id']) && isset($_GET['edit'])){

    $reId = $_GET['id'];
    $sql = "SELECT * FROM recruitment WHERE recruitmentId='$reId'";

    $rs = $conn->query($sql);
    for ($i=0; $i < $rs->num_rows; $i++) { 
        $re=$rs->fetch_assoc();

?>
<div class="container">
    <form method="POST" action="recruitment.php" >
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <input type="hidden" name="reId" value="<?= $reId ?>" hidden>
            <div class="col-lg-3 col-sm-6">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control" name="position" id="position" value="<?= $re['position'] ?>" required>
            </div>
            <div class="col-lg-3 col-sm-6">
                <label for="limit" class="form-label">People Limit</label>
                <input type="number" min="0" class="form-control" name="limit" id="limit" value="<?= $re['peopleLimit'] ?>" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-md-12 col-lg-6">
                <label for="detail" class="form-label">Position Detail</label>
                <textarea class="form-control" style="min-height: 6em" row="5" name="detail" id="detail"><?= $re['positionDetail'] ?></textarea>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-md-12 col-lg-6">
                <label for="requirement" class="form-label">Requirement</label>
                <textarea class="form-control" row="5" style="min-height: 6em" name="requirement" id="requirment"><?= $re['requirement'] ?></textarea>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-md-12 col-lg-6">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" class="form-control" name="salary" id="salary" min="0" value="<?= $re['salary'] ?>" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-md-12 col-lg-6">
                <label for="workDay" class="form-label">Working Day (Ctrl + Left Click to select multiple)</label>
                <select class="form-control form-select" name="workDay[]" id="workDay" size="7" multiple>
                <?php
                    $workDayAll = $re['workDay'];
                    for ($w=0; $w < strlen($workDayAll); $w++) $workDaySingle = str_split($workDayAll);
                    $arrayDay = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    for ($s=1; $s <= 7; $s++) { 
                        echo '<option value="' . $s . '"';
                        for ($t=0; $t < strlen($workDayAll); $t++) {
                            if($s == $workDaySingle[$t]) echo ' selected';
                        }
                        echo '>' . $arrayDay[$s-1] . '</option>';
                    }
                ?>
                </select>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-sm-6">
                <label for="timeStart" class="form-label">Working Time (From)</label>
                <input type="time" class="form-control" name="timeStart" id="timeStart" value="<?= $re['startJobTime'] ?>" required>
            </div>
            <div class="col-lg-3 col-sm-6">
            <label for="timeEnd" class="form-label">Working Time (Until)</label>
                <input type="time" class="form-control" name="timeEnd" id="timeEnd" value="<?= $re['endJobTime'] ?>" required>
            </div>
        </div>
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-xl-6 col-lg-3 text-end">
                <button type="submit" class="btn btn-danger" name="edit">Edit</button>
            </div>
        </div>
    </form>
</div>
<?php
    }
}
?>