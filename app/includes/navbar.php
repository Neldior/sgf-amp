<?php ?>
<div class="sidebar-left">
    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-light pt-2 pb-2 pl-4 pr-2">
                <div class="search-bar">
                    <input class="transparent s-24 text-black b-0 font-weight-lighter w-128 height-50" type="text" placeholder="Rechercher...">
                </div>
                <a href="#" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation" class="paper-nav-toggle paper-nav-white active "><i></i></a>
            </div>
        </div>
    </div>
    <div class="sticky">
        <div class="navbar navbar-expand navbar-dark d-flex justify-content-between bd-navbar blue accent-3">
            <div class="relative">
                <a href="#" data-toggle="push-menu" class="paper-nav-toggle pp-nav-toggle"><i></i>
                </a>
            </div>
            <!--Top Menu Start -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown custom-dropdown user user-menu">
                        <a href="#" class="nav-link text-white bolder" data-toggle="dropdown">
                            <img class="user-image" src="../../assets/img/dummy/<?= $avataruser ?>" alt="<?= $nomUser; ?>">
                            <?= $salut." ".$civilite." ".$nomUser;  ?>
                        </a>
                        <div class="dropdown-menu p-4 dropdown-menu-right">
                            <div class="row box justify-content-between my-4">
                                <div class="col">
                                    <a href="../../../app/web/contents/employe-profil.page.php">
                                        <i class="icon-user-circle-o light-green lighten-1 avatar r-5"></i>
                                        <div class="pt-1">Profil</div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="../../../app/web/contents/employe-pass.page.php">
                                        <i class="icon-key3 purple lighten-2 avatar r-5"></i>
                                        <div class="pt-1">Password</div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="../../../app/web/contents/logout.php">
                                        <i class="icon-sign-out pink lighten-2 avatar r-5"></i>
                                        <div class="pt-1">Déconnexion</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
