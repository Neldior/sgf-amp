<!DOCTYPE html>
<html lang="fr">
    <?php include('app/includes/init/init-header.php'); ?>
    <body class="light">
        <?php include('app/includes/init/init-preloader.php'); ?>
        <div id="app">
            <main>
                <div id="primary" class="p-t-b-80 height-full">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 mx-md-auto paper-card">
                                <div class="text-center" style="margin: 0 -5px">
                                    <img src="old/assets/img/dummy/u4.png" alt="">
                                    <h3 class="mt-2"><strong>Connexion</strong></h3>
                                    <p class="p-t-b-0">Veuillez saisir votre login et votre mot de passe !</p>
                                </div>
                                <form id="form_login" method="post" action="#" onsubmit="return fnLogin();">
                                    <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                                        <input type="text" id="log" name="log" class="form-control form-control-lg" value="" placeholder="Login (Identifiant/Email)" autofocus autocomplete="on">
                                    </div>
                                    <div class="form-group has-icon"><i class="icon-user-secret"></i>
                                        <input type="password" id="pwd" name="pwd" class="form-control form-control-lg" value="" placeholder="Mot de Passe" autocomplete="on">
                                    </div>
                                    <button type="submit" onclick="//return fnLogin();" class="btn btn-success btn-lg btn-block waves-effect"><i class="icon icon-sign-in"></i><strong style="font-size: 16px !important;">Se Connecter</strong></button>
                                    <div class="row form-group p-0 m-0">
                                        <div class="col-5 text-left p-0 m-0" style="margin-top: 5px !important;">
                                            <input type="checkbox" id="checkbox" name="checkbox">
                                            <label for="checkbox"><strong style="font-size: 14px !important;">Se Souvenir</strong></label>
                                        </div>
                                        <div class="col-7 text-right p-0 m-0">
                                            <p class="forget-pass text-right"><a href="#" class="text-green"><strong style="font-size: 14px !important;">Mot de Passe oubli&eacute; ?</strong></a></p>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-lg btn-block btn-social facebook"> <i class="icon-facebook"></i> Facebook</a>
                                    <a href="#" class="btn btn-lg btn-block btn-social twitter"><i class="icon-twitter"></i> Twitter </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #primary -->
            </main>
        </div>
        <?php include('app/includes/init/init-js.php'); ?>
        <script type="text/javascript">
            $(document).ready(function() {
                /*$("#myMessageBoxUI").find("#closeDialog").on('click', function(){
                    if(CALLBACK !== "") eval(CALLBACK);
                });*/
            });

            function fnLogin(){
                var o = $('#form_login');
                log = o.find('#log'); pwd = o.find('#pwd');
                if($.trim(log.val())===""){msgBoxUI("Saisir votre identifiant ou Login.", "log.focus();"); return false;}
                if($.trim(pwd.val())===""){msgBoxUI("Saisir votre Mot de passe.","pwd.focus();"); return false;}
                //waitingBoxUI(true);
                $.ajax({
                    url: "app/web/contents/controller/validation.php", method: "POST", data: o.serialize(),
                    dataType: "text",
                    success: function(data){
                        //waitingBoxUI(false); //console.log(data);
                        d = data.split("##");
                        if(d[0]==="ERR") msgBoxUI(d[1]);
                        else document.location.href="app/web/contents/accueil.php";
                    }
                });
                return false;
            }
        </script>

        <div id="waitingBoxUI" class="alertify" style="display: none; overflow: scroll;">
            <div class="dialog">
                <div>
                    <p class="msg" style="text-align: center; color: black;">Veuillez patienter...</p>
                    <div class="preloader pl-lg pls-green text-center">
                        <svg class="pl-circular text-center" style="align-items: center !important;" viewBox="25 25 50 50">
                            <circle class="plc-path" cx="50" cy="50" r="20"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myMessageBoxUI" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:35%; color:#01579b;"><!--width:35%; -->
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #01579b; padding: 10px 20px;">
                        <div class="row form-group" style=" margin: 0 0">
                            <h5 class="modal-title" id="H5"> <b style="color: #fff; font-size: 16px">Information</b></h5>
                            <button type="button" class="close text-right" style="color:#fff; align-items: right; " data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body bg-white pbn"></div>
                    <div class="modal-footer pull-center bg-white mt30" style="border-top: 1px solid #e5e5e5 !important; padding: 0 !important; padding-right: 10px !important;">
                        <div class="row form-group" style="margin-top: 10px">
                            <div class="col-lg-12 pull-right">
                                <button type="reset" style="padding: 0 30px" class="btn btn-danger dark" data-dismiss="modal"><b> OK </b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myConfirmBoxUI" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="myConfirmBoxUI" aria-hidden="true">
            <div class="modal-dialog modal-xs" style="color:#01579b;"><!--width:35%; -->
                <form id="form_decon" onsubmit="//return logout()" action="" role="form" method="POST">
                    <div class="modal-content" style="margin-bottom:-10px">
                        <div class="modal-header" style="background-color: #01579b; text-align: left; padding: 10px 20px; margin-bottom:-10px">
                            <div class="row form-group" style="margin-top: -15px; padding: 15px 10px">
                                <p class="modal-title" style="color: #fff; font-size:16px"><b>Confirmation</b></p>
                                <button type="button" class="close" style="color:#fff" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        </div>
                        <div class="modal-body bg-white pbn" style="margin-bottom: -15px;margin-top:-15px"></div>
                        <div class="modal-footer pull-center bg-white mtn mbn">
                            <button style="padding: 0 30px;" type="button" class="btn btn-danger dark" data-dismiss="modal"><span class="fa fa-close"></span><b style="font-size:12px"> ANNULER </b></button>
                            <button id="confirmValidate" style="padding: 0 30px;" type="submit" class="btn btn-primary dark" data-dismiss="modal"><span class="fa fa-check"></span><b style="font-size:12px"> VALIDER </b></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </body>
</html>