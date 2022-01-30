<!DOCTYPE html>
<html lang="fr">
    <?php require_once('../../includes/header.php'); ?>
    <body class="light">
        <!-- Pre loader -->
        <?php require_once('../../includes/preloader.php'); ?>
        <div id="app">
            <!--Sidebar Left Start-->
            <?php require_once('../../includes/sidebar-left.php'); ?>
            <!--Sidebar Left End-->

            <!--Navbar Start-->
            <?php require_once('../../includes/navbar.php'); ?>
            <!--Navbar End-->

            <div class="page has-sidebar-left bg-light height-full" style="margin-bottom: -27px !important">
                <header class="blue accent-3 relative nav-sticky"> <!-- style="background-color: #09709f !important;"-->
                    <div class="container-fluid text-white">
                        <div class="row">
                            <div class="col">
                                <h3 class="my-3"><i class="icon icon-note-important"></i> <strong>Accueil</strong></h3>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container-fluid my-3">
                    <div class="d-flex row">
                        <div class="col-md-12">
                            <!-- Basic Validation -->
                            <div class="card mb-3 shadow no-b r-0">
                                <div class="card-header white"><h4 class="blue-text"><strong>Bienvenue </strong></h4></div>
                                <div class="card-body black-text text-center" style="margin: 0 30px !important;" >
                                    <div class="row">
                                        <p class="font-weight-normal" style="text-align: center !important; font-size: 16px">
                                            Bienvenue sur SGF-AMP, l'application de gestion des frais de déplacement des employés de la société AMP.
                                        </p>
                                        <p class="font-weight-normal" style="text-align: center; font-size: 16px">
                                            Cette application permet aux employés de soumettre des demandes d'avance et/ou de remboursement des frais 
                                            engagés dans le cadre des missions qu'ils effectuent au quotidien.
                                        </p>
                                    </div>
                                    <div class="row" style="margin-top: 30px">
                                        <div class="col-sm-12 text-center" style="margin-top: -5px; margin-bottom: -5px"> 
                                            <img class="" src="../../assets/img/note-de-frais.jpg" alt="Demande d'Avance" title="Gestion des Frais de Déplacement"/>
                                        </div>
                                    </div>                      
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Footer Page-->
            <?php require_once('../../includes/footer-page.php'); ?>
            
            <!-- Right Sidebar Start-->
            <?php require_once('../../includes/sidebar-right.php'); ?>
            <!-- Right Sidebar End-->

            <div class="control-sidebar-bg shadow white fixed"></div>
        </div>
        
        <?php require_once('../../includes/footer.php'); ?>
    </body>
</html>