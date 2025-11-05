jQuery(document).ready(function(){

    jQuery(".search input.for-search").on('keyup', function(){getPropertyCount(jQuery(this))});
    jQuery(".search select").bind('change', function(){getPropertyCount(jQuery(this))});
    jQuery(".search input[type='radio']").bind('change', function(){getPropertyCount(jQuery(this))});
    jQuery(".search input[type='checkbox']").bind('change', function(){getPropertyCount(jQuery(this))});

});
function getPropertyCount(objEle)
{

    var formId = objEle.parents('form').attr('id');

    var send_data = jQuery('#'+formId).serializeArray();
    send_data.push({name:'containerId',value:formId});
    send_data.push({name:'action',value:adminAjax.action});
    send_data.push({name:'containerId',value:formId});
    send_data.push({name:'ajax_mod',value:'listing-count'});
    // send_data.push({name:'ajax_in_site',value:true});

    //xajax_ListingAjaxCall('Search','getPropertyCount',{containerId:formId, data: xajax.getFormValues(formId)});
    jQuery.jAjaxCall({
        abort_on_new_req    :   true,
        xhr_area    :   '',
        xhr_module  :   '',
        xhr_action  :   '',
        send_data   :    send_data,
        xhr_url     :   adminAjax.ajaxurl,
        xhr_timeout :   (1000*30),
        callback_on_success: function(data, textStatus, jqXHR){
            console.log('Save successfully');
        }
    },'Listing');

}