<?php
    if( isset($_POST['emId']) &&
        isset($_POST['start']) && isset($_POST['end']) &&
        isset($_POST['type']) && isset($_POST['reason']) &&
        isset($_POST['comment']) &&
        isset($_POST['add'])
        ){
        
        $emId = filterInput(($_POST['emId']));
        $start = filterInput(($_POST['start']));
        $end = filterInput(($_POST['end']));
        $type = filterInput(($_POST['type']));
        $reason = filterInput(($_POST['reason']));
        $comment = filterInput(($_POST['comment']));
        $datetimeNow = get_now();

        $msg = check_upload_valid("leave");
        if($msg == 1){
            $sql = "INSERT INTO leave_request VALUES (NULL, '$emId', '$type', '$reason', '$start', '$end', NULL, '$datetimeNow', '$datetimeNow', '$comment', 1)";
            swal_result($sql, "Assign Leave", "", "");
        } else swal("Assign Leave Failed", $msg, "error");

// # start file checking
//         if(isset($_FILES["fileToUpload"]["name"]) && $_FILES["fileToUpload"]["name"] != "") {
//             $fileName = filterInput($_FILES["fileToUpload"]["name"]);
//             $uploadok = 1;
//             $target_dir = "upload/leave/";
//             $target_file = $target_dir . $fileName;
            
//             $imgFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
//             // create folder if file not exist
//             if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        
//             // Check if image file is a actual image or fake image
//             if(isset($_POST["uploadResume"])) {
//                 if(($check = getimagesize($_FILES["fileToUpload"]["tmp_name"])) !== false) $uploadok = 1;
//                 else {
//                     echo "<script>alert(File is not an image!);</script>";
//                     $uploadok = 0;
//                 }
//             }
        
//             for ($i=0; file_exists($target_file); $i++) {
//                 // change file name by add one at the end
//                 $temp = explode(".", $fileName);
//                 $temp[0] .= "1";
//                 $fileName = $temp[0] . "." . $temp[1];
//                 $target_file = $target_dir . $fileName;
//             }
        
//             // Check file size
//             if ($_FILES["fileToUpload"]["size"] > 1000000) { //1MB
//                 echo "<script>alert(Sorry, your file is too large, max is 1MB.);</script>";
//                 $uploadok = 0;
//             }
        
//             // Allow certain file formats
//             if($imgFileType != "jpg" && $imgFileType != "png" && $imgFileType != "jpeg") {
//                 echo "<script>alert(Sorry, only JPG, JPEG, PNG files are allowed.);</script>";
//                 $uploadok = 0;
//             }
// # end file checking            
//             if ($uploadok == 1) {
//                 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//                     $sql = "INSERT INTO leave_request VALUES (NULL, '$emId', '$type', '$reason', '$start', '$end', '$fileName', '$datetimeNow', '$datetimeNow', '$comment', 1)";
//                     $rs = $conn->query($sql);
//                     if($rs) echo '<script>swal("Assign Leave Successfully", "", "success");</script>';
//                     else echo '<script>swal("Assign Leave Failed", "", "error");</script>';
    
//                 } else echo "<script>swal('Upload File Error!', 'Sorry, there was an error uploading your file!', 'error');</script>";
//             } else echo "<script>swal('Upload File Error', 'Sorry, there was an error uploading your file!', 'error');</script>";
//         } else {
//             $sql = "INSERT INTO leave_request VALUES (NULL, '$emId', '$type', '$reason', '$start', '$end', NULL, '$datetimeNow', '$datetimeNow', '$comment', 1)";
//             $rs = $conn->query($sql);
//             if($rs) echo '<script>swal("Assign Leave Successfully", "", "success");</script>';
//             else echo '<script>swal("Assign Leave Failed", "", "error");</script>';
//         }        
    }
?>