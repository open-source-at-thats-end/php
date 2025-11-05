jQuery(document).ready(function(){

    jQuery('a.vlink_listing, a.vlink_view').unbind('click')
    jQuery('a.vlink_listing, a.vlink_view').live('click', function(){

        var href = jQuery(this).data('link');

        jQuery.colorbox({
            href:href,
            title: jQuery(this).data('title'),
            iframe:true,
            fastIframe: false,
            overlayClose:false,
            innerWidth:'90%',
            innerHeight:'800'
        });
    });

    bindPagination();
    bindDisplayPage();
    search();
});
function bindDisplayPage(){

    jQuery("#page_size").bind('change', function(){
        var send_data = jQuery('#frmPredSearch').serializeArray();
        send_data.push({name:'cpage',value:jQuery(this).data('page')});
        send_data.push({name:'psearch_param',value:searchParam});
        // send_data.push({name:'psearch_id',value:jQuery('#psearch_id').val()});
        send_data.push({name:'page_size',value:jQuery('#page_size').val()});
        send_data.push({name:'action',value: objpredeAjax.action});
        send_data.push({name:'ajax_mod',value:'pre-list-pagination'});
        // send_data.push({name:'ajax_in_site',value:true});

        jQuery.jAjaxCall({
            abort_on_new_req    :   true,
            xhr_area    :   '',
            xhr_module  :   '',
            xhr_action  :   '',
            send_data   :   send_data,
            xhr_url     :   objpredeAjax.predef_action,
            xhr_timeout :   (1000*30),
            callback_on_success: function(data, textStatus, jqXHR){
                bindPagination();
                bindDisplayPage();
                console.log('Save successfully');
            }
        },'manag');
    });

}
function search()
{
    jQuery('#presearch').on('click',function () {
        var send_data = jQuery('#FrmPre').serializeArray();
        send_data.push({name:'action',value: objpredeAjax.action});
        send_data.push({name:'ajax_mod',value:'master-pre-search'});

        jQuery.jAjaxCall({
            abort_on_new_req    :   true,
            xhr_area    :   '',
            xhr_module  :   '',
            xhr_action  :   '',
            send_data   :   send_data,
            xhr_url     :   objpredeAjax.predef_action,
            xhr_timeout :   (1000*30),
            callback_on_success: function(data, textStatus, jqXHR){
                bindPagination();
                bindDisplayPage();

            }
        },'search');
    });

    jQuery('#FrmPre').on('keypress',function(e) {
        if(e.which == 13) {
            var send_data = jQuery('#FrmPre').serializeArray();
            send_data.push({name:'action',value: objpredeAjax.action});
            send_data.push({name:'ajax_mod',value:'master-pre-search'});

            jQuery.jAjaxCall({
                abort_on_new_req    :   true,
                xhr_area    :   '',
                xhr_module  :   '',
                xhr_action  :   '',
                send_data   :   send_data,
                xhr_url     :   objpredeAjax.predef_action,
                xhr_timeout :   (1000*30),
                callback_on_success: function(data, textStatus, jqXHR){
                    bindPagination();
                    bindDisplayPage();

                }
            },'search');
        }
    })
}
function bindPagination(){

    jQuery('.pagination ul li a').on('click', function() {
        if(jQuery(this).data('page') > 0)
        {
            var send_data = jQuery('#frmPredSearch').serializeArray();
            send_data.push({name:'cpage',value:jQuery(this).data('page')});
            send_data.push({name:'psearch_param',value:searchParam});
            // send_data.push({name:'psearch_id',value:jQuery('#psearch_id').val()});
            send_data.push({name:'page_size',value:jQuery('#page_size').val()});
            send_data.push({name:'action',value: objpredeAjax.action});
            send_data.push({name:'ajax_mod',value:'master-prelist-pagination'});
            // send_data.push({name:'ajax_in_site',value:true});

            jQuery.jAjaxCall({
                abort_on_new_req    :   true,
                xhr_area    :   '',
                xhr_module  :   '',
                xhr_action  :   '',
                send_data   :   send_data,
                xhr_url     :   objpredeAjax.predef_action,
                callback_on_success: function(data, textStatus, jqXHR){
                    bindPagination();
                    bindDisplayPage();
                    console.log('Save successfully');
                }
            },'manag');
        }
        return false;
    });

}