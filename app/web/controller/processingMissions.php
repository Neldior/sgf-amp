<?php
    session_start();
    require_once('../../includes/connect_db.php'); 
    require_once('../../includes/functions.php'); 
    extract($_POST);
    extract($_GET);
    $pdo = connectbd();
    
    if (isset($_SESSION['USER'])) {
        $U = $_SESSION['USER'];
    } else {
        echo "Déconnexion : Vous êtes déconnecté. Merci de vous reconnecter et de réessayer.";
    }
    // recuperation du montant total de la demande d'avance
    function montantAvance($idmiss){
        $pdo = connectbd(); //connexionBase();
        //preparation de la requete
        $requete = "SELECT montanttotalavance FROM demande_avance WHERE idmission =$idmiss;";
        // execution de la requete
        $rq = $pdo->prepare($requete); 
        $rq->execute();
        $result = $rq->fetch(PDO::FETCH_NUM);
        $mnt = floatval($result[0]);
        return $mnt;
    }
                    
    
    switch ($from){
        case "save_mission":
            switch ($todo) {
                case "new":
                    //Rechercher si une mission existait avec les mêmes datedebut et datefin
                    $client=empty($client)?NULL:$client;
                    $datedepart=empty($datedepart)?NULL:$datedepart;
                    $dateretour=empty($dateretour)?NULL:$dateretour;
                    $lienversom = "";
                    
                    try {
                        //Récupération du fichier
                        if(isset($_FILES['fichierom'])){
                            $fichierom = $_FILES['fichierom']; 
                            $nomfic = pathinfo($fichierom['name']);
                            $fic = $fichierom['name'];
                            if((!empty($fic)) && (!empty($nomfic))){
                                $extensionfic = $nomfic['extension'];
                                $extensions_autorisees = ['jpg', 'jpeg', 'gif', 'png', 'pdf', 'JPG', 'JPEG', 'GIF', 'PNG', 'PDF'];
                                $type = $fichierom['type'];
                                $taille = $fichierom['size'];
                                $emplacmt = $fichierom['tmp_name']; //emplacement temporaire
                                $msg = $fichierom['error'];  //0 si pas erreur
                                if(!in_array($extensionfic, $extensions_autorisees)){echo "ERR##Erreur sur le type de fichier d'image ! Type attendu : jpg,jpeg,gif,png,pdf,JPG,JPEG,GIF,PNG,PDF)."; }
                                elseif($taille > 8000000){echo "ERR##Erreur lors du téléchargement du fichier ! Fichier trop lourd (8 Mo au maximum attendu)."; }
                                elseif($msg != 0){echo "ERR##Erreur lors du téléchargement du fichier ! $msg.";}
                                else{
                                    if (!empty($emplacmt) && $msg == UPLOAD_ERR_OK) {
                                        $chemin_destination = '../om/';
                                        if (move_uploaded_file($emplacmt, $chemin_destination . $fic)) { //echo "L'envoi a bien été effectué !";
                                            $lienversom = $fic; 
                                        }
                                        else {echo "ERR##Erreur lors du téléchargement du fichier de l'OM.";}
                                    }
                                }
                            } else {$lienversom = NULL; }
                        } else {$lienversom = NULL; }
                    
                        //Requele de récupération des users
                        $reqS = "SELECT * FROM mission WHERE idemp=:employe AND numordremission=:refom AND dateheuredebut=:debut AND dateheurefin=:fin AND codezone=:zone";
                        $stmt = $pdo->prepare($reqS);
                        $dparam=[':employe'=>$U['matricule'], ':refom'=>$referenceom, ':debut'=>$datedebut, ':fin'=>$datefin, ':zone'=>$zone];
                        $result = $stmt->execute($dparam);
                        $missions = $stmt->fetchAll(); 
                        //echo "ERR##".count($missions);
                        if (count($missions)===0) {//N'existe pas
                            //Insertion
                            //echo "ERR##".$U['matricule'].",$zone,$client,$typeactivite,$datedebut,$datefin,$referenceom,$lienversom,$datedepart,$dateretour,$codepostal,$adresse,$ville,$justifnuite";
                            $reqI = "INSERT INTO mission(idemp,codezone,numsiret,codeactiv,dateheuredebut,dateheurefin,numordremission,lienordremission,dateheuredepart,dateheureretour,codepostal,adresse,ville) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $stmt = $pdo->prepare($reqI);
                            $data = [$U['matricule'],$zone,$client,$typeactivite,$datedebut,$datefin,$referenceom,$lienversom,$datedepart,$dateretour,$codepostal,$adresse,$ville];
                            $insert = $stmt->execute($data);
                            if ($insert) { //Si insertion réussie
                                echo "OK##Enregistrement de la mission effectué avec succès."; 
                            } else { //Si echec
                                echo "ERR##Enregistrement de la mission échoué.";
                            }
                        }
                        else { //Une missin existe avec ces infos
                            echo "ERR##Une mission existe déjà avec ces informations (OM, Date début, Date fin, Zone géographique) ! Veuillez consulter la liste.";
                        }
                    } catch (PDOException $e) {
                        die("ERR##Erreur lors de l'enregistrement : </br>". $e->getMessage());
                    }
                    break;
                case "modif":
                    echo "ERR$idmission";
                    //Faire la mise a jour des donnees de la mission
                    $client=empty($client)?NULL:$client;
                    $datedepart=empty($datedepart)?NULL:$datedepart;
                    $dateretour=empty($dateretour)?NULL:$dateretour;
                    try {
                        //Requele de récupération des users
                        $reqU = "UPDATE mission SET codezone=:zone,numsiret=:client,codeactiv=:activite,dateheuredebut=:debut,dateheurefin=:fin,numordremission=:refom,"
                                . "lienordremission=:lienom,dateheuredepart=:depart,dateheureretour=:retour,codepostal=:codepostal,adresse=:adresse,ville=:ville "
                                . "WHERE idmission=:mission";
                        $stmt = $pdo->prepare($reqU);
                        $data = [':zone'=>$zone,':client'=>$client,':activite'=>$typeactivite,':debut'=>$datedebut,':fin'=>$datefin,':refom'=>$referenceom,':lienom'=>$lienversom,
                                 ':depart'=>$datedepart,':retour'=>$dateretour,':codepostal'=>$codepostal,':adresse'=>$adresse,':ville'=>$ville,':mission'=>$idmission];
                        $result = $stmt->execute($data);
                        //echo "EE##".count($missions);
                        if ($result!==false) { //Update réussie
                            echo "OK##Modification de la mission effectuée avec succès."; 
                        } else { //Si echec
                            echo "ERR##Modification échouée.";
                        }
                    } catch (PDOException $e) {
                        die('ERR##Erreur' . $e->getMessage());
                    }
                    break;
                case "supprimer":
                    
                    break;
            }
            break;
        case "screen_demande":
            $employe = in_array($U['profil'], ['P1','P2']) ? $U['matricule'] : "%";
            //echo "ERR##$missionencours";
            //Recuperation de la Liste des missions
            $reqM2 = "SELECT * FROM mission WHERE idemp LIKE :employe ORDER BY idmission";
            $stmtM2 = $pdo->prepare($reqM2);
            $resultM0 = $stmtM2->execute(array(':employe'=>$employe));
            $resultM2 = $stmtM2->fetchAll();
            
            switch ($todo) {
                case "avance": ?>
                    <input type="hidden" name="todo" id="todo" value="">
                    <div class="row" style="margin-bottom: -10px">
                        <div class="col-8 form-group form-float">
                            <div class="form-line" style="margin-bottom: -5px">
                                <label for="idmission" class="col-form-label text-black">Mission <sup class="text-black">*</sup></label>
                                <strong>
                                    <select id="idmission" name="idmission" class="custom-select select2" onchange="" required>
                                        <option value="">Sélectionner une Mission</option>
                                        <?php
                                            foreach ($resultM2 as $miss) { ?> 
                                                <option value="<?= $miss['idmission']; ?>" <?php if ($missionencours===$miss['idmission']) echo "selected=\'selected'"; ?>> <?= "Mission N°".$miss['idmission']." du ".date_english_with_hour_to_french($miss['dateheuredebut'])." au ".date_english_with_hour_to_french($miss['dateheurefin']) ?> </option> 
                                            <?php }
                                        ?>
                                    </select>
                                </strong>
                            </div>
                        </div>
                        <div class="col-4 form-group form-float">
                            <div class="form-line mt-auto">
                                <label for="datedmde" class="col-form-label text-black">Date Demande <b class="bolder text-red"> <sup>*</sup></b></label>
                                <input type="text" id="datedmde" name="datedmde" class="date-time-picker form-control" required autocomplete="on" placeholder="AAAA/MM/JJ HH:MM" value="<?= date('Y/m/d H:i:s'); //!empty($dateheuredebut)?str_replace("-","/",$dateheuredebut):"" ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: -10px">
                        <div class="col-4 form-group form-float">
                            <div class="form-line mt-auto" style="margin-bottom: -5px">
                                <label for="nbrenuites" class="col-form-label text-black" style="margin-bottom: -15px">Nombre de nuités <sup class="text-black">*</sup></label>
                                <input type="number" class="form-control" id="nbrenuites" name="nbrenuites" value="" placeholder="0" required autocomplete="on" />
                            </div>
                        </div>
                        <div class="col-4 form-group form-float">
                            <div class="form-line" style="margin-bottom: -5px">
                                <label for="montantdmde" class="col-form-label text-black" style="margin-bottom: -15px">Montant Demandé <sup class="text-black">*</sup></label>
                                <input type="number" class="form-control" id="montantdmde" name="montantdmde" value="" placeholder="0" required autocomplete="on" />
                            </div>
                        </div>
                        <div class="col-4 form-group form-float">
                            <div class="form-line" style="margin-bottom: -5px">
                                <label for="montanttotal" class="col-form-label text-black" style="margin-bottom: -15px">Montant Total <sup class="text-black">*</sup></label>
                                <input type="number" class="form-control" id="montanttotal" name="montanttotal" placeholder="0" autocomplete="on" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: -10px">
                        
                        <div class="col-12 form-group form-float">
                            <div class="form-line mt-auto" style="margin-bottom: -5px">
                                <label for="justif" class="col-form-label text-black" style="margin-bottom: -15px">Lien Justificatif <sup class="text-black">*</sup></label>
                                <input type="text" class="form-control" id="justif" name="justif" placeholder="Lien vers la pièce justificative" value="" required autocomplete="on" />
                            </div>
                        </div>
                    </div>
                    <?php 
                    break;
                case "rembsmt":?>
                    <input type="hidden" name="todo" id="todo" value="">
                    <div class="row" style="margin-bottom: -10px">
                        <div class="col-8 form-group form-float">
                            <div class="form-line" style="margin-bottom: -5px">
                                <label for="idmission" class="col-form-label text-black">Mission <sup class="text-black">*</sup></label>
                                <strong>
                                    <select id="idmission" name="idmission" class="custom-select select2" onchange="" required>
                                        <option value="">Sélectionner une Mission</option>
                                        <?php
                                            foreach ($resultM2 as $miss) { ?> 
                                                <option value="<?= $miss['idmission']; ?>" <?php if ($missionencours===$miss['idmission']) echo "selected=\'selected'"; ?>> <?= "Mission N°".$miss['idmission']." du ".date_english_with_hour_to_french($miss['dateheuredebut'])." au ".date_english_with_hour_to_french($miss['dateheurefin']) ?> </option> 
                                            <?php }
                                        ?>
                                    </select>
                                </strong>
                            </div>
                        </div>
                        <div class="col-4 form-group form-float">
                            <div class="form-line mt-auto">
                                <label for="datedmde" class="col-form-label text-black">Date Demande <b class="bolder text-red"> <sup>*</sup></b></label>
                                <input type="text" id="datedmde" name="datedmde" class="date-time-picker form-control" required autocomplete="on" placeholder="AAAA/MM/JJ HH:MM" value="<?= date('Y/m/d H:i:s'); //!empty($dateheuredebut)?str_replace("-","/",$dateheuredebut):"" ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: -10px">
                        <div class="col-4 form-group form-float">
                            <div class="form-line mt-auto" style="margin-bottom: -5px">
                                <label for="nbrenuites" class="col-form-label text-black" style="margin-bottom: -15px">Nombre de nuités <sup class="text-black">*</sup></label>
                                <input type="number" class="form-control" id="nbrenuites" name="nbrenuites" value="" placeholder="0" required autocomplete="on" />
                            </div>
                        </div>
                        <div class="col-4 form-group form-float">
                            <div class="form-line" style="margin-bottom: -5px">
                                <label for="montantdmde" class="col-form-label text-black" style="margin-bottom: -15px">Montant Demandé <sup class="text-black">*</sup></label>
                                <input type="number" class="form-control" id="montantdmde" name="montantdmde" value="" placeholder="0" required autocomplete="on" />
                            </div>
                        </div>
                        <div class="col-4 form-group form-float">
                            <div class="form-line" style="margin-bottom: -5px">
                                <label for="montanttotal" class="col-form-label text-black" style="margin-bottom: -15px">Montant Total <sup class="text-black">*</sup></label>
                                <input type="number" class="form-control" id="montanttotal" name="montanttotal" placeholder="0" autocomplete="on" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: -10px">
                        
                        <div class="col-12 form-group form-float">
                            <div class="form-line mt-auto" style="margin-bottom: -5px">
                                <label for="justif" class="col-form-label text-black" style="margin-bottom: -15px">Lien Justificatif <sup class="text-black">*</sup></label>
                                <input type="text" class="form-control" id="justif" name="justif" placeholder="Lien vers la pièce justificative" value="" required autocomplete="on" />
                            </div>
                        </div>
                    </div>
                    <?php 
                    break;
            }
            break;
        case "afficher_details_mission": 
            try {
                $libelle="";
                //Récupperation des détails de la mission
                $reqM = "SELECT m.*, z.libellezone FROM mission m, zone_geographique z WHERE m.codezone = z.codezone AND m.idmission = :idmission LIMIT 1";
                $stmt = $pdo->prepare($reqM);
                $result = $stmt->execute([':idmission'=> $mission]);
                $miss = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($miss)) {
                    extract($miss); 
                    $libelle = "Mission du <strong>". date_english_with_hour_to_french($dateheuredebut)."</strong> au <strong>". date_english_with_hour_to_french($dateheurefin)."</strong> à <strong>$adresse, $codepostal, ".mb_strtoupper($ville)." dans la zone ".mb_strtoupper($libellezone)."</strong>.";
                }

                $reqA = "SELECT d.*, e.datevaletat, i.libelleetat FROM demande_avance d, etat_avcmt_avance e, index_etat_avancement i WHERE d.idmission=:idmission AND d.iddmdeavce=e.iddmdeavce AND e.codeetat = i.codeetat ORDER BY e.datevaletat DESC LIMIT 1";
                $stmtA = $pdo->prepare($reqA);
                $resA = $stmtA->execute([':idmission'=> $mission]);
                $davce = $stmtA->fetch(PDO::FETCH_ASSOC);

                $reqD = "SELECT d.*, e.datevaletat, i.libelleetat FROM demande_remboursement d, etat_avcmt_rbrsmt e, index_etat_avancement i WHERE d.idmission=:idmission AND d.iddmderbsmt=e.iddmderbsmt AND e.codeetat = i.codeetat ORDER BY e.datevaletat DESC LIMIT 1";
                $stmtD = $pdo->prepare($reqD);
                $resD = $stmtD->execute([':idmission'=> $mission]);
                $drbsmt = $stmtD->fetch(PDO::FETCH_ASSOC);

                //récupérer la somme des détails des frais de la demande de remboursement
                $montanttotalrbsmt=0; 
                if (!empty($drbsmt)) {
                    $reqMt = "SELECT SUM(d.montanttotalfrais) AS total FROM detail_frais_reel d, associer_rbmt_detail a WHERE d.iddetailfrais = a.iddetailfrais AND a.iddmderbsmt=:iddmderbsmt";
                    $stmtMt = $pdo->prepare($reqMt);
                    $resMt = $stmtMt->execute([':iddmderbsmt'=> $drbsmt['iddmderbsmt']]);
                    $dmont = $stmtMt->fetch(PDO::FETCH_ASSOC);
                    $montanttotalrbsmt = $dmont['total'];
                }


            } catch (PDOException $e) {
                  die($e->getMessage());
             }
            ?>
            <div class="d-flex row">
                <div class="col-md-12">
                    <div class="card mb-3 shadow no-b r-0">
                        <div class="card-header bg-indigo">
                            <div class="row no-margin">
                                <div class="col-sm-12 text-white bolder text-center bg-indigo s-16" style="margin-top: 5px;">
                                    <h4 class="text-white bolder text-center bg-indigo s-16"><strong>Détails de la Mission N° <?= $mission ?></strong></h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="margin: 0 20px">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul>
                                        <li class="text-black s-18"><?= $libelle ?></li>
                                        <li class="text-black s-18">Numéro de la Mission : <strong><?= $mission ?></strong></li>
                                        <?php if (!empty($davce)) { ?>
                                        <li class="text-black s-18">Demande d'avance <strong><?= $davce['libelleetat'] ?></strong> le <strong><?= date_english_to_french($davce['datevaletat']) ?></strong> pour un montant de <strong><?= number_format($davce['montanttotalavance'],2) ?> &euro;</strong></li>
                                        <?php } else { ?>
                                        <li class="text-red s-18"><strong>Pas de Demande d'avance </strong></li>
                                        <?php } ?>
                                        <?php if (!empty($drbsmt)) { ?>
                                        <li class="text-black s-18">Demande de remboursement <strong><?= $drbsmt['libelleetat'] ?></strong> le <strong><?= date_english_to_french($davce['datevaletat']) ?></strong> pour un montant de <strong><?= number_format($montanttotalrbsmt,2) ?> &euro;</strong></li>
                                        <?php } else { ?>
                                        <li class="text-red s-18"><strong>Pas de Demande de remboursement </strong></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            break;
        case "screen_new_defail_frais":
            switch ($typedmde) {
                case "rmbsmt":
                    //récuperer l'enregistrement et l'afficher
                    $reqT = "SELECT * FROM typologie_frais_reel ORDER BY codetypo ";
                    $stmtT = $pdo->query($reqT);
                    $resultT = $stmtT->fetchAll();
                    ?>
                    <input type="hidden" name="todo" id="todo" value="<?= $isEdit?"modif":"new";?>">
                    <div class="row" style="margin-bottom: -10px">
                        <div class="col-6 form-group form-float">
                            <div class="form-line" style="margin-bottom: -5px">
                                <label for="typologie" class="col-form-label text-black" style="margin-bottom: -15px">Typologie du Frais <sup class="text-red">*</sup></label>
                                <strong>
                                    <select id="typologie" name="typologie" class="custom-select select2" onchange="" required>
                                        <option value="">Sélectionner une Typologie</option>
                                        <?php
                                            foreach ($resultT as $typo) { ?> 
                                                <option value="<?= $typo['codetypo']; ?>" > <?= $typo['libelletypo'] ?> </option> 
                                            <?php }
                                        ?>
                                    </select>
                                </strong>
                            </div>
                        </div>
                        <div class="col-6 form-group form-float">
                            <div class="form-line mt-auto" style="margin-bottom: -5px">
                                <label for="naturefrais" class="col-form-label text-black" style="margin-bottom: -15px">Nature du Frais <sup class="text-red">*</sup></label>
                                <input type="text" class="form-control" id="naturefrais" name="naturefrais" placeholder="Nature du frais" required onBlur="this.value=this.value.toUpperCase();" autocomplete="on"/>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row" style="margin-bottom: -10px">
                        <div class="col-6 form-group form-float">
                            <div class="form-line mt-auto" style="margin-bottom: -5px">
                                <label for="montant" class="col-form-label text-black" style="margin-bottom: -10px">Montant Frais <sup class="text-red">*</sup></label>
                                <input type="number" class="form-control" id="montant" name="montant" placeholder="0" value="0" required autocomplete="on" />
                            </div>
                        </div>
                        <div class="col-6 form-group form-float">
                            <div class="form-line" style="margin-bottom: -5px">
                                <label for="fichierjustif" class="col-form-label text-black">Fichier du Justificatif  <sup class="text-red">*</sup></label>
                                <input type="file" id="fichierjustif" name="fichierjustif" class="form-control" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: -10px">
                        <div class="col-12 form-group form-float">
                            <div class="form-line mt-auto" style="margin-bottom: -5px">
                                <label for="libellejustif" class="col-form-label text-black" style="margin-bottom: -15px">Libellé Justificatif  <sup class="text-red">*</sup></label>
                                <input type="text" class="form-control" id="libellejustif" name="libellejustif" placeholder="Libellé du Justificatif" required onBlur="this.value=this.value.toUpperCase();" autocomplete="on" />
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case "avance":
                    
                    break;
            }

            break;
        case "save_demande":
            switch ($todo) {
                case "new_dmde_rmbsmt":
                    //echo "ERR##Je suis ici avec ".count($_FILES)." fichiers";
                    //Téléchargement du fichier justificatif de nuité
                    $justifnuitee = "";
                    if(isset($_FILES['ficjustifnuite'])){
                        $ficjustifnuite = $_FILES['ficjustifnuite']; 
                        $nomfic = pathinfo($ficjustifnuite['name']);
                        $fic = $ficjustifnuite['name'];
                        if((!empty($fic)) && (!empty($nomfic))){
                            $extensionfic = $nomfic['extension'];
                            $extensions_autorisees = ['jpg', 'jpeg', 'gif', 'png', 'pdf', 'JPG', 'JPEG', 'GIF', 'PNG', 'PDF'];
                            $type = $ficjustifnuite['type'];
                            $taille = $ficjustifnuite['size'];
                            $emplacmt = $ficjustifnuite['tmp_name']; //emplacement temporaire
                            $msg = $ficjustifnuite['error'];  //0 si pas erreur
                            if(!in_array($extensionfic, $extensions_autorisees)){echo "ERR##Erreur sur le type de fichier ! Type attendu : jpg,jpeg,gif,png,pdf,JPG,JPEG,GIF,PNG,PDF)."; }
                            elseif($taille > 8000000){echo "ERR##Erreur lors du téléchargement du fichier ! Fichier trop lourd (8 Mo au maximum attendu)."; }
                            elseif($msg != 0){echo "ERR##Erreur lors du téléchargement du fichier ! $msg.";}
                            else{
                                if (!empty($emplacmt) && $msg == UPLOAD_ERR_OK) {
                                    $chemin_destination = '../justif/';
                                    if (move_uploaded_file($emplacmt, $chemin_destination . $fic)) { //echo "Le téléchargement a bien été effectué !";
                                        $justifnuitee= $fic; 
                                    }
                                    else {echo "ERR##Erreur lors du téléchargement du fichier du justifcatif de la nuité.";}
                                }
                            }
                        } else {$justifnuitee = NULL; }
                    } else {$justifnuitee = NULL; }
                    
                    try {
                        $pdo->beginTransaction();
                        $db_justificatifnuitee=$justifnuitee;
                        $db_immatriculation=empty($db_immatriculation)?NULL:$db_immatriculation;              
                        //Insertion de la demande de remboursement 
                        $requete = "INSERT INTO demande_remboursement (idmission, datedmde, nbrerepas, kmsparcourus, nbrenuitee, justificatifnuitee,immatriculation)
                                    VALUES (:db_idmission,:db_datedmde,:db_nbrerepas,:db_kmsparcourus,:db_nbrenuitee,:db_justificatifnuitee,:db_immatriculation)
                                    RETURNING iddmderbsmt;";
                        $rq = $pdo->prepare($requete);
                        $rq->bindParam(':db_idmission',$idmission);
                        $rq->bindParam(':db_datedmde',$datedmde);
                        $rq->bindParam(':db_nbrerepas',$nbrerepas);
                        $rq->bindParam(':db_kmsparcourus',$kmparcourus);
                        $rq->bindParam(':db_nbrenuitee',$nbrenuitees);
                        $rq->bindParam(':db_justificatifnuitee',$db_justificatifnuitee);
                        $rq->bindParam(':db_immatriculation',$db_immatriculation);
                        $rq->execute();//execution
                        $res = $rq->fetch(PDO::FETCH_ASSOC); 
                        //Récuperation du dernier id
                        $db_iddmderbsmt = $res["iddmderbsmt"];
                        
                      
                        $j=0; $justifdetail = ""; 
                        //Enregistrement des détails des frais et des justifs
                        for($i = 0; $i < count($typologie); $i++){
                            //2.1. Insertion des detail_frais_reel 
                            $requete1 = "INSERT INTO detail_frais_reel (codetypo, naturefrais, montanttotalfrais) 
                                         VALUES (:db_codetypo,:db_naturefrais,:db_montanttotalfrais)
                                         RETURNING iddetailfrais; ";
                            $rq1 = $pdo->prepare($requete1);
                            $rq1->bindParam(':db_codetypo',$typologie[$i]);
                            $rq1->bindParam(':db_naturefrais',$naturefrais[$i]);
                            $rq1->bindParam(':db_montanttotalfrais',$montant[$i]);
                            $rq1->execute();//execution
                            $res1 = $rq1->fetch(PDO::FETCH_ASSOC);
                            $db_iddetailfrais = $res1["iddetailfrais"];
                            
                            //2.2. table association
                            $requete2 = "INSERT INTO associer_rbmt_detail (iddetailfrais, iddmderbsmt) 
                                         VALUES (:db_iddetailfrais,:db_iddmderbsmt);";
                            $rq2 = $pdo->prepare($requete2);
                            $rq2->bindParam(':db_iddetailfrais',$db_iddetailfrais);
                            $rq2->bindParam(':db_iddmderbsmt',$db_iddmderbsmt);
                            $rq2->execute();//execution
                            
                            $j=$i+1; 
                            $justifdetail = ""; //$fichierjustif.$j = "";
                            //Téléchargement des fichiers de jsustif des détails de frais
                            if(isset($_FILES['fichierjustif'.$j])){
                                $fichierjustif.$j = $_FILES['fichierjustif'.$j]; 
                                $nomfic2 = pathinfo($fichierjustif.$j['name']);
                                $fic2 = $fichierjustif.$j['name'];
                                if((!empty($fic2)) && (!empty($nomfic2))){
                                    $extensionfic2 = $nomfic2['extension'];
                                    $extensions_autorisees2 = ['jpg', 'jpeg', 'gif', 'png', 'pdf', 'JPG', 'JPEG', 'GIF', 'PNG', 'PDF'];
                                    $type2 = $fichierjustif.$j['type'];
                                    $taille2 = $fichierjustif.$j['size'];
                                    $emplacmt2 = $fichierjustif.$j['tmp_name']; //emplacement temporaire
                                    $msg2 = $fichierjusti.$j['error'];  //0 si pas erreur
                                    if(!in_array($extensionfic2, $extensions_autorisees2)){echo "ERR##Erreur sur le type de fichier ! Type attendu : jpg,jpeg,gif,png,pdf,JPG,JPEG,GIF,PNG,PDF)."; }
                                    elseif($taille2 > 8000000){echo "ERR##Erreur lors du téléchargement du fichier ! Fichier trop lourd (8 Mo au maximum attendu)."; }
                                    elseif($msg2 != 0){echo "ERR##Erreur lors du téléchargement du fichier ! $msg2.";}
                                    else{
                                        if (!empty($emplacmt2) && $msg2 == UPLOAD_ERR_OK) {
                                            $chemin_destination2 = '../justif/';
                                            if (move_uploaded_file($emplacmt2, $chemin_destination2 . $fic2)) { //echo "L'envoi a bien été effectué !";
                                                $justifdetail= $fic2; 
                                            }
                                            else {echo "ERR##Erreur lors du téléchargement du fichier du justifcatif du frais.";}
                                        }
                                    }
                                } else {$justifdetail = NULL; }
                            } else {$justifdetail = NULL; }
                            
                            //2.3. table justificatif
                            $db_nomfichier=$justifdetail;
                            //requete d'insertion
                            $requete3 = "insert into justificatif (iddetailfrais, libellejustificatif, nomfichier) 
                                values (:db_iddetailfrais,:db_libellejustificatif,:db_nomfichier);";
                            $rq3 = $pdo->prepare($requete3);
                            $rq3->bindParam(':db_iddetailfrais',$db_iddetailfrais);
                            $rq3->bindParam(':db_libellejustificatif',$libellejustif[$i]);
                            $rq3->bindParam(':db_nomfichier',$db_nomfichier);
                            //execution
                            $rq3->execute();
                        }
                     
                        //3. table etat_avcmt_rbrsmt
                        $db_codeetat = 'V10';
                        $db_datevaletat=NULL;
                        $requete4 = "INSERT INTO etat_avcmt_rbrsmt (iddmderbsmt, codeetat, datevaletat )
                                        VALUES (:db_iddmderbsmt,:db_codeetat,:db_datevaletat );";
                        $rq4 = $pdo->prepare($requete4);
                        $rq4->bindParam(':db_iddmderbsmt',$db_iddmderbsmt);
                        $rq4->bindParam(':db_codeetat',$db_codeetat);
                        $rq4->bindParam(':db_datevaletat', $db_datevaletat);
                        //execution
                        $rq4->execute();
                        $pdo->commit();
                        echo "OK##Enregistrement de la demande de remboursement effectué avec succès avec prise en compte des détails des frais réels."; 

                    } catch (PDOException $e) {
                        $pdo->rollBack();
                        die("ERR##Erreur lors de l'enregistrement : </br>". $e->getMessage());
                    }

                    break;
                case "new_dmde_avance":
                    //echo "ERR##Je suis ici avec ".count($_FILES)." fichiers";
                    try {
                        $pdo->beginTransaction();
                        $db_justificatifnuitee=NULL;
                        //Insertion de la demande d'avance
                        $requete = "INSERT INTO demande_avance (idmission, montantdemande, nbrenuitee, datedmande, montanttotalavance)
                                    VALUES (:db_idmission, :db_montant, :db_nbrenuitee, :db_datedmde, :db_montanttotal)
                                    RETURNING iddmdeavce;";
                        $rq = $pdo->prepare($requete);
                        $rq->bindParam(':db_idmission',$idmission);
                        $rq->bindParam(':db_montant',$montantdemande);
                        $rq->bindParam(':db_nbrenuitee',$nbrenuitees);
                        $rq->bindParam(':db_datedmde',$datedmde);
                        $rq->bindParam(':db_montanttotal',$montantdemande);
                        $rq->execute();//execution
                        $res = $rq->fetch(PDO::FETCH_ASSOC); 
                        //Récuperation du dernier id
                        $db_iddmdeavce = $res["iddmdeavce"];
                        
                      
                        $j=0; $justifdetail = ""; 
                        //Enregistrement des détails des frais et des justifs
                        for($i = 0; $i < count($typologie); $i++){
                            //2.1. Insertion des detail_frais_reel 
                            $requete1 = "INSERT INTO detail_frais_reel (codetypo, naturefrais, montanttotalfrais) 
                                         VALUES (:db_codetypo,:db_naturefrais,:db_montanttotalfrais)
                                         RETURNING iddetailfrais; ";
                            $rq1 = $pdo->prepare($requete1);
                            $rq1->bindParam(':db_codetypo',$typologie[$i]);
                            $rq1->bindParam(':db_naturefrais',$naturefrais[$i]);
                            $rq1->bindParam(':db_montanttotalfrais',$montant[$i]);
                            $rq1->execute();//execution
                            $res1 = $rq1->fetch(PDO::FETCH_ASSOC);
                            $db_iddetailfrais = $res1["iddetailfrais"];
                            
                            //2.2. table association
                            $requete2 = "INSERT INTO associer_avance_detail (iddetailfrais, iddmdeavce) 
                                         VALUES (:db_iddetailfrais,:db_iddmdeavce);";
                            $rq2 = $pdo->prepare($requete2);
                            $rq2->bindParam(':db_iddetailfrais',$db_iddetailfrais);
                            $rq2->bindParam(':db_iddmdeavce',$db_iddmdeavce);
                            $rq2->execute();//execution
                            
                            $j=$i+1; 
                            $justifdetail = ""; //$fichierjustif.$j = "";
                            //Téléchargement des fichiers de jsustif des détails de frais
                            if(isset($_FILES['fichierjustif'.$j])){
                                $fichierjustif.$j = $_FILES['fichierjustif'.$j]; 
                                $nomfic2 = pathinfo($fichierjustif.$j['name']);
                                $fic2 = $fichierjustif.$j['name'];
                                if((!empty($fic2)) && (!empty($nomfic2))){
                                    $extensionfic2 = $nomfic2['extension'];
                                    $extensions_autorisees2 = ['jpg', 'jpeg', 'gif', 'png', 'pdf', 'JPG', 'JPEG', 'GIF', 'PNG', 'PDF'];
                                    $type2 = $fichierjustif.$j['type'];
                                    $taille2 = $fichierjustif.$j['size'];
                                    $emplacmt2 = $fichierjustif.$j['tmp_name']; //emplacement temporaire
                                    $msg2 = $fichierjusti.$j['error'];  //0 si pas erreur
                                    if(!in_array($extensionfic2, $extensions_autorisees2)){echo "ERR##Erreur sur le type de fichier ! Type attendu : jpg,jpeg,gif,png,pdf,JPG,JPEG,GIF,PNG,PDF)."; }
                                    elseif($taille2 > 8000000){echo "ERR##Erreur lors du téléchargement du fichier ! Fichier trop lourd (8 Mo au maximum attendu)."; }
                                    elseif($msg2 != 0){echo "ERR##Erreur lors du téléchargement du fichier ! $msg2.";}
                                    else{
                                        if (!empty($emplacmt2) && $msg2 == UPLOAD_ERR_OK) {
                                            $chemin_destination2 = '../justif/';
                                            if (move_uploaded_file($emplacmt2, $chemin_destination2 . $fic2)) { //echo "L'envoi a bien été effectué !";
                                                $justifdetail= $fic2; 
                                            }
                                            else {echo "ERR##Erreur lors du téléchargement du fichier du justifcatif du frais.";}
                                        }
                                    }
                                } else {$justifdetail = NULL; }
                            } else {$justifdetail = NULL; }
                            
                            //2.3. table justificatif
                            $db_nomfichier=$justifdetail;
                            //requete d'insertion
                            $requete3 = "insert into justificatif (iddetailfrais, libellejustificatif, nomfichier) 
                                values (:db_iddetailfrais,:db_libellejustificatif,:db_nomfichier);";
                            $rq3 = $pdo->prepare($requete3);
                            $rq3->bindParam(':db_iddetailfrais',$db_iddetailfrais);
                            $rq3->bindParam(':db_libellejustificatif',$libellejustif[$i]);
                            $rq3->bindParam(':db_nomfichier',$db_nomfichier);
                            //execution
                            $rq3->execute();
                        }
                     
                        //3. table etat_avcmt_rbrsmt
                        $db_codeetat = 'V10';
                        $db_datevaletat=NULL;
                        $requete4 = "INSERT INTO etat_avcmt_avance (iddmdeavce, codeetat, datevaletat )
                                        VALUES (:db_iddmdeavce,:db_codeetat,:db_datevaletat );";
                        $rq4 = $pdo->prepare($requete4);
                        $rq4->bindParam(':db_iddmdeavce',$db_iddmdeavce);
                        $rq4->bindParam(':db_codeetat',$db_codeetat);
                        $rq4->bindParam(':db_datevaletat', $db_datevaletat);
                        //execution
                        $rq4->execute();
                        $pdo->commit();
                        echo "OK##Enregistrement de la demande d'avance effectué avec succès."; 

                    } catch (PDOException $e) {
                        $pdo->rollBack();
                        die("ERR##Erreur lors de l'enregistrement : </br>". $e->getMessage());
                    }
                    break;
                default:
                    break;
            }
            break;
            case "charger_info_zone_mission":
                $zone = ""; $tarifR = 0; $tarifN = 0; $montavance = 0; $mttotalavance = 0; 
                if ($idmission!=="") {
                    //Recuperation de la Liste des zones géo
                    $reqZ = "SELECT z.* FROM zone_geographique z INNER JOIN mission m ON z.codezone = m.codezone WHERE m.idmission = :idmission";
                    $stmtZ= $pdo->prepare($reqZ);
                    $stmtZ->execute([':idmission'=>$idmission]);
                    $info = $stmtZ->fetch(PDO::FETCH_ASSOC);
                    if (!empty($info)) {
                        $zone = $info['codezone']; 
                        $tarifR = floatval($info['tarifrepas']);
                        $tarifN = floatval($info['tarifnuitee']);
                    }
                    //Recuperation du montant avancé pour la mission
                    $reqA = "SELECT montanttotalavance FROM demande_avance WHERE idmission = :idmission";
                    $stmtA= $pdo->prepare($reqA);
                    $stmtA->execute([':idmission'=>$idmission]);
                    $davce = $stmtA->fetch(PDO::FETCH_ASSOC);
                    if (!empty($davce)) {
                        $montavance = floatval($davce['montanttotalavance']);
                    }
                    $mttotalavance = montantAvance($idmission);
                }
                echo "$zone##$tarifR##$tarifN##$montavance##$mttotalavance";
                break;
            case "charger_info_bareme":
                $puissance = ""; $tarif = 0; 
                if ($immat!=="") {
                    //Recuperation du bareme kilometrik
                    $reqB = "SELECT puissanceadmin FROM voiture WHERE immatriculation = :immat";
                    $stmtB= $pdo->prepare($reqB);
                    $stmtB->execute([':immat'=>$immat]);
                    $bareme = $stmtB->fetch(PDO::FETCH_ASSOC);
                    if (!empty($bareme)) {
                        $puissance = intval($bareme['puissanceadmin']); 
                        if ($puissance <= 3) {$tarif = 0.41; }
                        else if ($puissance === 4) {$tarif = 0.493; }
                        else if ($puissance === 5) {$tarif = 0.543; }
                        else if ($puissance === 6) {$tarif = 0.568; }
                        else if ($puissance >= 7) {$tarif = 0.595; }
                        
                        /*switch ($puissance){
                            case "<= 3" :
                                $tarif = 0.41; 
                                break;
                            case "4" :
                                $tarif = 0.493; 
                                break;
                            case "5" :
                                $tarif = 0.543; 
                                break;
                            case "6" :
                                $tarif = 0.568; 
                                break;
                            case ">= 7" :
                                $tarif = 0.595; 
                                break;
                        }*/
                    }
                }
                echo "$puissance##$tarif";
                break;
          
        default :
            echo "ERR##Function de Gestion des Missions : bloc <b>From = $from</b> non défini.";
            break;
    }
