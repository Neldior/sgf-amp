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
        echo "ERR##Vous êtes déconnecté. Merci de vous reconnecter et de réessayer.";
    }
    switch ($from){
        case "screen_new_user":
            $isEdit = $userId !== "-1";
            if ($isEdit) {
                //Faire requête et ramener l'enregistrement
            }
            ?>
            <input type="hidden" name="todo" id="todo" value="<?= $isEdit?"modif":"new";?>">
            <div class="row" style="margin-bottom: -10px">
                <div class="col-6 form-group form-float">
                    <div class="form-line mt-auto" style="margin-bottom: -5px">
                        <label for="matricule" class="col-form-label" style="margin-bottom: -15px">Matricule <sup class="text-black">*</sup></label>
                        <input type="text" class="form-control" id="matricule" name="matricule" placeholder="Ex: 1899025" maxlength="7" value="<?= isset($userMatricule)?$userMatricule:"";?>" required onfocus="//this.blur();" autocomplete="on"/>
                    </div>
                </div>
                <div class="col-6 form-group form-float">
                    <div class="form-line" style="margin-bottom: -5px">
                        <label for="profil" class="col-form-label" style="margin-bottom: -15px">Profil <sup class="text-black">*</sup></label>
                        <strong>
                            <select id="profil" name="profil" class="custom-select select2" onchange="" required>
                                <option value="">Tous les Profils</option>
                                <option value="USER">Utilisateurs</option>
                                <option value="ADMIN">Administrateurs</option>
                                <option value="SUPER">Super-Administrateurs</option>
                            </select>
                        </strong>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: -10px">
                <div class="col-6 form-group form-float">
                    <div class="form-line mt-auto" style="margin-bottom: -5px">
                        <label for="nom" class="col-form-label" style="margin-bottom: -15px">Nom <sup class="text-black">*</sup></label>
                        <input class="form-control" id="nom" name="nom" value="<?= isset($userNom)?$userNom:"";?>" placeholder="Nom de l'Utilisateur" onblur="this.value=this.value.toUpperCase();" required autocomplete="on" />
                    </div>
                </div>
                <div class="col-6 form-group form-float">
                    <div class="form-line" style="margin-bottom: -5px">
                        <label for="prenom" class="col-form-label" style="margin-bottom: -15px">Prenoms(s) <sup class="text-black">*</sup></label>
                        <input class="form-control" id="prenom" name="prenom" value="<?= isset($userPrenom)?$userPrenom:"";?>" placeholder="Prénom(s) de l'Utilisateur" onblur="this.value=this.value.toUpperCase();" required autocomplete="on" />
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: -10px">
                <div class="col-6 form-group form-float">
                    <div class="form-line mt-auto" style="margin-bottom: -5px">
                        <label for="contact" class="col-form-label" style="margin-bottom: -15px">Contact <sup class="text-black">*</sup></label>
                        <input type="text" class="form-control" id="contact" name="contact" placeholder="00 00 00 00 00" value="<?= isset($userMatricule)?$userMatricule:"";?>" required autocomplete="on" />
                    </div>
                </div>
                <div class="col-6 form-group form-float">
                    <div class="form-line" style="margin-bottom: -5px">
                        <label for="email" class="col-form-label" style="margin-bottom: -15px">Adresse Electronique <sup class="text-black">*</sup></label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= isset($userNom)?$userNom:"";?>" placeholder="utilisateur@domaine.com" onblur="//this.value=this.value.toUpperCase();" required autocomplete="on" />
                    </div>
                </div>
            </div>

            <?php
            break;

        case "screen_edit_user":

            break;

        case "delete_user":

            break;

        case "save_user":
            switch ($todo) {
                case "new":
                    //Rechercher si le matricule existait
                    //Si trouvé renvoyer une erreur
                    //Sinon, enregistrer et envoyer un message de succès
                    //Si enregistrement échoué, renvoyer un message avec l'erreur
                    echo "OK##Enregistrement ($matricule - $nom - $prenom - $contact - $email) effectué avec succès.";
                    break;
                case "modif":

                    break;
            }

            break;
        case "save_pass": 
            try {
                //Contrôle de l'ancien mot de passe
                $reqE = "SELECT motdepasse FROM employe WHERE idemp=:idemp AND motdepasse=:pwd LIMIT 1";
                $stmt = $pdo->prepare($reqE);
                $stmt->execute([':idemp'=>$U['matricule'],':pwd'=>$passold]);
                $pass2 = $stmt->fetch(PDO::FETCH_ASSOC);
                if (empty($pass2)) { //Password erronné
                    echo "ERR##L'ancien mot de passe saisi est erronné.";
                }
                else { //Password bon
                    //Mise à jour du passe
                    $reqM = "UPDATE employe SET motdepasse=:passnew WHERE idemp=:idemp";
                    $stmt = $pdo->prepare($reqM);
                    $result = $stmt->execute([':passnew'=>$passnew,':idemp'=>$U['matricule']]);
                    if ($result!==false) { //Update réussie
                        unset($_SESSION['USER']);
                        echo "OK##Modification du Mot de passe effectuée avec succès. </br>Vous allez être déconnecté. Merci de vous reconnecter.."; 
                    } else { //Si echec
                        echo "ERR##Modification du mot de passe échouée.";
                    }
                }
            } catch (PDOException $e) {
                die('ERR##Erreur' . $e->getMessage());
            }
                
            break;
        default :
            echo "ERR##Function de Gestion de l'Administration : bloc <b>From = $from</b> non défini.";
            break;
    }
