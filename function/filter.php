<?php
function filterInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = addslashes($input);
    $input = htmlspecialchars($input);
	return $input;
}

function filterOutput($txt){
    $txt = htmlspecialchars($txt);
    $txt = strip_tags($txt);
    //$txt = htmlentities($txt);
    return $txt;
}

function echo_txt($txt){
    $txt = filterOutput($txt);
    echo $txt;
}

// $type 0 = open, 1 = close
function echo_tag($tag, $type){
    $tag = filterOutput($tag);
    if($type == 0) echo "<" . $tag . ">";
    elseif($type == 1) echo "</" . $tag . ">";
}

function echo_txt_tag($txt, $tag){
    $txt = filterOutput($txt);
    $tag = filterOutput($tag);
    echo "<" . $tag . ">" . $txt . "</" . $tag . ">";
}

function echo_td($txt){
    $txt = filterOutput($txt);
    echo "<td>" . $txt . "</td>";
}
?>