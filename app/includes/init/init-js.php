<?php ?>
<!--JQuery JS-->
<script src="app/assets/js/jquery-3.6.0.min.js" ></script>
<!--/#app -->
<script src="app/assets/js/app.js"></script>
<script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)</script>
<script>
    
    function waitingBoxUI(state){
        wait = $("#waitingBoxUI");
        if(state) {
            wait.modal({backdrop: false, keyboard: false, show: true});
            wait.find('.dialog div').css({width:'480px', height:'170x'});
            wait.find('.preloader').css({width:'100px', height:'100px'});
            wait.show();
        } else wait.hide();
    }

    function msgBoxUI(texte, callback, w) {
        CALLBACK = callback !== undefined ? callback : "";
        var box = $("#myMessageBoxUI");
        box.find(".modal-body").html("<h3 style='line-height: 30px; margin: 0 !important; font-size: 14px; font-weight: bold'>"+texte+"</h3>");
        box.modal({backdrop: true, keyboard: true, show: true});
        //if(w!==undefined) box.find('.dialog div').css({width:w+'%', height:'100%'});
        if(w!==undefined) $('.alert').find('.dialog div').css({width:w+'%', height:'100%'});
    }

    function confirmActionUI(texte, callback, w) {
        CALLBACK = callback ? callback : "";
        var box = $("#myConfirmBoxUI");
        box.find(".modal-body").html("<h3 style='line-height: 30px; margin: 0 !important; font-size: 14px;'>"+texte+"</h3>");
        box.modal({backdrop: true, keyboard: true, show: true});
        if(w!==undefined) box.find('.dialog div').css({width:w+'%', height:'100%'});
        return false;
    }
    
    
    /*function msgBoxUI(texte, callback, w){
        CALLBACK = callback !== undefined ? callback : "";
        alertify.okBtn("OK").alert("<b><u>Info SUPERPLUS</u> : </b><br>" + texte, function(){
            if(CALLBACK !== "") eval(CALLBACK);
        });
        if(w!==undefined) $('.alertify').find('.dialog div').css({width:w+'%', height:'100%'});
        waitingBoxUI(false);
    }

    function confirmBoxUI(texte, callback, w){
        message = "<b><u>Info SUPERPLUS</u> : </b><br>" + texte;
        alertify.okBtn("Oui").cancelBtn("Non").confirm(message, function(){
            if(callback !== '') eval(callback)
        }, function(){
        });
        if(w!==undefined) $('.alertify').find('.dialog div').css({width:w+'%', height:'100%'});
        return false;
    }*/


    function fnDeconnexion(){
        message = "<b><u>Info SUPERPLUS</u> : </b><br>Voulez-vous vous déconnecter du système ?";
        alertify.okBtn("Oui").cancelBtn("Non").confirm(message, function(){
            waitingBoxUI(true);
            href = dossierSite + "/administration/logout/";
            window.location.href = href;
        }, function(){
        });
        return false;
    }

    function fnDeconnexionCheck(){
        message = "<b><u>Info SUPERPLUS</u> : </b><br>Voulez-vous vous déconnecter du système ?";
        alertify.okBtn("Oui").cancelBtn("Non").confirm(message, function(){
            waitingBoxUI(true);
            s = apipost("users/deconnexion-sys"); //console.log(s);
            $.ajax(s).done(function(response){
                waitingBoxUI(false);
                //console.log(response);
                if (response.status) {
                    msg = "<b><u>Info SUPERPLUS</u> : </b><br>"+response.statusmessage+"<br><b>Voulez-vous la cl&ocirc;turer maintenant ?</b>";
                    alertify.okBtn("Oui").cancelBtn("Non").confirm(msg, function(){
                        href = dossierSite + "/administration/recettes/cloture/";
                        window.location.href = href;
                    }, function(){});
                }
                else {
                    href = dossierSite + "/administration/logout/";
                    window.location.href = href;
                }
            }).fail(function(e){
                msgBoxUI("Error : " + e.responseText);
            });
        }, function(){
        });
        return false;
    }

    function numberConvert(bytes){
        result = "0";
        bytes = parseFloat(bytes);
        arBytes = {
            "0": {"UNIT": "T", "VALUE": Math.pow(1000, 4)},
            "1": {"UNIT": "B", "VALUE": Math.pow(1000, 3)},
            "2": {"UNIT": "M", "VALUE": Math.pow(1000, 2)},
            "3": {"UNIT": "K", "VALUE": 1000},
            "4": {"UNIT": "", "VALUE": 1}
        };

        for(ar in arBytes){
            if(!arBytes.hasOwnProperty(ar)) continue;
            arItem = arBytes[ar];
            if(bytes >= arItem["VALUE"]){
                result = bytes / arItem["VALUE"];
                result = "~" + Math.ceil(parseFloat(result)) + " " + arItem["UNIT"];
                break;
            }
        }
        return result;
    }

    function format(valeur, decimal, separateur){//formate un chiffre avec 'decimal' chiffres après la virgule et un separateur
        var deci = Math.round(Math.pow(10, decimal) * (Math.abs(valeur) - Math.floor(Math.abs(valeur))));
        var val = Math.floor(Math.abs(valeur));
        if((decimal === 0) || (deci === Math.pow(10, decimal))){
            val = Math.floor(Math.abs(valeur));
            deci = 0;
        }
        var val_format = val + "";
        var nb = val_format.length;
        for(var i = 1; i < 4; i++) if(val >= Math.pow(10, (3 * i))) val_format = val_format.substring(0, nb - (3 * i)) + separateur + val_format.substring(nb - (3 * i));
        if(decimal > 0){
            var decim = "";
            for(var j = 0; j < (decimal - deci.toString().length); j++){
                decim += "0";
            }
            deci = decim + deci.toString();
            val_format = val_format + "." + deci;
        }
        if(parseFloat(valeur) < 0){
            val_format = "-" + val_format;
        }
        return val_format;
    }
    
    
</script>
<div class="modal fade" id="myMessageBoxUI" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:35%; color:#01579b;"><!--width:35%; -->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #01579b; padding: 10px 20px;">
                <div class="row form-group" style=" margin: 0 0">
                    <h5 class="modal-title" id="H5"> <b style="color: #fff; font-size: 16px">SGF-AMP : Information</b></h5>
                    <button type="button" class="close text-right" style="color:#fff; align-items: right;" data-dismiss="modal" aria-hidden="true">&times;</button>
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