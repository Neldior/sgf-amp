<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="assets/img/basic/favicon.ico" type="image/x-icon">
        <title>Paper</title>
        <!-- CSS -->
        <link rel="stylesheet" href="assets/css/app.css">
        <style>
            .loader {
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: #F5F8FA;
                z-index: 9998;
                text-align: center;
            }
            .plane-container {
                position: absolute;
                top: 50%;
                left: 50%;
            }
        </style>
        <script>(function(w,d,u){w.readyQ=[];w.bindReadyQ=[];function p(x,y){if(x=="ready"){w.bindReadyQ.push(y);}else{w.readyQ.push(x);}};var a={ready:p,bind:p};w.$=w.jQuery=function(f){if(f===d||f===u){return a}else{p(f)}}})(window,document)</script>
    </head>
    <body class="light">
        <!-- Pre loader -->
        <div id="loader" class="loader">
            <div class="plane-container">
                <div class="preloader-wrapper small active">
                    <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                    </div>
                    <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                    </div>
                    <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                    </div>
                    <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="app">
            <main>
                <div id="primary" class="p-t-b-80 height-full">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 mx-md-auto paper-card">
                                <div class="text-center">
                                    <img src="assets/img/dummy/u4.png" alt="">
                                    <h3 class="mt-2">Connexion</h3>
                                    <p class="p-t-b-0">Veuillez saisir votre login et votre mot de passe pour vous connecter...</p>
                                </div>
                                <form action="../app/web/contents/accueil.php">
                                    <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                                        <input type="text" class="form-control form-control-lg" placeholder="Login (Identifiant/Email)">
                                    </div>
                                    <div class="form-group has-icon"><i class="icon-user-secret"></i>
                                        <input type="text" class="form-control form-control-lg" placeholder="Mot de Passe">
                                    </div>
                                    <input type="submit" class="btn btn-success btn-lg btn-block" value="Se Connecter">
                                    <p class="forget-pass text-right"><a href="#" class="text-green">Mot de Passe oubli&eacute; ?</a></p>
                                    <a href="#" class="btn btn-lg btn-block btn-social facebook"> <i class="icon-facebook"></i> Utiliser Facebook</a>
                                    <a href="#" class="btn btn-lg btn-block btn-social twitter"><i class="icon-twitter"></i> Utiliser Twitter </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #primary -->
            </main>
        </div>
        <!--/#app -->
        <script src="assets/js/app.js"></script>
        <script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)</script>
    </body>
</html>