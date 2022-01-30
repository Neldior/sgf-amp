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
                                <h3 class="my-3"><i class="icon icon-note-important"></i> <strong>Gestion du Mot de passe</strong></h3>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container-fluid my-3">
                    <div class="d-flex row">
                        <div class="col-md-12">
                            <form class="form-material" id="form_pass" method="post" action="#" onsubmit="return fnSavePass();" enctype="multipart/form-data">
                                <input type="hidden" name="from" id="from2" value="save_pass">
                                <div class="card mb-3 shadow no-b r-0">
                                    <div class="card-header white">
                                        <div class="row">
                                            <div class="col-sm-11 text-left" style="margin-top: 5px;">
                                                <h4 class="blue-text"><strong>Modification du Mot de passe</strong></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="margin: -10px 20px -30px 20px">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row" style="margin: 0 50px">
                                                    <div class="col-md-2 mb-3 form-group form-float"></div>
                                                    <div class="col-md-8 mb-3 form-group form-float">
                                                        <div class="mb-3 form-group form-float">
                                                            <div class="form-line mt-auto">
                                                                <label for="passold" class="col-form-label text-black">Actuel Mot de passe <b class="bolder text-red"> <sup>*</sup></b></label>
                                                                <input type="password" id="passold" name="passold" class="form-control" required placeholder="Mot de passe actuel"/>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 form-group form-float">
                                                            <div class="form-line mt-auto">
                                                                <label for="passnew" class="col-form-label text-black">Nouveau Mot de passe<b class="bolder text-red"> <sup>*</sup></b></label>
                                                                <input type="password" id="passnew" name="passnew" class="form-control" required placeholder="Nouveau Mot de passe"/>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 form-group form-float">
                                                            <div class="form-line mt-auto">
                                                                <label for="passnew2" class="col-form-label text-black">Confirmer le nouveau mot de passe <b class="bolder text-red"> <sup>*</sup></b></label>
                                                                <input type="password" id="passnew2" name="passnew2" class="form-control" required placeholder="Nouveau Mot de passe"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mb-3 form-group form-float"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-body text-right" style="margin-top: -20px; margin-right: 20px">
                                        <div class="row text-right" style="margin-right: 20px">
                                            <div class="col-md-10 text-right">
                                                <button type="reset" class="btn btn-danger bg-red waves-effect btn-lg right bolder"><i class="icon-refresh mr-2"></i>Réinitialiser</button>
                                                <button type="submit" class="btn btn-success bg-green waves-effect btn-lg right bolder"><i class="icon-save mr-2"></i>Enregistrer</button>
                                            </div>
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
            function fnSavePass(){
            o = $('#form_pass'); 
            passold = o.find('#passold'); passnew = o.find('#passnew'); passnew2 = o.find('#passnew2');
            if($.trim(passold.val())==="") {msgBoxUI("Veuillez saisir votre mot de passe actuel.", "passold.focus();"); return false;}
            if($.trim(passnew.val())==="") {msgBoxUI("Veuillez saisir votre nouveau mot de passe.", "passnew.focus();"); return false;}
            if($.trim(passnew2.val())==="") {msgBoxUI("Veuillez confirmer votre nouveau mot de passe.", "passnew2.focus();"); return false;}
            if($.trim(passnew.val())===$.trim(passold.val())) {msgBoxUI("L'ancien mot de passe et le nouveau sont identiques. Veuillez modifier le nouveau.", "passnew.focus();"); return false;}
            if($.trim(passnew.val())!==$.trim(passnew2.val())) {msgBoxUI("Veuillez conformer les 2 nouveaux mots de passe.", "passnew2.focus();"); return false;}
            $.ajax ({
                url: "<?= "../controller/processingAdmin.php"; ?>", method: "POST",
                data: o.serialize(),
                success: function(data){
                    console.log(data);
                    rspse = data.split('##');
                    if (rspse[0]==="OK") {
                        msgBoxUI(rspse[1], "window.location.reload();"); 
                        //window.location.href='logout.php';
                    } else msgBoxUI(rspse[1]);
                }
            });
            return false;
        }
        </script>
    </body>
</html>