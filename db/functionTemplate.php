<?php

function send_mail($receiver, $subject, $content){
    $filename = "mail/" . "mail-" . date("Ymd-Hms");
    $myfile = fopen($filename . ".txt", "w");
    fwrite($myfile, "To: " . $receiver . 
                    "\nSubject: " . $subject . 
                    "\nFrom: " . "hrmsc@gmail.com" . 
                    "\n\n" . $content);
    fclose($myfile);
}

function console($content){
    $console_log = "console.log(\"" . $content . "\");";
    script($console_log);
}

function log_db(){

}

function script($script){
    echo "<script>" . $script . "</script>";
}

function alert($script){
    echo "<script>alert(\"" . $script . "\");</script>";
}

function swal($title, $content, $type){
    $swal = "swal(\"" . $title . "\", \"" . $content . "\", \"" . $type . "\");";
    script($swal);
}

function swal_result($sql, $crud_data, $success_content, $fail_content){
    global $conn;
    if($conn->query($sql)) swal($crud_data . " Successfully", $success_content, "success");
    else swal($crud_data . " Failed", $fail_content, "error");
}




function check_exist($name, $sql){
    global $conn;
    $rs = $conn->query($sql);
    for ($i=0; $i < $rs->num_rows; $i++) {
        $data = $rs->fetch_array(MYSQLI_NUM);
        if(strtolower($name) == strtolower($data[0])) return true;
    }
    return false;
}

function check_upload_valid($dir){
    if(isset($_FILES["fileToUpload"]["name"]) && $_FILES["fileToUpload"]["name"] != "") {
        $fileName = filterInput($_FILES["fileToUpload"]["name"]);
        $target_dir = "upload/" . $dir . "/";
        $target_file = $target_dir . $fileName;

        // create folder if file not exist
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

        for ($i=0; file_exists($target_file); $i++) {
            // change file name by add one at the end
            $temp = explode(".", $fileName);
            $temp[0] .= "1";
            $fileName = $temp[0] . "." . $temp[1];
            $target_file = $target_dir . $fileName;
        }

        // Check file size 1MB
        if ($_FILES["fileToUpload"]["size"] > 1000000) return "File Too Large! Max is 1MB";

        // Allow certain file formats
        $imgFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if($imgFileType != "jpg" && $imgFileType != "png" && $imgFileType != "jpeg") return "only JPG, JPEG, PNG file is allowed";

        if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) return 1;
        else return "Upload File Failed";
    } else return "Failed to Upload File";
}


// Employee
function get_employee($column, $columnSelected, $dataSelected){
    global $conn;
    $sql = "SELECT " . $column . " FROM employee";
    if($columnSelected != NULL && $dataSelected != NULL) $sql .= " WHERE " . $columnSelected . " = " . $dataSelected . ";";
    $rs = $conn->query($sql);
    $length = $rs->num_rows;
    if($length > 0){
        for ($i=0; $i < $length; $i++) { 
            $data = $rs->fetch_assoc();
            echo_td($data);
        }
    } else if ($length == 0){

    } else die("Couldn't get employee data...");
}
?>