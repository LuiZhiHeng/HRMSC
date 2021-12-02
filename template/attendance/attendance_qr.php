<?php
if(isset($_SESSION['admin'])){
    $link = "https://192.168.0.177/hrmsc/attendance.php?punch=" . display_date();
    $url = "https://chart.googleapis.com/chart?cht=qr&chs=400x400&chl=" . $link;
    
    $file = "asset/qr/qr.jpg";
    file_put_contents($file,file_get_contents($url));
?>
    <div class="container d-flex justify-content-center">
        <div class="card">
            <img src="<?= echo_txt($file) ?>" title="This is a QR Code">
            <a class="btn btn-primary m-1" href="<?= echo_txt($file) ?>" download>Download QR Code</a>
        </div>
    </div>
<?php
}
?>