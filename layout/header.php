<?php
function start_HTML_header($title){
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title><?= $title ?> | HRMSC</title>
        <link href="asset/css/datatables.css" rel="stylesheet" />
        <link href="asset/css/bs5.css" rel="stylesheet" />
        <script src="asset/js/font-awesome.js" type="text/javascript"></script>
        <script src="asset/js/sweetAlert.js" type="text/javascript"></script>
        <script src="asset/js/confirm.js" type="text/javascript"></script>
        <script src="asset/js/ajax.js" type="text/javascript"></script>
        <style>
            .swal-modal .swal-text {
                text-align: center !important;
            }
        </style>
    </head>
<?php
    include('layout/nav.php');
}

function set_h1($title){
    echo '<h1 class="mt-4 d-print-none">' . $title . '</h1><hr class="d-print-none">';
}

function breadcrumb($arr, $current){
?>
    <nav class="ps-3 d-print-none" style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="../hrmsc">Home</a>
            </li>
            <?php if($arr != 0){ foreach ($arr as $name => $location){ ?>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="<?= $location; ?>"><?= $name; ?></a>
                </li>
            <?php }} ?>
            <li class="breadcrumb-item active" aria-current="page"><?= $current; ?></li>
        </ol>
    </nav>
    <hr class="d-print-none">
<?php
}

?>