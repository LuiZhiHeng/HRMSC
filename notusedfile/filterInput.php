<?php
function filterInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = addslashes($input);
    $input = htmlspecialchars($input);
	return $input;
}
?>