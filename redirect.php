<?php
    session_start();
    if(isset($_SESSION['redirect'])) {
        $redirect = $_SESSION['redirect'];
        unset($_SESSION['redirect']);
?>
    <script>
        window.location = "<?= $redirect ?>";
    </script>
<?php
    }
?>