<?php
    require_once('_header.inc.php');
    $login = $pass = ""; $nbElmts = 0;
    $WData = ['log' => "", 'pwd' => ""];
    foreach ($WData as $cle => $elmt ) {
        if (array_key_exists($cle, $_POST)) {
            $WData[$cle] = $_POST[$cle];
            $nbElmts++;
        }
    }
    if ($nbElmts > 0 && !empty($WData)) {
        $login = htmlspecialchars($WData["log"]); 
        $pass = htmlspecialchars($WData["pwd"]);
    }
    //Vérifier l'existence de l'employer et le connecter si la chaine est juste
    //$employe = "US80001005"; 
    try {
       // Connexion à la base de données
       $pdo = connectbd();

       //Requele de récupération des users
       $reqS = "SELECT * FROM employe WHERE courriel = :login AND motdepasse = :passwd LIMIT 1";
       $stmt = $pdo->prepare($reqS);
       //$result->bindValue(':login', $login); //$result->bindValue(':passwd', $pass);
       $result = $stmt->execute([':login'=>$login, ':passwd'=>$pass]);
       $user = $stmt->fetch(PDO::FETCH_ASSOC);
       
       if (empty($user)){ //Non trouvé
           echo "ERR##Votre login ou votre mot de passe est incorrect !";
       } else { //Trouvé
           $_SESSION['USER'] = [
            'stat'=>"OK",
            'matricule'=>$user['idemp'],
            'login'=>$login,
            'nomuser'=>$user['nom'],
            'prenomuser'=>$user['prenom'],
            'civilite'=>$user['civilite'],
            'profil'=>$user['codeprofil']
        ];
        echo "OK##";
       }
       
    } catch (PDOException $e) {
         die("ERR##".$e->getMessage());
    }


