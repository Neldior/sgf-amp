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
                    $reqM = "SELECT * FROM mission WHERE idemp=:idemp AND idmission NOT IN (SELECT idmission FROM demande_avance) ORDER BY idmission";
                    $stmtM= $pdo->prepare($reqM);
                    $resultM = $stmtM->execute([':idemp'=>$U['matricule']]);
                    $missions = $stmtM->fetchAll();
                    
                } catch (PDOException $e) {
                    die('Erreur Chargement Liste Combos ! : ' . $e->getMessage());
                }
            ?>
            <div class="page has-sidebar-left bg-light height-full" style="margin-bottom: -27px !important">
                <header class="blue accent-3 relative nav-sticky"> <!-- style="background-color: #09709f !important;"-->
                    <div class="container-fluid text-white">
                        <div class="row">
                            <div class="col">
                                <h3 class="my-3"><i class="icon icon-note-important"></i> <strong>Gestion des Demandes d'Avance</strong></h3>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container-fluid my-3">
                    <div class="d-flex row">
                        <div class="col-md-12">
                            <form class="form-material" id="form_dmde_avance" method="post" action="#" onsubmit="return fnSaveDmdeAvance();" enctype="multipart/form-data">
                                <input type="hidden" name="from" id="from2" value="save_demande">
                                <input type="hidden" name="todo" id="todo" value="new_dmde_avance">
                                <div class="card mb-3 shadow no-b r-0">
                                    <div class="card-header white">
                                        <div class="row">
                                            <div class="col-sm-12 text-left" style="margin-top: 5px;">
                                                <h4 class="blue-text"><strong>Enregistrement d'une Demande d'avance</strong></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="margin: -10px 20px 0 20px">
                                        <div class="row" style="margin-bottom: -10px !important">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3 form-group form-float">
                                                        <label for="idmission" class="col-form-label text-black">Mission rattachée <b class="bolder text-red"> <sup>*</sup></b></label>
                                                        <strong>
                                                            <select id="idmission" name="idmission" class="custom-select select2" onchange="fnCheckInfoMission(this.value);" required>
                                                                <option value="">Sélectionner une mission</option>
                                                                <?php
                                                                    foreach ($missions as $miss) { ?> 
                                                                <option value="<?= $miss['idmission']; ?>" > <?= "Mission N° ".$miss['idmission']." déroulée à ".mb_convert_case($miss['ville'], MB_CASE_UPPER, "UTF-8")." du ".date_english_to_french($miss['dateheuredebut']). " au ".date_english_to_french($miss['dateheurefin']) ?> </option> 
                                                                    <?php }
                                                                ?>
                                                            </select>
                                                        </strong>
                                                        <input type="hidden" id="codezone" name="codezone" class="form-control" value="" />
                                                        <input type="hidden" id="tarifnuitee" name="tarifnuitee" class="form-control" value="0" />
                                                    </div>
                                                    <div class="col-md-2 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="datedmde" class="col-form-label text-black">Date Demande<b class="bolder text-red"> <sup>*</sup></b></label>
                                                            <input type="text" id="datedmde0" name="datedmde0" class="date-time-picker form-control" required placeholder="AAAA/MM/JJ HH:MM" value="<?= date('Y-m-d H:i:s'); ?>" disabled/>
                                                            <input type="hidden" id="datedmde" name="datedmde" class="date-time-picker form-control" required placeholder="AAAA/MM/JJ HH:MM" value="<?= date('Y-m-d H:i:s'); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="nbrenuitees" class="col-form-label text-black">Nombre de Nuitées <b class="bolder text-red"> <sup>*</sup></b></label>
                                                            <input type="number" id="nbrenuitees" name="nbrenuitees" class="form-control" placeholder="0" value="" required="" onchange=""/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="montant" class="col-form-label text-black">Montant Demandé <b class="bolder text-red"> <sup>*</sup></b></label>
                                                            <input type="number" id="montantdemande" name="montantdemande" class="form-control" placeholder="0" required="" value="" step="any"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card mb-3 shadow no-b r-0">
                                            <div class="card-header white">
                                                <div class="row">
                                                    <div class="col-sm-12 text-left" style="margin-top: 5px;">
                                                        <h4 class="blue-text"><strong>Détails des Frais associés</strong></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="detailContent" class="mt-20 mbn ml5 mb20" style="margin: 5px">
                                                <div id="entete" class="row" style="text-align: center;">
                                                    <div class="col-sm-2">
                                                        <label for="typologie" class="col-lg-12 control-label"><b class="text-black">Typologie</b></label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="naturefrais" class="col-lg-12 control-label"><b class="text-black">Nature</b></label>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <label for="montant" class="col-lg-12 control-label"><b class="text-black">Montant</b></label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="justif" class="col-lg-12 control-label"><b style="color:black">Fichier du Justificatif</b></label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="libellejustif" class="col-lg-12 control-label"><b style="color:black">Libellé du Justificatif</b></label>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <a href="" onclick="click=true; return addLine_Frais();" class="btn btn-success bg-default bolder" style="padding: 4px 8px; margin-right: 10px !important"><span class="icon-add"> </span></a>
                                                    </div>
                                                </div>
                                                <div id="corps" class="col-sm-12" style="margin: 10px"></div>
                                            </div>
                                            <div class="card-footer bg-default">
                                                <div class="row">
                                                    <div class="col-sm-2 text-left" id="totavance" style="margin-top: 5px;"> &nbsp;</div>
                                                    <div class="col-sm-2 text-right">
                                                        <h5 class="white-text bolder"><strong> Total Détails Frais : </strong></h5>
                                                    </div>
                                                    <div class="col-sm-1 text-right" id="totdetail">
                                                        <h5 class="white-text bolder"><strong> 0 &euro; </strong></h5>
                                                    </div>
                                                    <div class="col-sm-7"> &nbsp; </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="card-body bg-white text-right" style="margin-top: -20px; margin-right: 15px">
                                    <button type="reset" class="btn btn-danger bg-red waves-effect btn-lg right bolder"><i class="icon-refresh mr-2"></i>Réinitialiser</button>
                                    <button type="submit" class="btn btn-success bg-green waves-effect btn-lg right bolder"><i class="icon-save mr-2"></i>Enregistrer</button>
                                </div>
                                </br>
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
    
    <div id="selectContent" style="display: none">
        <option value="">Selectionnez une Typologie </option>
        <?php
            //récuperer la liste des typologies pour charger la combo
            $reqT = "SELECT * FROM typologie_frais_reel ORDER BY codetypo";
            $stmtT = $pdo->prepare($reqT);
            $resultT = $stmtT->execute();
            $typos = $stmtT->fetchAll();
            foreach ($typos as $typo) { ?> 
                <option value="<?= $typo['codetypo']; ?>" > <?= $typo['libelletypo'] ?> </option> 
            <?php }
        ?>
    </div>
    <script>
        var line = 0; lineAll = 0;
        addLine_Frais();
        var o = $('#form_dmde_avance'),
        LIEN_AJAX="<?= "../controller/processingMissions.php"; ?>";

        function fnElementExistant(elmt, rang, taille) {
            nbtrouve = 0;
            for (j=1; j<=taille; j++) {
                if (j !== rang) {
                    nat2 = o.find("#line" + j).find("#naturefrais" + j);
                    if (nat2.val()=== elmt) nbtrouve++;
                }
            }
            return (nbtrouve !== 0);
        }
    
        function addLine_Frais(){
            line++; lineAll++;
            content = '<div id="line'+lineAll+'" class="row form-line mt-auto border-bottom" style="padding: 3px 0 0 10px;">';
            content += '<div class="col-sm-2 text-left"><select id="typologie'+lineAll+'" name="typologie[]" style="font-size: 16px !important" class="custom-select select2 text-black" required onchange=""></select></div>';
            content += '<div class="col-sm-2 text-left"><input type="text" class="form-control" id="naturefrais'+lineAll+'" name="naturefrais[]" placeholder="Nature du frais" required onBlur="this.value=this.value.toUpperCase();" autocomplete="on"/></div>';
            content += '<div class="col-sm-1 text-right"><input style="text-align: center" type="number" class="form-control" id="montant'+lineAll+'" name="montant[]" placeholder="0" min="0" value="0" required onchange="fnCalcTotalDetails();" /></div>';
            content += '<div class="col-sm-3 text-left"><input type="file" id="fichierjustif'+lineAll+'" name="fichierjustif'+lineAll+'" class="form-control" required></div>';
            content += '<div class="col-sm-3 text-left"><input type="text" class="form-control" id="libellejustif'+lineAll+'" name="libellejustif[]" placeholder="Libellé du Justificatif" required onBlur="this.value=this.value.toUpperCase();" autocomplete="on" /></div>';
            content += '<div class="col-sm-1" style="text-align: center; padding: 4px 0;">';
            content += '<a href="" onclick="return removeLine_Frais(' + lineAll + ');" class="btn btn-danger" style="padding: 4px 8px; margin-right: 2px"><span class="icon-minus"> </span></a>';
            content += '</div></div>';
            with($("#detailContent #corps")){
                append(content);
                find("#line"+lineAll+" #typologie"+lineAll).html($("#selectContent").html());
                find("#line"+lineAll+"#typologie"+lineAll).val("");
                find("#line"+lineAll+"#naturefrais"+lineAll).focus();
            }
            $(".custom-select").select2({dropdownParent: $('#form_dmde_avance'), theme: "classic"});
            return false;
        }

        function removeLine_Frais(id){
            if((line - 1) === 0){msgBoxUI("Vous ne pouvez pas supprimer toutes les lignes.");return false;}
            if ($("#detailContent").find("#line" + id).slideUp(500, function(){$(this).remove();})) {line--; lineAll--; }
            return false;
        }
    
        function fnSaveDmdeAvance(){
            var o = $('#form_dmde_avance');
            nbfrais = 0;
            if (line !== 0) {
                for (j = 1; j <= line; j++) {
                    typo = o.find("#line" + j).find("#typologie" + j);
                    if (typo.val() !== "") nbfrais++;
                }
                for (i=1; i<=line; i++) {
                    typo = o.find("#line" + i).find(" #typologie" + i);
                    nature = o.find("#line" + i).find("#naturefrais" + i);
                    mont = o.find("#line" + i).find("#montant" + i);
                    if (typo.val()==="") {msgBoxUI("Ligne "+i+" : Veuillez sélectionner la typologie du frais.","typo.focus();");return false;}
                    if (nature.val()==="") {msgBoxUI("Ligne "+i+" : Veuillez saisir la nature du frais.","nature.focus();");return false;}
                    if (mont.val()==="" || parseInt(mont.val())===0) {msgBoxUI("Ligne "+i+" : Veuillez préciser le montant du frais.","mont.focus();");return false;}
                    if (fnElementExistant(nature.val(), i, line)) {msgBoxUI("Ligne "+i+" : Attention ! Cette nature est déjà dans la liste. <br>Veuillez en saisir une autre ou supprimer la ligne.","nature.focus();");return false;}
                }
            } 
            var formData = new FormData(o[0]);
            //formData.append('ficjustifnuite', o.find('#ficjustifnuite')[0].files[0]);
            for (j = 1; j <= line; j++) { 
                formData.append('fichierjustif'+j, o.find("#line" + j).find("#fichierjustif" + j)[0].files[0]);
            }
            $.ajax ({
                url: LIEN_AJAX, method: "POST",
                data: formData, //o.serialize(),
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    rspse = data.split('##');
                    if (rspse[0]==="OK") {
                        msgBoxUI(rspse[1], "window.location.reload();"); 
                    } else msgBoxUI(rspse[1]);
                },
                error:function(e){msgBoxUI(e.responseText);}
            });
            return false;
        }
        
        function fnCheckInfoMission(id){
            var o = $('#form_dmde_avance');
            ajax_data = {from:'charger_info_zone_mission', idmission:id};
            $.ajax({
                url:LIEN_AJAX, type:"POST", data:ajax_data, 
                success:function(data){
                    console.log(data);
                    rspse = data.split('##');
                    o.find('#codezone').val(rspse[0]);
                    o.find('#tarifnuitee').val(rspse[2]);
                    fnCalcTotalDetails();
                },
                error:function(e){msgBoxUI(e.responseText);}
            });
        }
        
        function fnCalcTotalDetails(){
            mission = o.find('#idmission'); nbrenuitee = o.find('#nbrenuitees'); tarif_nuitee = o.find('#tarifnuitee'); 
            totaldetails = 0; montnuitees = 0; 
            if (mission.val()!==""){
                montnuitees = parseFloat(tarif_nuitee.val()) * parseFloat(nbrenuitee.val());
                if (line>0) {
                    for (i=1; i<=line; i++) {
                        montfrais = o.find("#line" + i).find("#montant" + i);
                        if (parseFloat(montfrais.val())!==0) {totaldetails += parseFloat(montfrais.val());}
                    }
                }
                o.find('#totdetail').html('<h5 class="white-text bolder"><strong>'+totaldetails+' &euro;</strong></h5>');
            } 
            else {
                nbrenuitee.val('0'); tarif_nuitee.val('0'); 
                o.find('#totdetail').html('<h5 class="white-text bolder"><strong> 0 &euro;</strong></h5>');
            }
        }
        </script>
    </body>
</html>