<?php ?>
<!--JQuery JS-->
<script src="../../assets/js/jquery-3.6.0.min.js" ></script>

<!--/#app -->
<script src="../../assets/js/app.js"></script>

<script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)</script>

<!-- Datatable File -->
<script src="../../assets/cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="../../assets/cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        myModal = $('#GenericModal');
        projetName = "SGF-AMP : ";

        $('#dtbl-example, #dtbl-example1, #dtbl-example2, #dtbl-example3, #dtbl-example4').DataTable({
            language: {
                url: "../../assets/cdn.datatables.net/French.json"
            },
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Exporter en JSON',
                    action: function ( e, dt, button, config ) {
                        var data = dt.buttons.exportData();
                        $.fn.dataTable.fileSave(new Blob([JSON.stringify(data)]), 'Export.json');
                    }
                }
            ],
            pageLength:5
        });

    });
    function closeModal(){
        myModal.find('.modal-body').html('');
        myModal.modal('hide');
    }
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
        CALLBACK = callback !== undefined ? callback : ""; //CALLBACK = callback ? callback : "";
        var box = $("#myMessageBoxUI");
        box.find(".modal-body").html("<h3 style='line-height: 30px; margin: 0 !important; font-size: 14px; font-weight: bold'>"+texte+"</h3>");
        box.modal({backdrop: true, keyboard: true, show: true});
        if(w!==undefined) box.find('.dialog div').css({width:w+'%', height:'100%'});
    }
    
    function msgBoxUI0(texte, callback, w){
        CALLBACK = callback !== undefined ? callback : "";
        alertify.okBtn("Oui").alert("<b><u>Info SUPERPLUS</u> : </b><br>" + texte, function(){
            if(CALLBACK !== "") eval(CALLBACK);
        });
        if(w!==undefined) $('.alertify').find('.dialog div').css({width:w+'%', height:'100%'});
    }

    function confirmActionUI(texte, callback) {
        CALLBACK = callback ? callback : "";
        var box = $("#myConfirmBoxUI");
        box.find(".modal-body").html("<h3 style='line-height: 30px; margin: 0 !important; font-size: 14px;'>"+texte+"</h3>");
        box.modal({backdrop: true, keyboard: true, show: true});
        return false;
    }
</script>

<div class="modal fade" id="GenericModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="GenericModal" aria-hidden="true">
    <form id="formModal" class="form-material" onsubmit="" name="formModal" method="POST" autocomplete="on"  enctype="multipart/form-data">
        <input type="hidden" name="action" id="action" value="">
        <input type="hidden" name="from" id="from" value="">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0d4ab1!important; color: white;">
                    <h5 class="modal-title text-white" id="modalTitle"><strong class="text-white">Titre</strong></h5>
                    <button type="button" class="close text-right text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="body_screen" class="modal-body" style="margin: -5px 10px"></div>
                <div class="modal-footer bg-white m-r-20">
                    <button id="btnFermer" style="padding: 0 20px;" type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close"></i><strong>FERMER</strong></button>
                    <button id="btnAnnuler" style="padding: 0 20px;" type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-close"></i><strong>ANNULER</strong></button>
                    <button id="btnValider" style="padding: 0 20px; " type="submit" class="btn btn-success bg-green waves-effect"><i class="icon-check"></i><strong>ENREGISTRER</strong></button>
                </div>
            </div>
        </div>
    </form>
</div>
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
<div class="modal fade" id="myMessageBoxUI" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="myMessageBoxUI" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width:35%; color:#01579b;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #01579b; padding: 10px 20px;">
                <div class="row form-group" style=" margin: 0 0">
                    <h5 class="modal-title" id="H5"> <b style="color: #fff; font-size: 16px">SGF-AMP : Information</b></h5>
                    <button type="button" class="close text-right" style="color:#fff;" data-dismiss="modal" aria-hidden="true">&times;</button>
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
    <div class="modal-dialog modal-dialog-centered modal-xs" style="color:#01579b;"><!--width:35%; -->
        <form id="form_decon" onsubmit="//return logout()" method="POST">
            <div class="modal-content" style="margin-bottom:-10px">
                <div class="modal-header" style="background-color: #01579b; text-align: left; padding: 10px 20px; margin-bottom:-10px">
                    <div class="row form-group" style="margin-top: -15px; padding: 15px 10px">
                        <p class="modal-title" style="color: #fff; font-size:16px"><b>SGF-AMP : Confirmation</b></p>
                        <button type="button" class="close text-right" style="color:#fff" data-dismiss="modal" aria-hidden="true">&times;</button>
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