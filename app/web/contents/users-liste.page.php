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
                                <h3 class="my-3"><i class="icon icon-note-important"></i> <strong>Gestion des Employés/Utilisateurs</strong></h3>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container-fluid my-3">
                    <div class="d-flex row">
                        <div class="col-md-12">
                            <form class="form-material" id="form_liste_employes" method="post" action="">
                                <div class="card mb-3 shadow no-b r-0">
                                    <div class="card-header white">
                                        <div class="row">
                                            <?php 
                                            $profil = ""; $nbElmts = 0;
                                            $WData = ['profil' => ""];
                                            foreach ($WData as $cle => $element ) {
                                                if (array_key_exists($cle, $_POST) ) {
                                                    $WData[$cle] = $_POST[$cle];
                                                    $nbElmts++;
                                                }
                                            }
                                            if ($nbElmts > 0 && !empty($WData)) {
                                                $profil = $WData["profil"];
                                            }
                                            try {
                                                // Connexion à la base de données
                                                $pdo = connectbd();
                                                //Recuperation de la Liste des employes
                                                $reqP = "SELECT * FROM profil ORDER BY codeprofil";
                                                $resultP = $pdo->query($reqP);

                                            } catch (PDOException $e) {
                                                die($e->getMessage());
                                            }
                                            ?>
                                            <div class="col-sm-3 text-left" style="margin-top: 5px;">
                                                <h4 class="blue-text"><strong>Liste des Employés</strong></h4>
                                            </div>
                                            <div class="col-sm-1 text-right" style="margin-top: 5px;">
                                                <h4 class="black-text"><strong>Profil</strong></h4>
                                            </div>
                                            <div class="col-sm-5 text-left">
                                                <strong>
                                                    <select class="custom-select select2 text-center" name="profil" id="profil" onchange="$('#form_liste_employes').submit();" style="font-weight: bold; font-size: 16px">
                                                        <option value="">Sélectionner un profil</option>
                                                        <?php
                                                            foreach ($resultP as $pro) { ?> 
                                                        <option value="<?= $pro['codeprofil']; ?>" <?php if ($profil===$pro['codeprofil']) {echo "selected=\'selected'"; }?>> <?= mb_strtoupper($pro['libelleprofil']) ?> </option> 
                                                            <?php } ?>
                                                    </select>
                                                </strong>
                                            </div>
                                            <div class="col-sm-3 text-right" style="margin-top: -10px; margin-bottom: -10px">
                                                <a href="#" class="btn-primary btn-fab btn-fab-md fab-right fab-right-top-fixed shadow " onclick="return fnLoadScreenUser('enreg','-1');" data-toggle="modal"  data-target="#GenericModal" style="cursor:pointer;"><i class="icon-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--récuperation Liste des employés-->
                                    <?php  
                                        //Déterminer l'employé dont on veut afficher les missions
                                        $prof = !empty($profil) ? $profil : "%"; 
                                        try {
                                           //Recuperation de la liste des missions
                                           /*$reqE = "SELECT e.*, p.libelleprofil, s.libelleservice, u.libelleusine FROM employe e, profil p, service s, usine u "
                                                   . "WHERE e.codeprofil = p.codeprofil AND e.idservice = s.idservice AND s.codeusine = u.codeusine AND e.codeprofil LIKE :codeprofil ORDER BY e.nom, e.prenom";*/
                                           $reqE = "SELECT e.*, p.libelleprofil FROM employe e, profil p WHERE e.codeprofil = p.codeprofil AND e.codeprofil LIKE :codeprofil ORDER BY e.nom, e.prenom";
                                           $result = $pdo->prepare($reqE);
                                           //$result->bindValue(':idemploye', $employe);
                                           $result->execute([':codeprofil'=> $prof]);
                                        } catch (PDOException $e) {
                                             die($e->getMessage());
                                        }

                                    ?>
                                    <div class="card-body" style="margin: 0 -15px">
                                        <div class="table-responsive">
                                            <table id="dtbl-example" class="table table-bordered table-hover">
                                                <thead class="bg-info text-white"> <!-- style="background-color: #082c46 !important;"-->
                                                    <tr class="text-center">
                                                        <th style="width: 10%"><strong>Matricule</strong></th>
                                                        <th style="width: 5%"><strong>Civilité</strong></th>
                                                        <th style="width: 15%"><strong>Nom & Prénoms</strong></th>
                                                        <th style="width: 20%"><strong>Courriel</strong></th>
                                                        <th style="width: 20%"><strong>Service/Usine</strong></th>
                                                        <th style="width: 15%"><strong>Profil</strong></th>
                                                        <th style="width: 15%"><strong>Actions</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        foreach ($result as $ligne) { 
                                                            extract($ligne); 
                                                            $libserv = "";
                                                            if (!empty($idservice)) {
                                                                //Recuperation du libellé du service
                                                                $reqS = "SELECT s.libelleservice, u.libelleusine FROM service s, usine u WHERE s.codeusine = u.codeusine AND s.idservice=:service";
                                                                $stmtS = $pdo->prepare($reqS);
                                                                $resultS = $stmtS->execute([':service'=>$idservice]);
                                                                $serv = $stmtS->fetch(PDO::FETCH_ASSOC);    
                                                                if (!empty($serv)) {$libserv = $serv['libelleservice']." (".$serv['libelleusine'].")"; }
                                                            }
                                                    ?>
                                                    <tr class='text-black'>
                                                        <td style="text-align: center;"><?= $idemp; ?></td>
                                                        <td style="text-align: center;"><?= $civilite; ?></td>
                                                        <td><?= mb_convert_case($nom, MB_CASE_UPPER, "UTF-8")." ".mb_convert_case($prenom, MB_CASE_TITLE, "UTF-8"); ?></td>
                                                        <td style="text-align: center;"><?= $courriel; ?></td>
                                                        <td style="text-align: center;"><?= $idservice; //-$libserv; ?></td>
                                                        <td style="text-align: center;"><?= mb_strtoupper($libelleprofil); ?></td>
                                                        <td class="center-text" style="text-align: center !important;">
                                                            <a href="#" class="btn-fab shadow btn-primary" title="Modifier" onclick="return fnLoadScreenUser('modif','1');" data-toggle="modal"  data-target="#GenericModal" style="cursor:pointer;"><i class="s-24 icon-pencil"></i></a>
                                                            <a href="#" class="btn btn-success btn-fab shadow" style="background-color: #2bbbad" title="Habilitations" onclick=""><i class="s-24 icon-lock4"></i></a>
                                                            <a href="#" class="btn btn-danger btn-fab shadow" title="Supprimer" onclick=""><i class="s-24 icon-delete"></i></a>
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
            function fnLoadScreenUser(ecran, id) {
                element = " d'un Utilisateur";
                titre = ecran==="enreg" ? projetName+"Enregistrement"+element : (ecran==="modif" ? projetName+"Modification"+element : projetName+"Consultation");
                func = 'globalModalProcess();';
                $.ajax({
                    url: "<?php echo "../controller/processingAdmin.php"; ?>", method: "POST",
                    data: {from: 'screen_new_user', userId:id},
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
                var mat = o.find('#matricule'), profil = document.getElementById("profil"), nom = o.find('#nom'),
                prenom = o.find('#prenom'), contact = o.find('#contact'), email = o.find('#email');
                //if (mat.val()==="") {msgBoxUI("Veuillez saisir le matricule de l'Utilisateur !", "mat.focus(); "); return false;}
                waitingBoxUI(true);
                //alert('Matricule : '+mat.val()+' -Profil : '+profil.value+' -Nom : '+nom.val()+' -Prenom : '+prenom.val()+' -Contact : '+contact.val()+' -Email : '+email.val());
                if (mat.val()==='' && profil.value==='' && nom.val()==='' && prenom.val()==='' && contact.val()==='' && email.val()==='') saisieOK = false;
                if (saisieOK) {//{msgBoxUI("Un des champs obligatoires du formulaire n'est pas renseigné !"); return false;}
                //else {
                    $.ajax ({
                        url: "<?php echo "controller/processingAdmin.php"; ?>", method: "POST",
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
        </script>
    </body>
</html>