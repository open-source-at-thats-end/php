jQuery(document).ready(function(){

    bindSMPopup();
    jQuery('.btn-cancel').on('click', function () {
        jQuery('#modal-sm-popup').hide();
        jQuery("#modal-sm-popup").addClass("fade");
    });
});

function bindSMPopup()
{
    jQuery('.popup-modal-sm').unbind('click');
    jQuery('.popup-modal-sm').on('click', function(){

        var url  =   jQuery(this).attr('data-url');
        var type =   jQuery(this).attr('data-target');

        jQuery('#modal-sm-popup .modal-content').html('<p class="text-center"><br>Loading ...</p>');

        jQuery('#modal-sm-popup').modal('show');
        jQuery("#modal-sm-popup").removeClass("fade");


        jQuery('#modal-sm-popup .modal-content').load(url, function(e){

                /*jQuery('.btn-cancel').on('click', function () {
                    jQuery('#modal-sm-popup').hide();
                    jQuery(".modal-backdrop").remove();
                    jQuery("#modal-sm-popup").addClass("fade");
                });*/
        });
    });

}