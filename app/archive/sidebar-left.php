<?php ?>
<aside class="main-sidebar fixed offcanvas shadow" data-toggle='offcanvas'>
    <section class="sidebar">
        <div class="" style="padding: 5px 50px; background-color: #0d4ab1!important; margin-bottom: -10px">
            <div class="w-200px mt-3 mb-3 ml-3"><a href="../../../app/web/contents/accueil.php"><h3 class="white-text" style="font-weight: bold">SGF-AMP</h3></a></div>
        </div>
        <div class="relative">
            <a data-toggle="collapse" href="#userSettingsCollapse" role="button" aria-expanded="false"
               aria-controls="userSettingsCollapse" class="btn-fab btn-fab-sm absolute fab-right-bottom fab-top btn-primary shadow1 ">
                <i class="icon icon-cogs"></i>
            </a>
            <div class="user-panel p-3 light mb-2">
                <div>
                    <div class="float-left image">
                        <img class="user_avatar" src="../../assets/img/dummy/u2.png" alt="User Image">
                    </div>
                    <div class="float-left info">
                        <h6 class="font-weight-light mt-2 mb-1"><strong><?= $nomUser; ?></strong></h6>
                        <a href="#"><i class="icon-circle text-primary blink"></i> Online</a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="collapse multi-collapse" id="userSettingsCollapse">
                    <div class="list-group mt-3 shadow">
                        <a href="../../../app/web/contents/profil-employe.page.php" class="list-group-item list-group-item-action "><i class="mr-2 icon-umbrella text-blue"></i>Profil</a>
                        <a href="../../../app/web/contents/logout.php" class="list-group-item list-group-item-action"><i class="mr-2 icon-cogs text-yellow"></i>Déconnexion</a>
                    </div>
                </div>
            </div>
        </div>
        <ul class="sidebar-menu text-black" style="font-weight: bold; font-size: 14px">
            <li class="header" style="font-size: 18px"><strong>MENU PRINCIPAL</strong></li>
            <li class="treeview"><a href="../../../app/web/contents/accueil.php"><i class="icon icon-home purple-text s-18"></i> <span class="text-black">Accueil</span></a></li>
            <li class="treeview"><a href="../../../app/web/contents/missions-new.page.php"><i class="icon icon icon-package blue-text s-18"></i> <span class="text-black">Saisir une Mission</span></a></li>
            <li class="treeview"><a href="../../../app/web/contents/missions-new.page.php"><i class="icon icon icon-package blue-text s-18"></i> <span class="text-black">Demande d'avance</span></a></li>
            <li class="treeview"><a href="../../../app/web/contents/missions-new.page.php"><i class="icon icon icon-package blue-text s-18"></i> <span class="text-black">Demande de remboursement</span></a></li>
            <li class="treeview"><a href="../../../app/web/contents/missions-liste.page.php"><i class="icon icon icon-package green-text s-18"></i> <span class="text-black">Liste des Missions</span></a></li>
            <li class="treeview"><a href="../../../app/web/contents/voitures-liste.page.php"><i class="icon icon icon-credit-card yellow-text s-18"></i> <span class="text-black">Voitures</span></a></li>
            
                <?php if(in_array($U['profil'],['P1','P2','P3'])) { ?>
            <li class="treeview"><a href="#"><i class="icon icon-sailing-boat-water purple-text s-18"></i> <span class="text-black">Gestion des Demandes</span> <i class="icon icon-angle-left s-18 pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class=""><a href="../../../app/web/contents/baremes-liste.page.php"><i class="icon icon-folder5"></i>Demandes d'Avance</a></li>
                    <li class=""><a href="../../../app/web/contents/etats-liste.page.php"><i class="icon icon-folder5"></i>Demandes de Remboursement</a></li>
                    <!--<li class=""><a href="../../../app/web/contents/profils-liste.page.php"><i class="icon icon-folder5"></i>Détails des Frais</a></li>-->
                </ul>
            </li>
        <?php } else { ?>    
            <li class="treeview"><a href="#"><i class="icon icon-sailing-boat-water purple-text s-18"></i> <span class="text-black">Référentiels de Base</span> <i class="icon icon-angle-left s-18 pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class=""><a href="../../../app/web/contents/baremes-liste.page.php"><i class="icon icon-folder5"></i>Barèmes Kilométriques</a></li>
                    <li class=""><a href="../../../app/web/contents/etats-liste.page.php"><i class="icon icon-folder5"></i>Etats d'Avancement</a></li>
                    <li class=""><a href="../../../app/web/contents/profils-liste.page.php"><i class="icon icon-folder5"></i>Profils des Employés</a></li>
                    <li class=""><a href="../../../app/web/contents/type-activites-liste.page.php"><i class="icon icon-folder5"></i>Types d'Activité</a></li>
                    <li class=""><a href="../../../app/web/contents/type-clients-liste.page.php"><i class="icon icon-folder5"></i>Types de Client</a></li>
                    <li class=""><a href="../../../app/web/contents/typologies-liste.page.php"><i class="icon icon-folder5"></i>Typologies des Frais</a></li>
                    <li class=""><a href="../../../app/web/contents/zones-liste.page.php"><i class="icon icon-folder5"></i>Zones Géographiques</a></li>
                </ul>
            </li>
            <li class="treeview"><a href="#"><i class="icon icon icon-package blue-text s-18"></i><span class="text-black">Gestion des Missions</span><i class="icon icon-angle-left s-18 pull-right"></i></a><!--open active -->
                <ul class="treeview-menu">
                    <li><a href="../../../app/web/contents/missions-liste.page.php"><i class="icon icon-circle-o"></i>Liste des Missions</a></li>
                    <li><a href="#"><i class="icon icon-angle-double-up"></i>Demandes d'Avances </a></li>
                    <li><a href="#"><i class="icon icon-angle-double-down"></i>Demandes de Remboursement </a></li>
                    <li><a href="#"><i class="icon icon-money-bag"></i>Détails des Frais </a></li>
                    <li><a href="#"><i class="icon icon-folder5"></i>Justificatifs</a></li>
                </ul>
            </li>
            <li class="treeview"><a href="#"><i class="icon icon-sailing-boat-water purple-text s-18"></i> <span class="text-black">Gestion des Demandes</span> <i class="icon icon-angle-left s-18 pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class=""><a href="../../../app/web/contents/baremes-liste.page.php"><i class="icon icon-folder5"></i>Demandes d'Avance</a></li>
                    <li class=""><a href="../../../app/web/contents/etats-liste.page.php"><i class="icon icon-folder5"></i>Demandes de Remboursement</a></li>
                    <!--<li class=""><a href="../../../app/web/contents/profils-liste.page.php"><i class="icon icon-folder5"></i>Détails des Frais</a></li>-->
                </ul>
            </li>
            <li class="treeview"><a href="#"><i class="icon icon-account_box light-green-text s-18"></i><span class="text-black">Administration</span><i class="icon icon-angle-left s-18 pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="icon icon-profile-1"></i>Gestion des Profils</a></li>
                    <li class=""><a href="../../../app/web/contents/users-liste.page.php"><i class="icon icon-user"></i>Gestion des Utilisateurs</a></li>
                    <li><a href="#"><i class="icon icon-key3"></i>Réinitialisation Password</a></li>
                </ul>
            </li>
            <?php } ?>  
            <!--<li class="treeview"><a href="../../../app/web/contents/logout.php"><i class="icon icon-sign-out s-18"></i> <span class="text-black">Déconnexion</span></a></li>-->
        </ul>
    </section>
</aside>

