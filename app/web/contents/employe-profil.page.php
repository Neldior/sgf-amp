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
                    $db = connectbd();
                    $user = $U['matricule']; 
                    $req = "SELECT e.idemp, e.nom, e.prenom, e.courriel, p.libelleprofil, s.libelleservice FROM employe e
                                JOIN profil p ON e.codeprofil = p.codeprofil
                                JOIN service s ON  e.idservice = s.idservice 
                                WHERE idemp = '" . $user . "'";
                    $res = $db->prepare($req);
                    $res->execute();
                    $donnees = $res->fetch();
                    
                } catch (PDOException $e) {
                die($e->getMessage());
            }
            ?>
            <div class="page has-sidebar-left bg-light height-full" style="margin-bottom: -27px !important">
                <header class="blue accent-3 relative nav-sticky"> <!-- style="background-color: #09709f !important;"-->
                    <div class="container-fluid text-white">
                        <div class="row">
                            <div class="col">
                                <h3 class="my-3"><i class="icon icon-note-important"></i> <strong>Gestion du Profil</strong></h3>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container-fluid my-3">
                    <div class="d-flex row">
                            <div class="col-md-12">
                                <div class="card mb-3 shadow no-b r-0">
                                    <div class="card-header white">
                                        <div class="row">
                                            <div class="col-sm-11 text-left" style="margin-top: 5px;">
                                                <h4 class="blue-text"><strong>Votre profil tel que vous l'avez renseigné ...</strong></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="subtitle-1">
                                            <div class="table-responsive ml-3 col-4">
                                                <table class="table" style="border:none">
                                                    <tbody class="text-black" style="border:none">
                                                        <tr style="border:none">
                                                            <td style="border:none"><i class="icon   icon-address-card-o blue-text s-18"> </i> Identifiant : </td>
                                                            <td style="border:none"><strong class=""><?php echo $donnees['idemp']; ?></strong></td>
                                                        </tr>
                                                        <tr style="border:none">
                                                            <td style="border:none"><i class="icon icon-account_circle blue-text s-18"></i> Nom : </td>
                                                            <td style="border:none"><strong class=""><?php echo mb_convert_case($donnees['nom'], MB_CASE_UPPER, "UTF-8"); ; ?></strong></td>
                                                        </tr>
                                                        <tr style="border:none">
                                                            <td style="border:none"><i class="icon icon-account_circle blue-text s-18"></i> Prénom : </td>
                                                            <td style="border:none"><strong class=""><?php echo mb_convert_case($donnees['prenom'], MB_CASE_TITLE, "UTF-8"); ?></strong></td>
                                                        </tr>
                                                        <tr class="text-black">
                                                            <td style="border:none"><i class="icon icon-skyscraper blue-text s-18"></i> Service de rattachement : </td>
                                                            <td style="border:none"><strong class=""><?php echo mb_convert_case($donnees['libelleprofil'], MB_CASE_UPPER, "UTF-8");   ?></strong></td>
                                                        </tr>
                                                        <tr style="border:none">
                                                            <td style="border:none"><i class="icon  icon-suitcase2 blue-text s-18"></i> Catégorie d'emploi : </td>
                                                            <td style="border:none"><strong class=""><?php echo mb_convert_case($donnees['libelleservice'], MB_CASE_UPPER, "UTF-8");   ?></strong></td>
                                                        </tr>
                                                        <tr style="border:none">
                                                            <td style="border:none"><i class="icon icon-mail-envelope-open3 blue-text s-18"></i> Courriel : </td>
                                                            <td style="border:none"><strong class=""><?php echo $donnees['courriel'];   ?></strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <ul class="ml-3" style="display:none">
                                                <li class="mb-2"> 
                                                    <i class="icon   icon-address-card-o blue-text s-18"> </i> 
                                                    Identifiant : <strong class=""><?php echo ucfirst($donnees['idemp']);  ?></strong>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="icon icon-account_circle blue-text s-18"></i>
                                                    Nom : <?php echo ucfirst($donnees['nom']); ?>
                                                </li>
                                                <li class="mb-2"> 
                                                    <i class="icon icon-account_circle blue-text s-18"></i>
                                                    Prénom : <?php echo ucfirst($donnees['prenom']); ?> </li>
                                                
                                                <li class="mb-2"> 
                                                    <i class="icon icon-skyscraper blue-text s-18"></i>
                                                    Service de rattachement : <?php echo ucfirst($donnees['libelleservice']); ?>
                                                </li>
                                                <li class="mb-2"> 
                                                    <i class="icon  icon-suitcase2 blue-text s-18"></i>
                                                    Catégorie d'emploi : <?php echo ucfirst($donnees['libelleprofil']); ?>
                                                </li>
                                                <li class="mb-2"> 
                                                    <i class="icon icon-mail-envelope-open3 blue-text s-18"></i>
                                                    Courriel : <?php echo $donnees['courriel']; ?>
                                                </li>
                                            </ul>
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