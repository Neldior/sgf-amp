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
            <?php
                try {
                    $pdo = connectbd();
                    //Recuperation de la Liste des zones géo
                    $reqZ = "SELECT * FROM zone_geographique ORDER BY codezone";
                    $resultZ = $pdo->query($reqZ);
                    
                    //Recuperation de la Liste des types d'activités
                    $reqA = "SELECT * FROM type_activite ORDER BY codeactiv";
                    $resultA = $pdo->query($reqA);
                    
                    //Recuperation de la Liste des Clients
                    $reqC = "SELECT * FROM client ORDER BY nomclient";
                    $resultC = $pdo->query($reqC);
                    
                } catch (PDOException $e) {
                    die('Erreur Chargement Liste Zones ! : ' . $e->getMessage());
                }
            ?>
            <div class="page has-sidebar-left bg-light height-full" style="margin-bottom: -27px !important">
                <header class="blue accent-3 relative nav-sticky"> <!-- style="background-color: #09709f !important;"-->
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
                            <form class="form-material" id="form_mission" method="post" action="#" onsubmit="return fnSaveMission();" enctype="multipart/form-data">
                                <input type="hidden" name="from" id="from2" value="save_mission">
                                <input type="hidden" name="todo" id="todo" value="new">
                                <div class="card mb-3 shadow no-b r-0">
                                    <div class="card-header white">
                                        <div class="row">
                                            <div class="col-sm-12 text-left" style="margin-top: 5px;">
                                                <h4 class="blue-text"><strong>Enregistrement d'une Mission</strong></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="margin: -10px 20px -30px 20px">
                                        <div class="row" style="margin-bottom: -10px !important">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="datedebut" class="col-form-label text-black">Date Début Prévue <b class="bolder text-red"> <sup>*</sup></b></label>
                                                            <input type="text" id="datedebut" name="datedebut" class="date-time-picker form-control" required placeholder="AAAA/MM/JJ HH:MM"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="datefin" class="col-form-label text-black">Date Fin Prévue<b class="bolder text-red"> <sup>*</sup></b></label>
                                                            <input type="text" id="datefin" name="datefin" class="date-time-picker form-control" required placeholder="AAAA/MM/JJ HH:MM"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="datedepart" class="col-form-label text-black">Date Départ <b class="text-red"> (Si différente de la date de début)</b></label>
                                                            <input type="text" id="datedepart" name="datedepart" class="date-time-picker form-control" placeholder="AAAA/MM/JJ HH:MM"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="dateretour" class="col-form-label text-black">Date Retour <b class="text-red"> (Si différente de la date de fin) </b></label>
                                                            <input type="text" id="dateretour" name="dateretour" class="date-time-picker form-control" placeholder="AAAA/MM/JJ HH:MM"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: -10px !important">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="referenceom" class="col-form-label text-black">Référenes Ordre de Mission <sup class="text-black">*</sup></label>
                                                            <input type="text" id="referenceom" name="referenceom" class="form-control" required autocomplete="on" placeholder="Numéro de l'OM"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="fichierom" class="col-form-label text-black">Fichier de l'Ordre de Mission <sup class="text-black">*</sup></label>
                                                            <input type="file" id="fichierom" name="fichierom" class="form-control" required="" accept="image/*,.pdf">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line">
                                                            <label for="typeactivite" class="col-form-label text-black">Type d'Activité <sup class="text-black">*</sup></label>
                                                            <strong>
                                                                <select id="typeactivite" name="typeactivite" class="custom-select select2" onchange="" required>
                                                                    <option value="">Sélectionner une Activité</option>
                                                                    <?php
                                                                        foreach ($resultA as $activ) { ?> 
                                                                            <option value="<?= $activ['codeactiv']; ?>" > <?= $activ['libelleactiv'] ?> </option> 
                                                                        <?php }
                                                                    ?>
                                                                </select>
                                                            </strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line">
                                                            <label for="zone" class="col-form-label text-black">Zone Géographique <sup class="text-black">*</sup></label>
                                                            <strong>
                                                                <select id="zone" name="zone" class="custom-select select2" onchange="" required>
                                                                    <option value="">Sélectionner une Zone</option>
                                                                    <?php
                                                                        foreach ($resultZ as $zone) { ?> 
                                                                            <option value="<?= $zone['codezone']; ?>" > <?= $zone['libellezone'] ?> </option> 
                                                                        <?php }
                                                                    ?>
                                                                </select>
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: -10px !important">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="adresse" class="col-form-label text-black">Adresse/Lieu<sup class="text-black">*</sup></label>
                                                            <input type="text" id="adresse" name="adresse" class="form-control" value="" required autocomplete="on" placeholder="Lieu de la mission"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="codepostal" class="col-form-label text-black">Code Postal<sup class="text-black">*</sup></label>
                                                            <input type="number" id="codepostal" name="codepostal" class="form-control" value="" required autocomplete="on"  placeholder="Ex : 31300"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line">
                                                            <label for="ville" class="col-form-label text-black">Ville <sup class="text-black">*</sup></label>
                                                            <input type="text" id="ville" name="ville" class="form-control" value="" required autocomplete="on" placeholder="Ville du Lieu de la mission"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line">
                                                            <label for="client" class="col-form-label text-black">Client </label>
                                                            <strong>
                                                                <select id="client" name="client" class="custom-select select2" onchange="">
                                                                    <option value="">Sélectionner un Client</option>
                                                                    <?php
                                                                        foreach ($resultC as $client) { ?> 
                                                                            <option value="<?= $client['numsiret']; ?>" > <?= $client['numsiret']." - ".$client['nomclient'] ?> </option> 
                                                                        <?php }
                                                                    ?>
                                                                </select>
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-body text-right" style="margin-top: -20px; margin-right: 15px">
                                        <a href="missions-liste.page.php" class="btn btn-secondary bg-indigo waves-effect btn-lg right bolder"><i class="icon-arrow_back mr-2"></i>Retour à la Liste</a>
                                        <button type="reset" class="btn btn-danger bg-red waves-effect btn-lg right bolder"><i class="icon-refresh mr-2"></i>Réinitialiser</button>
                                        <button type="submit" class="btn btn-success bg-green waves-effect btn-lg right bolder"><i class="icon-save mr-2"></i>Enregistrer</button>
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
        function fnSaveMission(){
            o = $('#form_mission'); 
            debut = o.find('#datedebut'); fin = o.find('#datefin'); depart = o.find('#datedepart'); retour = o.find('#dateretour'); 
            if($.trim(debut.val())!=="" && $.trim(fin.val())!=="") {
                if($.trim(debut.val())===$.trim(fin.val())) {msgBoxUI("Les dates de début et de fin de la mission ne doivent pas être identiques! Veuillez vérifier les heures.", "fin.focus();"); return false;}
                if($.trim(debut.val()) > $.trim(fin.val())) {msgBoxUI("La date de début ne doit pas être postérieure à celle de fin! Veuillez revoir vos saisies.", "fin.focus();"); return false;}
            }
            if($.trim(depart.val())!=="" && $.trim(retour.val())!=="") {
                if($.trim(depart.val())===$.trim(retour.val())) {msgBoxUI("Les dates depart et retour ne doivent pas être identiques! veuillez vérifier les heures.", "retour.focus();"); return false;}
                if($.trim(depart.val()) > $.trim(retour.val())) {msgBoxUI("La date de depart ne doit pas être postérieure à celle de retour! Veuillez revoir vos saisies.", "retour.focus();"); return false;}
            }
            var formData = new FormData(o[0]);
            formData.append('fichierom', o.find('#fichierom')[0].files[0]);
            $.ajax ({
                url: "<?= "../controller/processingMissions.php"; ?>", method: "POST",
                data: formData, //o.serialize(),
                async: false,
                success: function(data){
                    console.log(data);
                    rspse = data.split('##');
                    if (rspse[0]==="OK") {
                        msgBoxUI(rspse[1], "window.location.reload();"); 
                        //window.location.href='missions-liste.page.php';
                    } else msgBoxUI(rspse[1]);
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        }
        </script>
    </body>
</html>