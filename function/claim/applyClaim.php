<?php
    if( isset($_POST['id']) && isset($_POST['type']) && 
        isset($_POST['detail']) && isset($_POST['amount']) &&
        isset($_POST['apply'])
        ){
        
        $emId = filterInput(($_POST['id']));
        $type = filterInput(($_POST['type']));
        $detail = filterInput(($_POST['detail']));
        $amount = filterInput(($_POST['amount']));
        $datetimeNow = get_now();
        
        $msg = check_upload_valid("claim");
        if($msg == 1){
            $sql = "INSERT INTO claim_request VALUES (NULL, '$emId', '$type', '$detail', '$amount', '$fileName', '$datetimeNow', NULL, NULL, 3)";
            swal_result($sql, "Apply Claim", "", "");
        } else swal("Apply Claim Failed", $msg, "error");
    }

// # start file checking
//         if(isset($_FILES["fileToUpload"]["name"]) && $_FILES["fileToUpload"]["name"] != "") {
//             $fileName = filterInput($_FILES["fileToUpload"]["name"]);
//             $uploadok = 1;
//             $target_dir = "upload/claim/";
//             $target_file = $target_dir . $fileName;
            
//             $imgFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
//             // create folder if file not exist
//             if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        
//             for ($i=0; file_exists($target_file); $i++) {
//                 // change file name by add one at the end
//                 $temp = explode(".", $fileName);
//                 $temp[0] .= "1";
//                 $fileName = $temp[0] . "." . $temp[1];
//                 $target_file = $target_dir . $fileName;
//             }
        
//             // Check file size
//             if ($_FILES["fileToUpload"]["size"] > 1000000) { //1MB
//                 alert("Sorry, your file is too large, max is 1MB.");
//                 $uploadok = 0;
//             }
        
//             // Allow certain file formats
//             if($imgFileType != "jpg" && $imgFileType != "png" && $imgFileType != "jpeg") {
//                 alert("Sorry, only JPG, JPEG, PNG files are allowed.");
//                 $uploadok = 0;
//             }
// # end file checking            
//             if ($uploadok == 1 && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//                 $sql = "INSERT INTO claim_request VALUES (NULL, '$emId', '$type', '$detail', '$amount', '$fileName', '$datetimeNow', NULL, NULL, 3)";
//                 swal_result($sql, "Apply Claim", "", "");
//             } else swal("Upload File Error", "Your file is not accepted!", "error");
//         } else {
//             $sql = "INSERT INTO claim_request VALUES (NULL, '$emId', '$type', '$detail', '$amount', NULL, '$datetimeNow', NULL, NULL, 3)";
//             swal_result($sql, "Apply Claim", "", "");
//         }        
//     }
?>