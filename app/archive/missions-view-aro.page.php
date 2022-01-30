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
   
                
                $mode="";
                if(isset($_GET)) {
                    extract($_GET);
                    $isEdit=$m==="modif";
                    $mode=$isEdit?"Modification":"Consultation";
                    $idmission=(int)$id;
                   

                    //*** initialisation des variables ***
                    $lienJustificatifRepertoire = "https/amp.com/justificatif/";
                    //$idmission = 1;

                    //*** les functions *****

                    //ouverture de connexion à la base de donnée
                    function connexionBase() {

                        $dsnPostgres = "pgsql:host=localhost;port=5432;"
                               . "dbname=filrouge;user=stag;password=stag";
                            $db = new PDO($dsnPostgres);
                            $db -> exec("SET NAMES 'UTF8'");
                            $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        return $db;
                    }


                    // Recupération de l'employé d'une mission
                    function missionEmploye($idmiss){

                       // connexion à la bd
                       $pdo = connexionBase();

                       //preparation de la requette
                       $requete = "SELECT nom, prenom FROM employe emp INNER JOIN mission m 
                                   ON emp.idemp = m.idemp WHERE idmission=$idmiss";

                       // execution de la requête 
                       $rq = $pdo->prepare($requete);
                       $rq->execute();

                       //recuperation du resultat de la requete
                       $result = $rq->fetch(PDO::FETCH_NUM);

                       echo "<h2> Mission n° ".$idmiss." de la mission de ".$result[0]." ". $result[1]."</h2>";


                    }

                    //Recupération des details d'une mission
                    function detailsMission($idmiss){

                       $pdo = connexionBase();

                       $requete = "SELECT dateheuredebut, dateheurefin, lienordremission, ville FROM mission WHERE idmission=$idmiss";


                       $rq = $pdo->prepare($requete);
                       $rq->execute();

                       $result = $rq->fetch(PDO::FETCH_NUM);

                       echo "<p> Mission du n° ".$result[0]." au ".$result[1]." à ".$result[3]."</p>";
                       echo "<p> Ordre de mission - justificatif disponible <span><a href=".$result[2].">ici</a></span> </p>";
                    }

                    // Tableau des details des frais réels d'une mission
                    function tabFraisReelMission($idmiss){

                       $pdo = connexionBase();

                       //preparation de la requete
                       $requete = "
                            SELECT naturefrais, montanttotalfrais, j.nomfichier
                                FROM justificatif j, detail_frais_reel df, associer_avance_detail ad, demande_avance da
                                WHERE j.iddetailfrais = df.iddetailfrais 
                                AND df.iddetailfrais = ad.iddetailfrais
                                AND ad.iddmdeavce = da.iddmdeavce
                                AND da.idmission = $idmiss

                                UNION

                            SELECT naturefrais, montanttotalfrais , j.nomfichier
                                FROM justificatif j, detail_frais_reel df, associer_rbmt_detail ar, demande_remboursement db
                                WHERE j.iddetailfrais = df.iddetailfrais 
                                AND df.iddetailfrais = ar.iddetailfrais
                                AND ar.iddmderbsmt = db.iddmderbsmt
                                AND db.idmission = $idmiss

                               ";


                       // execution de la requete
                       $rq = $pdo->prepare($requete); 
                       $rq->execute();

                       // recupération des données
                       $tab=array();
                       foreach ($rq as $result) {

                            $tabF['natureFrais'] = $result["naturefrais"];
                            $tabF['quantite'] = 1;
                            $tabF['montant'] = intval($result["montanttotalfrais"]);
                            $tabF['justificatif'] = $GLOBALS['lienJustificatifRepertoire'].$result["nomfichier"];
                            //$tabF['justificatif'] = $result["nomfichier"];
                            $tab[] = $tabF; 
                            //$tab=$tabF;
                        }
                        //var_dump($tab);
                        return $tab;
                    }


                    // tableau des nuitées
                    function tabNuitee($idmiss){

                        $pdo = connexionBase();
                        //preparation de la requete
                        $requete = "
                            SELECT nbrenuitee, justificatifnuitee, tarifnuitee
                                FROM demande_remboursement rb, mission m, zone_geographique z
                                WHERE rb.idmission = m.idmission
                                AND m.codezone = z.codezone
                                AND rb.idmission = $idmiss

                         ";
                        // execution de la requete
                        $rq = $pdo->prepare($requete); 
                        $rq->execute();

                        // recupération des données
                        $tab=array() ;
                        foreach ($rq as $result) {
                            $tab['natureFrais'] = "Nuitée";
                            $tab['quantite'] = $result["nbrenuitee"];
                            $tab['montant'] = $result["nbrenuitee"]*$result["tarifnuitee"];
                            $tab['justificatif'] = $GLOBALS['lienJustificatifRepertoire'].$result["justificatifnuitee"];
                            //$tabF['justificatif'] = $result["nomfichier"];
                            //$tabN= array_push($tabN,$tab);    

                        }

                        return $tab;

                    }

                    // tableau des repas
                    function tabRepas($idmiss){

                        $pdo = connexionBase();
                        //preparation de la requete
                        $requete = "
                            SELECT nbrerepas, tarifrepas
                                FROM demande_remboursement rb, mission m, zone_geographique z
                                WHERE rb.idmission = m.idmission
                                AND m.codezone = z.codezone
                                AND rb.idmission = $idmiss

                         ";
                        // execution de la requete
                        $rq = $pdo->prepare($requete); 
                        $rq->execute();

                        // recupération des données
                        $tab=array() ;
                        foreach ($rq as $result) {
                            $tab['natureFrais'] = "Repas";
                            $tab['quantite'] = $result["nbrerepas"];
                            $tab['montant'] = $result["nbrerepas"]*$result["tarifrepas"];
                            $tab['justificatif'] = "";
                            //$tabF['justificatif'] = $result["nomfichier"];
                            //$tabR= array_push($tabR,$tab); 
                        }
                        return $tab;

                    }


                    // tableau des km effectué
                    function tabkm($idmiss){

                        $pdo = connexionBase();
                        //preparation de la requete
                        $requete = "
                            SELECT kmsparcourus, tarif
                                FROM demande_remboursement d, voiture v, bareme_kilometrique b
                                WHERE d.immatriculation = v.immatriculation
                                AND v.puissanceadmin = b.puissanceadmin
                                AND d.idmission = $idmiss;

                         ";
                        // execution de la requete
                        $rq = $pdo->prepare($requete); 
                        $rq->execute();

                        // recupération des données
                        $tab=array() ;
                        foreach ($rq as $result) {
                            $tab['natureFrais'] = "Vehicule (km)";
                            $tab['quantite'] = $result["kmsparcourus"];
                            $tab['montant'] = $result["kmsparcourus"]*$result["tarif"];
                            $tab['justificatif'] = "";
                            //$tabF['justificatif'] = $result["nomfichier"];
                            //$tabR= array_push($tabR,$tab); 
                        }

                        if ($tab==array()) {
                            $tab['natureFrais'] = "Vehicule (km)";
                            $tab['quantite'] = 0;
                            $tab['montant'] = 0;
                            $tab['justificatif'] = "";

                        }

                        return $tab;

                    }

                    // fusion des tableaux 
                    function TabFusionFraisMission($idmiss){

                        //$tab = array();       
                        //array_push($tab,TabFraisReelMission($idmiss));
                        $tab=TabFraisReelMission($idmiss);

                        if (tabNuitee($idmiss)['quantite']!=0){
                            array_push($tab,tabNuitee($idmiss))
                            //$tab = $tab+tabNuitee($idmiss)
                                    ;
                        }

                        if (tabRepas($idmiss)['quantite']!=0){
                            array_push($tab,tabRepas($idmiss))
                            //$tab = $tab + tabRepas($idmiss)        
                                    ;
                        }

                        if (tabkm($idmiss)['quantite']!=0){
                            array_push($tab,tabkm($idmiss))
                            //$tab = $tab+tabkm($idmiss)        
                                    ;
                        }

                        return $tab;

                    }


                    // calcul du montant total des frais
                    function montantTotalFrais($idmiss){

                        $tabFrais = TabFusionFraisMission($idmiss);
                        //var_dump($tabFrais);
                        //calcul montant total
                        $mTotal=0;
                        foreach ($tabFrais as $val){
                            $mTotal = $mTotal + $val["montant"];    
                        }

                        return $mTotal;

                    }


                    // affichage de la liste des frais
                    function listeFraisMission($idmiss){

                        $tabFrais = TabFusionFraisMission($idmiss);

                        $mTotal = montantTotalFrais($idmiss);


                       /*Affichage 
                       echo "<table>";
                       echo " <caption>Liste des frais associés à cette mission </caption>";
                       echo " <thead><tr>";
                       echo "<th>Nature Frais</th>";
                       echo "<th>Quantité</th>";
                       echo "<th>Montant</th>";
                       echo "<th>Justificatif</th>";
                       echo "</tr></thead>";

                       foreach ($tabFrais as $val) {
                            echo "<tr><td>".$val["natureFrais"]."</td>";
                            echo "<td>".$val["quantite"]."</td>";
                            echo "<td>".$val["montant"]."</td>";
                            echo "<td> <a href=".$val["justificatif"].">lien</a></td></tr>";
                        }
                        echo "<tr><th colspan=3>Montant total: $mTotal </th></tr>";
                        echo "</table>";
                        */
                        // body new template
                        
                        foreach ($tabFrais as $val) {
                            echo '<tbody>';
                            echo '   <tr class="text-center text-black">';
                            echo '       <td style="text-align: left;">'.$val["natureFrais"].'</td>';
                            echo '       <td style="text-align: center">'.$val["quantite"].'</td>';
                            echo '        <td style="text-align: center">'.$val["montant"].'</td>';
                            echo '       <td style="text-align: center"><a href='.$val["justificatif"].'>lien</a></td>';
                            echo '   </tr> </tbody>';
                        }
                        echo "<tfoot>";
                        echo '    <tr class="text-right bg-default text-white bolder">';
                        echo '    <td colspan="4"><strong>Montant total:'.$mTotal.'</strong></td>';
                        echo '</tr> </tfoot>';
                            

                    }

                    // recuperation de l'etat de la demande d'avance
                    function etatAvance($idmiss){

                        $pdo = connexionBase();
                        //preparation de la requete
                        $requete = "
                               SELECT libelleetat
                                    FROM index_etat_avancement idx, etat_avcmt_avance et, demande_avance d, mission m
                                    WHERE idx.codeetat = et.codeetat
                                     AND et.iddmdeavce = d.iddmdeavce 
                                     AND d.idmission = m.idmission
                                     AND m.idmission = $idmiss

                         ";
                        // execution de la requete
                        $rq = $pdo->prepare($requete); 
                        $rq->execute();
                        $result = $rq->fetch(PDO::FETCH_NUM);

                        // recupération des données
                        $tab=array() ;
                        //var_dump($result);

                        while( $result !== FALSE ) { 
                            array_push($tab,$result[0]);
                            $result = $rq->fetch(PDO::FETCH_NUM); 
                         }
                        if  (count($tab)>1) {
                            $res= $tab[0]." - ".$tab[1];
                        } else {
                            $res= $tab[0];
                        }
                        return $res;

                    }

                    // recuperation du montant total de la demande d'avance
                    function montantAvance($idmiss){
                        $pdo = connexionBase();
                        //preparation de la requete
                        $requete = "
                           SELECT montanttotalavance
                               FROM demande_avance
                               WHERE idmission =$idmiss;
                         ";
                        // execution de la requete
                        $rq = $pdo->prepare($requete); 
                        $rq->execute();
                        $result = $rq->fetch(PDO::FETCH_NUM);
                        $mnt = $result[0];
                        return $mnt;


                    }

                    // recuperation de l'etat de la demande Remboursement
                    function etatRemboursement($idmiss){

                        $pdo = connexionBase();
                        //preparation de la requete
                        $requete = "
                            SELECT libelleetat
                                FROM index_etat_avancement idx, etat_avcmt_rbrsmt et, demande_remboursement d, mission m
                                WHERE idx.codeetat = et.codeetat
                                 AND et.iddmderbsmt = d.iddmderbsmt 
                                 AND d.idmission = m.idmission
                                 AND m.idmission = $idmiss;

                         ";
                        // execution de la requete
                        $rq = $pdo->prepare($requete); 
                        $rq->execute();
                        $result = $rq->fetch(PDO::FETCH_NUM);

                        // recupération des données
                        $tab=array() ;
                        //var_dump($result);

                        while( $result !== FALSE ) { 
                            array_push($tab,$result[0]);
                            $result = $rq->fetch(PDO::FETCH_NUM); 
                         }

                        if  (count($tab)>1) {
                            $res= $tab[0]." - ".$tab[1];
                        } else {
                            $res= $tab[0];
                        }
                        return $res;

                    }

                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    try {
                        $pdo = connectbd();
                        
                        //récuperer l'enregistrement et l'afficher
                        $reqM = "SELECT * FROM mission WHERE idmission=:idmission LIMIT 1";
                        $stmt = $pdo->prepare($reqM);
                        $dparam=[':idmission'=>$id];
                        $result = $stmt->execute($dparam);
                        $mission = $stmt->fetch(PDO::FETCH_ASSOC); 
                        extract($mission);
                        
                        //Récupération des demandes d'avance liées à la mission
                        $reqDA = "SELECT * FROM demande_avance WHERE idmission=:idmission ORDER BY iddmdeavce";
                        $stmtDA = $pdo->prepare($reqDA);
                        $resultDA = $stmtDA->execute([':idmission'=>$idmission]);
                        $davce = $stmtDA->fetchAll(); 
                        
                        //Récupération des demandes de remboursement liées à la mission
                        $reqDR = "SELECT * FROM demande_remboursement WHERE idmission=:idmission ORDER BY iddmderbsmt";
                        $stmtDR = $pdo->prepare($reqDR);
                        $resultDR = $stmtDR->execute([':idmission'=>$idmission]);
                        $dremb = $stmtDR->fetchAll(); 
                        
                        
                        //Recuperation de la Liste des zones géo
                        $reqZ = "SELECT * FROM zone_geographique ORDER BY codezone";
                        $resultZ = $pdo->query($reqZ);

                        //Recuperation de la Liste des types d'activités
                        $reqA = "SELECT * FROM type_activite ORDER BY codeactiv";
                        $resultA = $pdo->query($reqA);

                        //Recuperation de la Liste des Clients
                        $reqC = "SELECT * FROM client ORDER BY nomclient";
                        $resultC = $pdo->query($reqC);

                        //Recuperation de la Liste des villes
                        $reqV = "SELECT * FROM ville ORDER BY nomville";
                        $resultV = $pdo->query($reqV);

                    } catch (PDOException $e) {
                        die('Erreur Chargement Liste Zones ! : ' . $e->getMessage());
                    }
                }
            ?>
            <div class="page has-sidebar-left bg-light height-full">
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
                            <form class="form-material" id="form_mission2" method="post" action="#" onsubmit="return fnSaveMajMission();" enctype="multipart/form-data">
                                <input type="hidden" name="from" id="from2" value="save_mission">
                                <input type="hidden" name="todo" id="todo" value="modif">
                                <input type="hidden" name="idmission" id="idmission" value="<?= $idmission ?>" />
                                <div class="card mb-3 shadow no-b r-0">
                                    <div class="card-header white">
                                        <div class="row">
                                            <div class="col-sm-12 text-left" style="margin-top: 5px;">
                                                <h4 class="blue-text"><strong><?/= $mode ?> Détails de la Mission N° <?= $idmission ?> </strong></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="margin: -10px 20px 0 20px">
                                        <div class="row" style="margin-bottom: -10px !important">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="datedebut" class="col-form-label text-black">Date Début Prévue <b class="bolder text-red"> </b></label>
                                                            <input type="text" id="datedebut" name="datedebut" class="date-time-picker form-control" required autocomplete="on" placeholder="AAAA/MM/JJ HH:MM" value="<?= !empty($dateheuredebut)?str_replace("-","/",$dateheuredebut):"" ?>" <?php if (!$isEdit) { ?> onFocus="this.blur();" <?php } ?>/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="datefin" class="col-form-label text-black">Date Fin Prévue<b class="bolder text-red"> </b></label>
                                                            <input type="text" id="datefin" name="datefin" class="date-time-picker form-control" required autocomplete="on"  placeholder="AAAA/MM/JJ HH:MM" value="<?= !empty($dateheurefin)?str_replace("-","/",$dateheurefin):"" ?>" <?php if (!$isEdit) { ?> onFocus="this.blur();" <?php } ?>/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="datedepart" class="col-form-label text-black">Date Départ <b class="text-red"> (Si différente de la date de début)</b></label>
                                                            <input type="text" id="datedepart" name="datedepart" class="date-time-picker form-control" autocomplete="on" placeholder="AAAA/MM/JJ HH:MM" value="<?= !empty($dateheuredepart)?str_replace("-","/",$dateheuredepart):"" ?>" <?php if (!$isEdit) { ?> onFocus="this.blur();" <?php } ?>/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="dateretour" class="col-form-label text-black">Date Retour <b class="text-red"> (Si différente de la date de fin) </b></label>
                                                            <input type="text" id="dateretour" name="dateretour" class="date-time-picker form-control" autocomplete="on"  placeholder="AAAA/MM/JJ HH:MM" value="<?= !empty($dateheureretour)?str_replace("-","/",$dateheureretour):""?>" <?php if (!$isEdit) { ?> onFocus="this.blur();" <?php } ?>/>
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
                                                            <label for="referenceom" class="col-form-label text-black">Référenes Ordre de Mission</label>
                                                            <input type="text" id="referenceom" name="referenceom" class="form-control" required autocomplete="on" placeholder="Numéro de l'OM" value="<?= $numordremission ?>" <?php if (!$isEdit) { ?> onFocus="this.blur();" <?php } ?>/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="lienversom" class="col-form-label text-black">Lien vers l'Ordre de Mission </label>
                                                            <div class="form-line mt-auto">
                                                            <label for="lienversom" class="col-form-label text-black">Fichier de l'Ordre de Mission </label>
                                                            <input type="text" id="fichierom" name="fichierom" class="form-control" required="" value="<?= $lienordremission ?>">
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line">
                                                            <label for="typeactivite" class="col-form-label text-black">Type d'Activité</label>
                                                            <strong>
                                                                <select id="typeactivite" name="typeactivite" class="custom-select select2" onchange="" required <?php if (!$isEdit) { ?> disabled <?php } ?>>
                                                                    <option value="">Sélectionner une Activité</option>
                                                                    <?php
                                                                        foreach ($resultA as $activ) { ?> 
                                                                            <option value="<?= $activ['codeactiv']; ?>" <?php if ($codeactiv===$activ['codeactiv']) echo "selected=\'selected'"; ?>> <?= $activ['libelleactiv'] ?> </option> 
                                                                        <?php }
                                                                    ?>
                                                                </select>
                                                            </strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line">
                                                            <label for="zone" class="col-form-label text-black">Zone Géographique </label>
                                                            <strong>
                                                                <select id="zone" name="zone" class="custom-select select2" onchange="" required <?php if (!$isEdit) { ?> disabled <?php } ?>>
                                                                    <option value="">Sélectionner une Zone</option>
                                                                    <?php
                                                                        foreach ($resultZ as $zone) { ?> 
                                                                            <option value="<?= $zone['codezone']; ?>" <?php if ($codezone===$zone['codezone']) echo "selected=\'selected'"; ?>> <?= $zone['libellezone'] ?> </option> 
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
                                                            <label for="adresse" class="col-form-label text-black">Adresse/Lieu</label>
                                                            <input type="text" id="adresse" name="adresse" class="form-control" required autocomplete="on" placeholder="Lieu de la mission" value="<?= $adresse ?>" <?php if (!$isEdit) { ?> onFocus="this.blur();" <?php } ?>/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line mt-auto">
                                                            <label for="codepostal" class="col-form-label text-black">Code Postal</label>
                                                            <input type="number" id="codepostal" name="codepostal" class="form-control" required autocomplete="on"  placeholder="Ex : 31300" value="<?= (int)$codepostal ?>" <?php if (!$isEdit) { ?> onFocus="this.blur();" <?php } ?>/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line">
                                                            <label for="ville" class="col-form-label text-black">Ville </label>
                                                            <input type="text" id="ville" name="ville" class="form-control" required autocomplete="on" placeholder="Ville du lieu de la mission" value="<?= $ville ?>" <?php if (!$isEdit) { ?> onFocus="this.blur();" <?php } ?>/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group form-float">
                                                        <div class="form-line">
                                                            <label for="client" class="col-form-label text-black">Client </label>
                                                            <strong>
                                                                <select id="client" name="client" class="custom-select select2" onchange="" <?php if (!$isEdit) { ?> disabled <?php } ?>>
                                                                    <option value="">Sélectionner un Client</option>
                                                                    <?php
                                                                        foreach ($resultC as $client) { ?> 
                                                                            <option value="<?= $client['numsiret']; ?>" <?php if ($numsiret===$client['numsiret']) echo "selected=\'selected'"; ?>> <?= $client['numsiret']." - ".$client['nomclient'] ?> </option> 
                                                                        <?php } ?>
                                                                </select>
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-3 shadow no-b r-0">
                                            <div class="card-header white">
                                                <div class="row">
                                                    <div class="col-sm-10 text-left" style="margin-top: 5px;">
                                                        <h4 class="blue-text"><strong>Demande(s) d'Avance</strong></h4>
                                                    </div>
                                                    <div class="col-sm-2 text-right" style="margin-top: -5px; margin-bottom: -5px">
                                                        <!--<button class="btn-primary btn-fab fab-right fab-right-top-fixed shadow bg-indigo" onclick="return fnLoadScreenDemande('avance','enreg',<?/= $idmission; ?>,'-1');" data-toggle="modal"  data-target="#GenericModal" style="cursor:pointer;"><i class="icon-add"></i></button>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="avance" class="card-body" style="margin: -10px 0 0 0">
                                                <div class="table-responsive">
                                                    <table id="dtbl-example1" class="table table-bordered table-hover">
                                                        <thead class="bg-indigo text-white"> 
                                                            <tr class="text-center">
                                                                <th style="width: 10%;"><strong>N°</strong></th>
                                                                <th style="width: 15%"><strong>Date</strong></th>
                                                                <th style="width: 15%"><strong>Montant</strong></th>
                                                                <th style="width: 15%"><strong>Nuitées</strong></th>
                                                                <th style="width: 25%"><strong>Montant Total</strong></th>
                                                                <th style="width: 20%"><strong>Etat</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                $i = 0; 
                                                                if (count($davce)!==0) {
                                                                    foreach ($davce as $avce) { $i++;
                                                                        //extract($avce); 
                                                                        //récuperer le dernier état de la demande
                                                                        $reqEA = "SELECT ea.*, e.libelleetat FROM etat_avcmt_avance ea, index_etat_avancement e WHERE ea.codeetat=e.codeetat and ea.iddmdeavce=:demande ORDER BY datevaletat DESC LIMIT 1";
                                                                        $stmtA = $pdo->prepare($reqEA);
                                                                        $resultA = $stmtA->execute([':demande'=>$avce['iddmdeavce']]);
                                                                        $etatA = $stmtA->fetch(PDO::FETCH_ASSOC); 
                                                                        ?>
                                                                        <a href="#" onclick="fnLoadDetailsFraisDemande('avance',<?= $iddmdeavce; ?>);" style="cursor:pointer;">
                                                                            <tr class='text-black'>
                                                                                <td style="text-align: center;"><?= $i; ?></td>
                                                                                <td style="text-align: center"><?= date_english_to_french($avce['datedmande']); ?></td>
                                                                                <td style="text-align: right"><?= $avce['montantdemande']; ?></td>
                                                                                <td style="text-align: center"><?= $avce['nbrenuitee']; ?></td>
                                                                                <td style="text-align: right"><?= number_format($avce['montanttotalavance'],2); ?></td>
                                                                                <td style="text-align: center"><a href="#" class="btn btn-success r-20"><strong><?= mb_strtoupper($etatA['libelleetat']); ?></strong></a></td>
                                                                            </tr>
                                                                        </a>
                                                                <?php } 
                                                                } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-3 shadow no-b r-0">
                                            <div class="card-header white">
                                                <div class="row">
                                                    <div class="col-sm-10 text-left" style="margin-top: 5px;">
                                                        <h4 class="blue-text"><strong>Demande(s) de Remboursement</strong></h4>
                                                    </div>
                                                    <div class="col-sm-2 text-right" style="margin-top: -5px; margin-bottom: -5px">
                                                        <!--<button class="btn-primary btn-fab fab-right fab-right-top-fixed shadow bg-secondary" onclick="return fnLoadScreenDemande('rembsmt','enreg',<?/= $idmission; ?>,'-1');" data-toggle="modal"  data-target="#GenericModal" style="cursor:pointer;"><i class="icon-add"></i></button>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="remboursement" class="card-body" style="margin: -10px 0 0 0">
                                                <div class="table-responsive">
                                                    <table id="dtbl-example2" class="table table-bordered table-hover">
                                                        <thead class="bg-secondary text-white"> 
                                                            <tr class="text-center">
                                                                <th style="width: 10%;"><strong>N°</strong></th>
                                                                <th style="width: 15%"><strong>Date</strong></th>
                                                                <th style="width: 15%"><strong>Nbre Repas</strong></th>
                                                                <th style="width: 15%"><strong>Nbre Nuitées</strong></th>
                                                                <th style="width: 25%"><strong>Km parcourus </strong></th>
                                                                <th style="width: 20%"><strong>Etat</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                $i = 0; 
                                                                if (count($dremb)!==0) {
                                                                    foreach ($dremb as $remb) { $i++;
                                                                        //extract($remb); 
                                                                        //récuperer le dernier état de la demande
                                                                        $reqER = "SELECT er.*, e.libelleetat FROM etat_avcmt_rbrsmt er, index_etat_avancement e WHERE er.codeetat=e.codeetat and er.iddmderbsmt=:demande ORDER BY datevaletat DESC LIMIT 1";
                                                                        $stmtR = $pdo->prepare($reqER);
                                                                        $resultR = $stmtR->execute([':demande'=>$remb['iddmderbsmt']]);
                                                                        $etatR = $stmtR->fetch(PDO::FETCH_ASSOC); 
                                                                        ?>
                                                                        <tr class='text-black'>
                                                                            <td style="text-align: center;"><?= $i; ?></td>
                                                                            <td style="text-align: center"><?= date_english_to_french($remb['datedmde']); ?></td>
                                                                            <td style="text-align: center"><?= $remb['nbrerepas']; ?></td>
                                                                            <td style="text-align: center"><?= $remb['nbrenuitee']; ?></td>
                                                                            <td style="text-align: center"><?= $remb['kmsparcourus']; ?></td>
                                                                            <td style="text-align: center"><a href="#" class="btn btn-success r-20"><strong><?= mb_strtoupper($etatR['libelleetat']); ?></strong></a></td>
                                                                        </tr>
                                                                <?php } 
                                                                } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-3 shadow no-b r-0">
                                            <div class="card-header white">
                                                <div class="row">
                                                    <div class="col-sm-10 text-left" style="margin-top: 5px;">
                                                        <h4 class="blue-text"><strong>Détails des Frais associés (Je suis sur les details)</strong></h4>
                                                    </div>
                                                    <div class="col-sm-2 text-right" style="margin-top: -5px; margin-bottom: -5px">
                                                        <!--<button class="btn-primary btn-fab fab-right fab-right-top-fixed shadow bg-default" onclick="return fnLoadScreenDemande('avance','enreg',<?/= $idmission; ?>,'-1');" data-toggle="modal"  data-target="#GenericModal" style="cursor:pointer;"><i class="icon-add"></i></button>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="avance" class="card-body" style="margin: -10px 0 0 0">
                                                <div class="table-responsive">
                                                    <table id="dtbl-example3" class="table table-bordered table-hover">
                                                        <thead class="bg-default text-white"> 
                                                            <tr class="text-center">
                                                                <th style="width: 30%;"><strong>Nature Frais</strong></th>
                                                                <th style="width: 20%"><strong>Quantité</strong></th>
                                                                <th style="width: 20%"><strong>Montant</strong></th>
                                                                <th style="width: 30%"><strong>Justificatif</strong></th>
                                                            </tr>
                                                        </thead>
                                                            
                                                             <?php listeFraisMission($idmission) ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="card mb-3 shadow no-b r-0">
                                            <div class="card-header white">
                                                <div class="row">
                                                    <div class="col-sm-10 text-left" style="margin-top: 5px;">
                                                        <h4 class="blue-text"><strong>Etat d'avancement de la mission </strong></h4>
                                                    </div>
                                                    <div class="col-sm-2 text-right" style="margin-top: -5px; margin-bottom: -5px"> </div>
                                                </div>
                                            </div>
                                            <div class="card-body" style="margin: -10px 0 0 0">
                                                 <ul>                                                
                                                    <li> Montant total de l'avance : <?php echo montantAvance($idmission) ?></li>
                                                    <a href="#" class="btn btn-success r-20"><strong><?= mb_strtoupper($etatA['libelleetat']); ?></strong></a>
                                                    <li> Montant de remboursement demandé : <?php echo montantTotalFrais($idmission) - montantAvance($idmission)?></li>
                                                    <a href="#" class="btn btn-success r-20"><strong><?= mb_strtoupper($etatR['libelleetat']); ?></strong></a>
                                                    
                                                    
                                                </ul>

                                            </div>
                                        </div>
                                     </div>
                                </div>
                                <div class="card mb-3 shadow no-b r-0">
                                    <div class="col-md-12 col-sm-12 white">
                                        <div class="card-body white text-right" style="margin-right: 15px">
                                            <a href="missions-liste.page.php" class="btn btn-danger bg-red waves-effect btn-lg right bolder"><i class="icon-arrow_back mr-2"></i>Retour</a> 
                                            <?php if ($isEdit) { ?> <button type="submit" class="btn btn-success bg-green waves-effect btn-lg right bolder"><i class="icon-save mr-2"></i>Enregistrer</button> <?php } ?>
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
        function fnLoadScreenDemande(type, ecran, mission, id) {
            element = type==="avance"? " d'une Demande d'avance":" d'une Demande de remboursement";
            titre = ecran==="enreg" ? projetName+"Enregistrement"+element : (ecran==="modif" ? projetName+"Modification"+element : projetName+"Consultation"+element);
            func = 'globalModalProcess();';
            $.ajax({
                url: "<?php echo "../controller/processingMissions.php"; ?>", method: "POST",
                data: {from: 'screen_demande', todo:type, missionencours: mission, iddmde:id},
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
                    $(".select2").select2();
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
        function fnSaveMajMission(){
            alert(123);
            o = $('#form_mission2'); 
            debut = o.find('#datedebut'); fin = o.find('#datefin'); depart = o.find('#datedepart'); retour = o.find('#dateretour');
            //alert(debut.val()+fin.val()+depart.val()+retour.val());
            if($.trim(debut.val())!=="" && $.trim(fin.val())!=="") {
                if($.trim(debut.val())===$.trim(fin.val())) {msgBoxUI("Les dates de début et de fin de la mission ne doivent pas être identiques! Veuillez vérifier les heures.", "fin.focus();"); return false;}
                if($.trim(debut.val()) > $.trim(fin.val())) {msgBoxUI("La date de début ne doit pas être postérieure à celle de fin! Veuillez revoir vos saisies.", "fin.focus();"); return false;}
            }
            if($.trim(depart.val())!=="" && $.trim(retour.val())!=="") {
                if($.trim(depart.val())===$.trim(retour.val())) {msgBoxUI("Les dates depart et retour ne doivent pas être identiques! veuillez vérifier les heures.", "retour.focus();"); return false;}
                if($.trim(depart.val()) > $.trim(retour.val())) {msgBoxUI("La date de depart ne doit pas être postérieure à celle de retour! Veuillez revoir vos saisies.", "retour.focus();"); return false;}
            }
            $.ajax ({
                url: "<?= "../controller/processingMissions.php"; ?>", method: "POST",
                data: o.serialize(),
                success: function(data){
                    console.log(data);
                    rspse = data.split('##');
                    if (rspse[0]==="OK") {
                        msgBoxUI(rspse[1]); //,"window.location.reload();"
                        window.location.href='missions-liste.page.php';
                    } else msgBoxUI(rspse[1]);
                }
            });
                return false;
            }
        </script>
    </body>
</html>