<?php 
    require_once('connect_db.php'); 
    require_once('functions.php'); 
    session_start();
    
    //Récuperer le temps et déterminer si bonjour ou bonsoir
    $temps = localtime();
    $sec = $temps[0];
    $min = $temps[1];
    $heur = $temps[2] - 1;
    $salut = $heur < 12 ? "Bonjour " : "Bonsoir ";
    //Récuperer les infos de l'user connecté
    $U=[];
    $avataruser=""; $nomUser="Inconnu"; $civilite="";
    if (isset($_SESSION['USER'])) { 
        $U=$_SESSION['USER'];
        $civilite = $U['civilite'];
        $nomUser = mb_convert_case($U['prenomuser'], MB_CASE_TITLE, "UTF-8")." ".mb_convert_case($U['nomuser'], MB_CASE_UPPER, "UTF-8");
        $avataruser = $civilite==="Mr"?'u8.png':'u2.png';
    }
    else {
        header('location:../../../index.php');
    }
    $isAdmin = !in_array($U['profil'],['P1','P2','P3']);
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../assets/img/basic/favicon.ico" type="image/x-icon">
    <title>SGF-AMP | Système de Gestion des Frais de Déplacements (AMP)</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/app.css">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="../../assets/cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }
        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
    <script>(function(w,d,u){w.readyQ=[];w.bindReadyQ=[];function p(x,y){if(x=="ready"){w.bindReadyQ.push(y);}else{w.readyQ.push(x);}};var a={ready:p,bind:p};w.$=w.jQuery=function(f){if(f===d||f===u){return a}else{p(f)}}})(window,document)</script>
</head>