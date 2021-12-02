<?php
// To: 
// Subject: 
// From: 

// content

$filename = "mail/" . "mail-" . date("Ymd-Hms");
$myfile = fopen($filename . ".txt", "w");
fwrite($myfile, "To: " . $email);
fwrite($myfile, "\n");
fwrite($myfile, "Subject: " . "HRMSC account");
fwrite($myfile, "\n");
fwrite($myfile, "From: " . "hrmsc@gmail.com");
fwrite($myfile, "\n");
fwrite($myfile, "\n");
fwrite($myfile, "Your password: " . $_POST["password"]);
fclose($myfile);
?>