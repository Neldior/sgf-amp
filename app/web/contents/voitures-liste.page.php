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
            
            <?php  $db = connectbd();
                $user = $_SESSION["USER"]["matricule"];
                $req = "SELECT immatriculation, autorisation, dateautorisation, puissanceadmin FROM voiture WHERE idemp LIKE '" . $user . "'";
                $res = $db->prepare($req);
                $res->execute();
                $voitures = $res->fetchAll();
            ?>
            <div class="page has-sidebar-left bg-light height-full" style="margin-bottom: -27px !important">
                <header class="blue accent-3 relative nav-sticky"> <!-- style="background-color: #09709f !important;"-->
                    <div class="container-fluid text-white">
                        <div class="row">
                            <div class="col">
                                <h3 class="my-3"><i class="icon icon-note-important"></i> <strong>Gestion des Voitures</strong></h3>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container-fluid my-3">
                    <div class="d-flex row">
                        <?php if (count($voitures) != 0){ ?>                        
                            <div class="col-md-12">
                                <div class="card mb-3 shadow no-b r-0">
                                    <div class="card-header white">
                                        <div class="row">
                                            <div class="col-sm-11 text-left" style="margin-top: 5px;">
                                                <h4 class="blue-text"><strong>Listing/Consultation</strong></h4>
                                            </div>
                                            <div class="col-sm-1 text-right" style="margin-top: -10px; margin-bottom: -10px">
                                                <a href="#" class="btn-primary btn-fab btn-fab-md fab-right fab-right-top-fixed shadow " onclick="//return fnLoadScreenVoiture('enreg','-1');" data-toggle="modal"  data-target="_#GenericModal" style="cursor:pointer;"><i class="icon-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="margin: 0 -15px">
                                        <div class="table-responsive">

                                            <table id="dtbl-example" class="table table-bordered table-hover">
                                                <thead class="bg-info text-white"> <!-- style="background-color: #082c46 !important;"-->
                                                    <tr class="text-center">
                                                        <th style="width:30%"><strong>Immatriculation</strong></th>
                                                        <th style="width:30%"><strong>Autorisation</strong></th>
                                                        <th style="width:20%"><strong>Date d'autorisation</strong></th>
                                                        <th style="width:20%"><strong>Puissance</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($voitures as $voiture) {
                                                        echo '<tr>';
                                                            echo '<td style="text-align: center">'; 
                                                                echo $voiture["immatriculation"];
                                                            echo '</td>';
                                                            if ($voiture["autorisation"] == TRUE) {
                                                                $statut = "<a href='#' class='btn btn-success r-20'><strong>Autorisée</strong></a>";
                                                            } else {       
                                                               $statut = "<a href='#' class='btn btn-danger r-20'><strong>Non Autorisée</strong></a>";
                                                            }

                                                            echo '<td style="text-align: center">'; 
                                                            echo $statut;
                                                            echo '</td>';
                                                            if ($voiture["autorisation"] == TRUE){
                                                            echo '<td style="text-align: center">'; 
                                                            echo date_english_to_french($voiture["dateautorisation"]);
                                                            echo '</td>';
                                                            } else {
                                                                echo '<td style="text-align: center"></td>'; 
                                                            }
                                                            echo '<td style="text-align: center">'; 
                                                            echo $voiture["puissanceadmin"]." CV";
                                                            echo '</td>';
                                                        echo '</tr>';
                                                    }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-12">
                                <div class="card mb-3 shadow no-b r-0">
                                    <div class="card-header white">
                                        <div class="row">
                                            <div class="col-sm-11 text-left" style="margin-top: 5px;">
                                                <h4 class="blue-text"><strong>Aucun véhicule !</strong></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="margin: 0 -15px">
                                        <div class="text-center">
                                            <img class="user-select-none" src="../../assets/img/1299695.png" title="Voiture" alt="Dessin de voiture">
                                            <p class="h3"> 
                                                <?php echo "Vous n'avez pas demandé à enregistrer de véhicule(s). Veuillez en faire la demande !"; ?> 
                                            </p>
                                            <p class="caption"> 
                                                <?php echo "(Enfin quand l'option sera disponible, en attendant veuillez contacter votre service RH...)"; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>        
                        <?php } ?> 
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

        <script>
            LIEN_AJAX = "<?php echo "controller/processingMissions.php"; ?>";
            function fnLoadScreenVoiture(ecran, id) {
                element = " d'une Voiture";
                titre = ecran==="enreg" ? projetName+"Enregistrement"+element : (ecran==="modif" ? projetName+"Modification"+element : projetName+"Consultation");
                func = 'globalModalProcess();';
                $.ajax({
                    url: LIEN_AJAX, method: "POST",
                    data: {from: 'screen_new_voiture', userId:id},
                    dataType: "text",
                    success: function(response){
                        myModal.find('#modalTitle').html('<strong class="text-white">'+titre+'</strong>');
                        myModal.find('form').attr('onsubmit', 'return '+func);
                        myModal.find('#body_screen').html(response);
                        if (ecran==="consult") {
                            myModal.find('#btnAnnuler').hide();
                            myModal.find('#btnValider').hide();
                            myModal.find('#btnFermer').show();
                        } else {
                            myModal.find('#from').val('save_user');
                            myModal.find('#btnFermer').hide();
                            myModal.find('#btnAnnuler').show();
                            myModal.find('#btnValider').show();
                        }
                        $(".custom-select").select2();
                    }
                });
                return false;
            }

            function globalModalProcess(){
                o = myModal.find('#formModal'); saisieOK = true;
                $.ajax ({
                    url: LIEN_AJAX, method: "POST",
                    data: o.serialize(),
                    success: function(data){
                        waitingBoxUI(false);
                        console.log(data);
                        rspse = data.split('##');
                        if (rspse[0]==="OK") {
                            closeModal();
                            msgBoxUI(rspse[1],"window.location.reload();"); 
                        } else msgBoxUI(rspse[1]);
                    }
                });
                return false;
            }
        </script>
    </body>
</html>