<?php
    require_once("checkSession.php");
    delete_session();
    header("Location: ../login.php");
?>