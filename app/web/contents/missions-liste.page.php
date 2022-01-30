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
                <header class="blue accent-3 relative nav-sticky"> 
                    <div class="container-fluid text-white">
                        <div class="row">
                            <div class="col">
                                <h3 class="my-3"><i class="icon icon-note-important"></i> <strong>Gestion des Missions</strong></h3>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container-fluid my-3">
                    <div class="d-flex row">
                        <div class="col-md-12">
                            <form class="form-material" id="form_liste_mission" method="post" action="">
                                <div class="card mb-3 shadow no-b r-0">
                                    <div class="card-header white">
                                        <div class="row">
                                            <?php 
                                                $agent = ""; $nbDonnées = 0;
                                                $tabWaitingData = ['agent' => ""];
                                                foreach ($tabWaitingData as $cle => $element ) {
                                                    if (array_key_exists($cle, $_POST) ) {
                                                        $tabWaitingData[$cle] = $_POST[$cle];
                                                        $nbDonnées++;
                                                    }
                                                }
                                                if ($nbDonnées > 0 && !empty($tabWaitingData)) {
                                                    $agent = $tabWaitingData["agent"];
                                                }
                                                //if (isset($_POST['agent'])) {$agent = $_POST['agent'];} 
                                                try {
                                                    // Connexion à la base de données
                                                    $pdo = connectbd();
                                                    //Recuperation de la Liste des employes
                                                    $reqE = "SELECT * FROM employe ORDER BY nom, prenom";
                                                    $resultE = $pdo->query($reqE);
                                                    
                                                } catch (PDOException $e) {
                                                    die($e->getMessage());
                                                }
                                                
                                                if ($isAdmin) { ?>
                                                <div class="col-sm-3 text-left" style="margin-top: 5px;">
                                                    <h4 class="blue-text"><strong>Liste des Missions</strong></h4>
                                                </div>
                                                <div class="col-sm-1 text-right" style="margin-top: 5px;">
                                                    <h4 class="black-text"><strong>Employé</strong></h4>
                                                </div>
                                                <div class="col-sm-5 text-left">
                                                    <strong>
                                                        <select class="custom-select select2 text-center" name="agent" id="agent" onchange="$('#form_liste_mission').submit();" style="font-weight: bold; font-size: 16px">
                                                            <option value="">Sélectionner un employé pour afficher ses missions</option>
                                                            <?php
                                                                foreach ($resultE as $emp) { ?> 
                                                                    <option value="<?= $emp['idemp']; ?>" <?php if ($agent===$emp['idemp']) echo "selected=\'selected'"; ?>> <?= $emp['nom']." ".$emp['prenom'] ?> </option> 
                                                                <?php } ?>
                                                        </select>
                                                    </strong>
                                                </div>
                                                <div class="col-sm-3 text-right" style="margin-top: -10px; margin-bottom: -10px">
                                                    <a href="#" class="btn-primary btn-fab btn-fab-md fab-right fab-right-top-fixed shadow " ><i class="icon-add"></i></a> <!--onclick="return fnLoadScreenMission('enreg','-1');" data-toggle="modal"  data-target="#GenericModal" style="cursor:pointer;"-->
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-sm-11 text-left" style="margin-top: 5px;">
                                                    <h4 class="blue-text"><strong>Liste des Missions</strong></h4>
                                                </div>
                                                <div class="col-sm-1 text-right" style="margin-top: -10px; margin-bottom: -10px">
                                                    <a href="missions-new.page.php" class="btn-primary btn-fab btn-fab-md fab-right fab-right-top-fixed shadow " ><i class="icon-add"></i></a> <!--onclick="return fnLoadScreenMission('enreg','-1');" data-toggle="modal"  data-target="#GenericModal" style="cursor:pointer;"-->
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!--récuperation Liste des missions-->
                                    <?php  
                                        //Déterminer l'employé dont on veut afficher les missions
                                        $employe = !$isAdmin ? $U['matricule'] : (!empty($agent) ? $agent : "%"); //"US80001005"; 
                                        try {
                                           //Recuperation de la liste des missions
                                           $reqS = "SELECT m.*, z.libellezone FROM mission m, zone_geographique z WHERE m.codezone = z.codezone AND m.idemp LIKE :idemploye ORDER BY m.idmission";
                                           $result = $pdo->prepare($reqS);
                                           //$result->bindValue(':idemploye', $employe);
                                           $result->execute([':idemploye'=> $employe]);
                                        } catch (PDOException $e) {
                                             die($e->getMessage());
                                        }

                                    ?>
                                    <div class="card-body" style="margin: 0 -15px">
                                        <div class="table-responsive">
                                            <table id="dtbl-example" class="table table-bordered table-hover">
                                                <thead class="bg-info text-white"> 
                                                    <tr class="text-center bolder">
                                                        <th style="width: 5%; display: none"><strong>N°</strong></th>
                                                        <th style="width: 5%"><strong>Numéro</strong></th>
                                                        <th style="width: 15%"><strong>Date Début</strong></th>
                                                        <th style="width: 15%"><strong>Date Fin</strong></th>
                                                        <th style="width: 20%"><strong>Lieu</strong></th>
                                                        <th style="width: 15%"><strong>Demande d'Avance</strong></th>
                                                        <th style="width: 15%"><strong>Demande de Remboursement</strong></th>
                                                        <th style="width: 10%"><strong>Actions</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $i = 0; 
                                                        foreach ($result as $ligne) { $i++;
                                                            extract($ligne); 
                                                            $etatDA=""; $etatDR="";
                                                            //Recuperation de l'état des demandes d'avance et de remboursement
                                                            $reqDA = "SELECT da.*, i.libelleetat FROM demande_avance da, etat_avcmt_avance e, index_etat_avancement i WHERE da.iddmdeavce=e.iddmdeavce AND e.codeetat = i.codeetat AND da.idmission=:idmission ORDER BY e.datevaletat DESC LIMIT 1";
                                                            $stmtA = $pdo->prepare($reqDA);
                                                            $resultDA = $stmtA->execute([':idmission'=>$idmission]);
                                                            $DA = $stmtA->fetch(PDO::FETCH_ASSOC); 
                                                            if (!empty($DA)) {$etatDA = $DA['libelleetat'];}
                                                            
                                                            $reqDR = "SELECT dr.*, i.libelleetat FROM demande_remboursement dr, etat_avcmt_rbrsmt e, index_etat_avancement i WHERE dr.iddmderbsmt=e.iddmderbsmt AND e.codeetat = i.codeetat AND dr.idmission=:idmission ORDER BY e.datevaletat DESC LIMIT 1";
                                                            $stmtR = $pdo->prepare($reqDR);
                                                            $resultDR = $stmtR->execute([':idmission'=>$idmission]);
                                                            $DR = $stmtR->fetch(PDO::FETCH_ASSOC); 
                                                            if (!empty($DR)) {$etatDR = $DR['libelleetat'];}
                                                           
                                                    ?>
                                                    <tr class='text-black'>
                                                        <td style="text-align: center; display: none"><?= $i; ?></td>
                                                        <td style="text-align: center"><?= $idmission; ?></td>
                                                        <td style="text-align: center"><?= date_english_with_hour_to_french($dateheuredebut); ?></td>
                                                        <td style="text-align: center"><?= date_english_with_hour_to_french($dateheurefin); ?></td>
                                                        <td><?= $adresse.", ".$codepostal.", ".$ville; ?></td>
                                                        <td style="text-align: center"><?= mb_strtoupper($etatDA); ?></td>
                                                        <td style="text-align: center"><?= mb_strtoupper($etatDR); ?></td>
                                                        <td class="center-text" style="text-align: center !important;">
                                                            <!--<a href="#" class="btn btn-success btn-fab shadow bg-default" title="Consulter Détails" onclick="//fnLoadScreenDetailsMission(</?= $idmission; ?>);"><i class="s-24 icon-eye"></i></a>-->
                                                            <a href="missions-view.page.php?m=consul&id=<?= $idmission; ?>" class="btn-fab shadow btn-primary bg-default" title="Consulter Détails" onclick="//return fnLoadScreenMission('consult',<?/= $idmission; ?>);"><i class="s-24 icon-eye"></i></a>
                                                            <?php if($isAdmin) { ?> <a href="#" class="btn btn-danger btn-fab shadow bg-red" title="Supprimer" onclick=""><i class="s-24 icon-delete"></i></a> <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12" id="details_mission"></div>
                    </div>
                </div>
            </div>
            <!--Footer Page-->
            <?php require_once('../../includes/footer-page.php'); ?>
            <!-- Right Sidebar Start-->
            

            <!-- Right Sidebar Start-->
            <?php require_once('../../includes/sidebar-right.php'); ?>
            <!-- Right Sidebar End-->

            <div class="control-sidebar-bg shadow white fixed"></div>
        </div>
        <?php require_once('../../includes/footer.php'); ?>
        <script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)</script>
        <script language="JavaScript" type="text/javascript">
            function fnLoadScreenMission(ecran, id) {
                element = " d'une Mission";
                titre = ecran==="enreg" ? projetName+"Enregistrement"+element : (ecran==="modif" ? projetName+"Modification"+element : projetName+"Consultation"+element);
                func = 'globalModalProcess();';
                $.ajax({
                    url: "<?php echo "../controller/processingMissions.php"; ?>", method: "POST",
                    data: {from: 'screen_new', userId:id},
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
            
            function fnLoadScreenDetailsMission(id) {
                $.ajax({
                    url: "<?php echo "../controller/processingMissions.php"; ?>", method: "POST",
                    method: "POST",
                    data: {from:'afficher_details_mission',mission:id},
                    dataType: "text",
                    success: function(data){
                        $('#details_mission').html(data);
                    }
                });
            }

            function globalModalProcess(){
                o = myModal.find('#formModal'); saisieOK = true;
                var mat = o.find('#matricule'), profil = document.getElementById("profil"), nom = o.find('#nom'),
                prenom = o.find('#prenom'), contact = o.find('#contact'), email = o.find('#email');
                //if (mat.val()==="") {msgBoxUI("Veuillez saisir le matricule de l'Utilisateur !", "mat.focus(); "); return false;}
                waitingBoxUI(true);
                //alert('Matricule : '+mat.val()+' -Profil : '+profil.value+' -Nom : '+nom.val()+' -Prenom : '+prenom.val()+' -Contact : '+contact.val()+' -Email : '+email.val());
                if (mat.val()==='' && profil.value==='' && nom.val()==='' && prenom.val()==='' && contact.val()==='' && email.val()==='') saisieOK = false;
                if (saisieOK) {//{msgBoxUI("Un des champs obligatoires du formulaire n'est pas renseigné !"); return false;}
                //else {
                    $.ajax ({
                        url: "<?php echo "../controller/processingMissions.php"; ?>", method: "POST",
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
                }
                return false;
            }
            jQuery(function(){
                jQuery('#date_timepicker_start').datetimepicker({
                 format:'Y/m/d',
                 onShow:function( ct ){
                  this.setOptions({
                   maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
                  })
                 },
                 timepicker:false
                });
                jQuery('#date_timepicker_end').datetimepicker({
                 format:'Y/m/d',
                 onShow:function( ct ){
                  this.setOptions({
                   minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false
                  })
                 },
                 timepicker:false
                });
               });
        </script>
    </body>
</html>