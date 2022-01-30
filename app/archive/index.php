<!DOCTYPE html>
<html lang="fr">
    <?php require_once('app/includes/init/init-header.php'); ?>
    <body class="light">
        <?php require_once('app/includes/init/init-preloader.php'); ?>
        <div id="app">
            <main>
                <div id="primary" class="p-t-b-80 height-full">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 mx-md-auto paper-card">
                                <div class="text-center" style="margin: 0 -5px">
                                    <h1 class="text-red bolder">SGF-AMP</h1>
                                </div>
                                <div class="text-center" style="margin: 0 -5px">
                                    <img src="app/assets/img/dummy/u4.png" alt="">
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #primary -->
            </main>
        </div>
        <?php require_once('app/includes/init/init-js.php'); ?>
        <script>
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
                    url: "app/web/controller/validation.php", method: "POST", data: o.serialize(),
                    dataType: "text",
                    success: function(data){
                        //waitingBoxUI(false); 
                        console.log(data);
                        d = data.split("##"); 
                        if(d[0]==="ERR") msgBoxUI(d[1]);
                        else document.location.href="app/web/contents/accueil.php";
                    }
                });
                return false;
            }
        </script>
    </body>
</html>