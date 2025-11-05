// var minprice, maxprice, startprice, endprice;
jQuery(document).ready(function(){

    jQuery(".search input.for-search").on('keyup', function(){getPropertyCount(jQuery(this))});
    jQuery(".search select").bind('change', function(){getPropertyCount(jQuery(this))});
    jQuery(".search input[type='radio']").bind('change', function(){getPropertyCount(jQuery(this))});
    jQuery(".search input[type='checkbox']").bind('change', function(){getPropertyCount(jQuery(this))});


    jQuery("#agent_sys_name").on('change', function () {

        if (jQuery('#agent_sys_name').val() == 2)
        {
            jQuery('#actris').removeClass('d-none');
            jQuery('#miami').addClass('d-none');
        }
        else
        {
            jQuery('#miami').removeClass('d-none');
            jQuery('#actris').addClass('d-none');
        }

        if (jQuery('.sys_name_change').val() == 'No')
        {
            jQuery('.sys_name_change').val('Yes');
        }
    });

    if (jQuery('#agent_sys_name').val() == 2)
    {
        jQuery('#actris').removeClass('d-none');
        jQuery('#miami').addClass('d-none');
    }
    else
    {
        jQuery('#miami').removeClass('d-none');
        jQuery('#actris').addClass('d-none');
    }

   /* startprice = 0;
    endprice = 100000000;

    minprice = (minprice != 0 ? minprice : startprice);
    maxprice = (maxprice != 0 ? maxprice : endprice);
    bindPriceRangeSlider(startprice, endprice, 50000, parseInt(minprice), parseInt(maxprice));*/
});
/*function bindPriceRangeSlider(start, end, step, minp, maxp){
    jQuery( "#price-range" ).slider({
        orientation: "horizontal",
        range: true,
        min: start,
        max: end,
        step: step,
        values: [ minp, maxp ],
        slide: function( event, ui ) {

            jQuery( "#minprice" ).val( ui.values[ 0 ]);
            jQuery( "#maxprice" ).val( ui.values[ 1 ]);
            getPropertyCount(jQuery(this))
        }
    });
}*/
function getPropertyCount(objEle)
{
    var formId = objEle.parents('form').attr('id');

    var send_data = jQuery('#'+formId).serializeArray();
    send_data.push({name:'containerId',value:formId});
    send_data.push({name:'action',value:adminAjax.action});
    send_data.push({name:'containerId',value:formId});

    // send_data.push({name:'ajax_in_site',value:true});
    if(formId == 'frmSaveSearch'){
     send_data.push({name:'ajax_mod',value:'saved-listing'});
    }
    else{
     send_data.push({name:'ajax_mod',value:'pred-listing'});
    }
    //xajax_ListingAjaxCall('Search','getPropertyCount',{containerId:formId, data: xajax.getFormValues(formId)});
    jQuery.jAjaxCall({
        abort_on_new_req    :   true,
        xhr_area    :   '',
        xhr_module  :   '',
        xhr_action  :   '',
        send_data   :    send_data,
        xhr_url     :   adminAjax.ajaxurl,
        callback_on_success: function(data, textStatus, jqXHR){
            console.log('Save successfully');
        },
    },'Listing');

}