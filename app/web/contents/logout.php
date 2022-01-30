<?php
    require_once("../controller/_header.inc.php");
    session_unset();// On détruit les variables de notre session
    session_destroy ();// On détruit notre session
    header ('location: ../../../index.php'); // On redirige le visiteur vers la page de connexion
  
?>