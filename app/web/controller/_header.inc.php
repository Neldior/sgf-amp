<?php
    session_start();
    if (isset($_SESSION['USER'])) {
        unset($_SESSION['USER']);
    }
    require_once '../../includes/connect_db.php';
    //$ROOT = $_SESSION['ROOT'];

    /*include("$ROOT/app/pages/connect.php");
    //include("$ROOT/app/pages/config.php");
    include("$ROOT/app/pages/functions.php");
    include("$ROOT/app/web/SQLLibrary.class.php");
    $LibSQL = new SQLLibrary($connect);*/
    date_default_timezone_set('Europe/Paris');
    //extract($_POST); extract($_GET);
?>