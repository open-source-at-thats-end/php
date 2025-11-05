jQuery(document).ready(function(){

    bindPagination();
    getListing();
    jQuery("select[name=sort_by]").bind('change', function(){
        getListing();
    });

    bindDisplayPage();

    jQuery('button.view, a.vlink_view').live('click', function(){

        var href = jQuery(this).data('link');
        var width = jQuery(this).data('pop-width') ? jQuery(this).data('pop-width') : 900;
        var height = jQuery(this).data('pop-height') ? jQuery(this).data('pop-height') : 800;

        // Called directly, without assignment to an element:
        jQuery.colorbox({
            href:href,
            title: jQuery(this).data('title'),
            iframe:true,
            fastIframe: false,
            overlayClose:false,
            innerWidth:width,
            innerHeight:height
        });

    });

});
function bindDisplayPage(){
    jQuery("#page_size").bind('change', function(){
        getListing();
    });
}
function bindPagination(){
    if(jQuery('#vmanage').length) {
        jQuery('.pagination ul li a').on('click', function() {

            if(jQuery(this).data('page') > 0)
            {
                __showLoaderLarge2('');

                var send_data = jQuery('#frmlistingSearch').serializeArray();
                send_data.push({name:'cpage',value:jQuery(this).data('page')});
                send_data.push({name:'sort_by',value:jQuery("select[name=sort_by]").val()});
                send_data.push({name:'page_size',value:jQuery('#page_size').val()});
                send_data.push({name:'action',value:objlistAjax.action});
                send_data.push({name:'ajax_mod',value:'manage-listing'});
                send_data.push({name:'ajax_subaction',value:'getpage'});
                // send_data.push({name:'ajax_in_site',value:true});

                subActionHandler(send_data);

            }
            return false;
        });
    }
}
function getListing(){

    __showLoaderLarge2('');

    var send_data = jQuery('#frmlistingSearch').serializeArray();
    send_data.push({name:'cpage',value:1});
    send_data.push({name:'sort_by',value:jQuery("select[name=sort_by]").val()});
    send_data.push({name:'page_size',value:jQuery('#page_size').val()});
    send_data.push({name:'action',value:objlistAjax.action});
    send_data.push({name:'ajax_mod',value:'manage-listing'});
    send_data.push({name:'ajax_subaction',value:'getpage'});
    // send_data.push({name:'ajax_in_site',value:true});

    subActionHandler(send_data);

}
function subActionHandler(send_data){

    jQuery.jAjaxCall({
        abort_on_new_req    :   true,
        xhr_area    :   '',
        xhr_module  :   '',
        xhr_action  :   '',
        send_data   :   send_data,
        xhr_url     :   objlistAjax.listing_action,
        xhr_timeout :   (1000*10),
        callback_on_success: function(data, textStatus, jqXHR){
            bindPagination();
            bindDisplayPage();
            console.log('Save successfully');
        }
    },'manag');

}
function __showLoaderLarge2(title) {
    //jQuery('#list-holder').html(title).addClass('loader-large');
    jQuery('#list-holder').html('<div class="loader-small">' + title + '</div>');
}