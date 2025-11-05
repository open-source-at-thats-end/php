jQuery(document).ready(function(){
    jQuery('a.vlink_listing, a.vlink_view').unbind('click')
    jQuery('a.vlink_listing, a.vlink_view').on('click', function(){

        var href = jQuery(this).data('link');
        /*var width = jQuery(this).data('pop-width') ? jQuery(this).data('pop-width') : 900;
        var height = jQuery(this).data('pop-height') ? jQuery(this).data('pop-height') : 800;*/

        // Called directly, without assignment to an element:
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
  //  search();
    //jQuery('#presearch').trigger('click');

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
            xhr_timeout :   (1000*10),
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
        send_data.push({name:'ajax_mod',value:'pre-search'});

        jQuery.jAjaxCall({
            abort_on_new_req    :   true,
            xhr_area    :   '',
            xhr_module  :   '',
            xhr_action  :   '',
            send_data   :   send_data,
            xhr_url     :   objpredeAjax.predef_action,
            xhr_timeout :   (1000*30),
            callbefore_send: function (jqXHR, settings) {
                jQuery('#pre-list-holder').html('<div class="loader-small"></div>');
            },
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
            send_data.push({name:'ajax_mod',value:'pre-search'});

            jQuery.jAjaxCall({
                abort_on_new_req    :   true,
                xhr_area    :   '',
                xhr_module  :   '',
                xhr_action  :   '',
                send_data   :   send_data,
                xhr_url     :   objpredeAjax.predef_action,
                xhr_timeout :   (1000*30),
                callbefore_send: function (jqXHR, settings) {
                    jQuery('#pre-list-holder').html('<div class="loader-small"></div>');
                },
                callback_on_success: function(data, textStatus, jqXHR){
                    bindPagination();
                    bindDisplayPage();

                }
            },'search');
        }
    })
}
function Show_MatchedListing()
{

    var searchForm = document.getElementById('frmPredSearch');

    popupWindowURL('','Popup_Window', 1250, 600, false, false, true, false, false);
    //var w = window.open('listing.php','Popup_Window','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=400,height=300,left = 312,top = 234');
    searchForm.target = 'Popup_Window';
    /*To overwrite action value of post passing Action in get as only true*/
    // searchForm.action = '/wp-admin/admin.php?page=lpt-predefined&action=view';
    searchForm.action = url+'&action=view';
    searchForm.submit();
    // searchForm.action = '/wp-admin/admin.php?page=lpt-predefined';
    setTimeout(function () {
        bindPagination();
        bindDisplayPage();
    }, 1000);


}
function resetFormAttributes(form)
{
    form.action = '';
    form.target = '';
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
                send_data.push({name:'ajax_mod',value:'pre-list-pagination'});
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
function popupWindowURL(url, winname, w, h, menu, resize, scroll, toolBar, fullScreen)
{
    var x = (screen.width-w)/2;
    var y = (screen.height-h)/3;

    if (winname == null)
        winname = "newWindow";

    if (w == null)
        w = 800;

    if (h == null)
        h = 600;

    if (resize == null)
        resize = 1;

    menutype   = "nomenubar";
    resizetype = "noresizable";
    scrolltype = "noscrollbars";
    toolbar    = "no";

    if (menu)
        menutype = "menubar";

    if (resize)
        resizetype = "resizable";

    if (scroll)
        scrolltype = "scrollbars";

    if (toolBar)
        toolbar = "yes";

    if(fullScreen)
        cwin = window.open(url,winname,"channelmode=1,fullscreen=1,toolbar=" + toolbar);
    else
        cwin = window.open(url,winname,"top=" + y + ",left=" + x + ",screenX=" + x + ",screenY=" + y + "," + "status," + menutype + "," + scrolltype + "," + resizetype + ",width=" + w + ",height=" + h+ ",toolbar=" + toolbar);

    if (!cwin.opener)
        cwin.opener = self;

    cwin.focus();

    return true;
}