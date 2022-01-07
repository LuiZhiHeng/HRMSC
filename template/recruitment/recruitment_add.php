<div class="container">
    <form method="POST" action="recruitment.php" >
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-sm-6">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control" name="position" id="position" required>
            </div>
            <div class="col-lg-3 col-sm-6">
                <label for="limit" class="form-label">People Limit</label>
                <input type="number" min="0" class="form-control" name="limit" id="limit" required>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-md-12 col-lg-6">
                <label for="detail" class="form-label">Position Detail</label>
                <textarea class="form-control" style="min-height: 6em" row="5" name="detail" id="detail"></textarea>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-md-12 col-lg-6">
                <label for="requirement" class="form-label">Requirement</label>
                <textarea class="form-control" row="5" style="min-height: 6em" name="requirement" id="requirment"></textarea>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-md-12 col-lg-6">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" class="form-control" name="salary" id="salary" min="0" required>
            </div>
        </div>


        <div id="part">
            <div class="row g-3 mb-3 d-flex justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <label for="allowance" class="form-label">Allowance</label>
                    <select class="form-control form-select" name="allowance" id="allowance">
                    <?php
                        $rs = $conn->query("SELECT * FROM allowance_type");
                        for ($i=0; $i < $rs->num_rows; $i++) { 
                            $allow = $rs->fetch_array(MYSQLI_NUM);
                            echo '<option value="' . $allow[0] . '">' . $allow[1] . '</option>';
                        }
                    ?>
                        
                    </select>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <label for="allowanceAmount" class="form-label">Allowance Amount</label>
                    <input type="number" class="form-control" name="allowanceAmount" id="allowanceAmount" min="0" required>
                </div>
            </div>

            <?php
                $rs = $conn->query("SELECT * FROM allowance_type");
                $tempOption = '\'';
                if($rs->num_rows >= 0){
                    for ($i=0; $i < $rs->num_rows; $i++) {
                        $allow = $rs->fetch_array(MYSQLI_NUM);
                        $tempOption .= '<option value="' . $allow[0] . '">' . $allow[1]  . '</option>';
                    }
                    $maxAllowance = $rs->num_rows;
                }
                
                $tempOption .= '\'';
            ?>

            <script>
                var countAllowNum = 0;
                var maxAllowNum = <?= $maxAllowance; ?>;
                var mId = "additionAllow";
                
                function addMoreAllowance() { 
                    countAllowNum++;
                    mId += countAllowNum;

                    var temp1 = 
                    '<div id="' + mId + '" class="row g-3 mb-3 d-flex justify-content-center">' +
                        '<div class="col-lg-3 col-sm-6">' +
                            '<label for="allowance' + countAllowNum + '" class="form-label">Allowance</label>' +
                            '<select class="form-control form-select" name="allowance' + countAllowNum + '" id="allowance' + countAllowNum + '">';

                    var temp2 = <?= $tempOption ?>;

                    var temp3 = 
                            '</select>' +
                        '</div>' +
                        '<div class="col-lg-2 col-sm-4">' +
                            '<label for="allowanceAmount' + countAllowNum + '" class="form-label">Allowance Amount</label>' +
                            '<input type="number" class="form-control" name="allowanceAmount' + countAllowNum + '" id="allowanceAmount' + countAllowNum + '" min="0" required>' +
                        '</div>' +
                        '<div class="col-lg-1 col-sm-2 text-end">' +
                            '<label class="form-label text-light">...</label>' +
                            '<button onclick="deleteAllow(\'' + mId + '\')" type="button" class="btn btn-dark form-control"><i class="fas fa-times"></i></button>' +
                        '</div>' +
                    '</div>';

                    document.getElementById("part").innerHTML += temp1 + temp2 + temp3;

                    if(countAllowNum >= maxAllowNum - 1) document.getElementById("addmore_btn").style.visibility='hidden';
                } 

                function deleteAllow(mid){
                    document.getElementById(mid).remove();
                    if(countAllowNum--) document.getElementById("addmore_btn").style.visibility='visible'
                }
            </script>
        </div>
        <div id="addmore_btn" class="row g-3 d-flex justify-content-center">
            <div class="col-xl-6 col-lg-3 text-end">
                <button onclick="addMoreAllowance()" type="button" class="btn btn-warning">Add More Allowance</button>
            </div>
        </div>

        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-md-12 col-lg-6">
                <label for="workDay" class="form-label">Working Day (Ctrl + Left Click to select multiple)</label>
                <select class="form-control form-select" name="workDay[]" id="workDay" size="7" multiple>
                    <option value="1">Monday</option>
                    <option value="2">Tuesday</option>
                    <option value="3">Wednesday</option>
                    <option value="4">Thursday</option>
                    <option value="5">Friday</option>
                    <option value="6">Saturday</option>
                    <option value="7">Sunday</option>
                </select>
            </div>
        </div>
        <div class="row g-3 mb-3 d-flex justify-content-center">
            <div class="col-lg-3 col-sm-6">
                <label for="timeStart" class="form-label">Working Time (From)</label>
                <input type="time" class="form-control" name="timeStart" id="timeStart" required>
            </div>
            <div class="col-lg-3 col-sm-6">
            <label for="timeEnd" class="form-label">Working Time (Until)</label>
                <input type="time" class="form-control" name="timeEnd" id="timeEnd" required>
            </div>
        </div>
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-xl-6 col-lg-3 text-end">
                <input type="hidden" name="maxAllow" value="<?= $maxAllowance; ?>" hidden>
                <button type="submit" class="btn btn-danger" name="add">Add</button>
            </div>
        </div>
    </form>
</div>