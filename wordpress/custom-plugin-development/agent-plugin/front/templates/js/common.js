jQuery(document).ready(function() {

    jQuery('.quick-ptype').on('change',function()
    {
        if(jQuery(this).val() == 'ResidentialLease')
        {
            jQuery('.status').val('rental');
        }
    });
    doAdditionalBinding();
    stopPropagationMenu();
    bind_address_autosuggest();
    bindSMPopup();
    if(jQuery('.te-wrapper').closest('.et_pb_section').height() > 0)
    {
        jQuery('.te-wrapper').css('height',jQuery('.te-wrapper').closest('.et_pb_section').height());
    }
    else{
        jQuery('.te-wrapper').css('height','100vh');
    }

    if(jQuery('.quick-container').is('.qstyle6, .h-container') == false) {
        if (jQuery('.h-container').closest('.et_pb_section').height() > 0) {
            jQuery('.h-container').css('height', jQuery('.h-container').closest('.et_pb_section').height());
        } else {
            jQuery('.h-container').css('height', '100vh');
        }
    }

    jQuery('.lpt-hbtn.buy').on('click', function () {

        jQuery("#frmsearch .home-search-tab .rent").removeClass('active');
        jQuery("#frmsearch .home-search-tab .buy").addClass('active');
        jQuery("#frmsearch #status").val('active');
        /*if(jQuery("#frmsearch #Not_PropertyType").val() != ''){
            jQuery("#frmsearch #PropertyType").val(jQuery("#frmsearch #Not_PropertyType").val());
        }
        else if(jQuery("#frmsearch #PropertyType").val() != ''){
            jQuery("#frmsearch #PropertyType").val(jQuery("#frmsearch #PropertyType").val());
        }else{
            jQuery("#frmsearch #PropertyType").val('ResidentialLease');
        }

        jQuery("#frmsearch #PropertyType").val('');*/
    });

    jQuery('.lpt-hbtn.rent').on('click', function () {

        jQuery("#frmsearch .home-search-tab .buy").removeClass('active');
        jQuery("#frmsearch .home-search-tab .rent").addClass('active');
        jQuery("#frmsearch #status").val('rental');
        /*if(jQuery("#frmsearch #PropertyType").val() != '')
        {
            jQuery("#frmsearch #PropertyType").val(jQuery("#frmsearch #PropertyType").val());
        }
        else if(jQuery("#frmsearch #Not_PropertyType").val() != '')
        {
            jQuery("#frmsearch #PropertyType").val(jQuery("#frmsearch #Not_PropertyType").val());
        }
        else{
            jQuery("#frmsearch #PropertyType").val('ResidentialLease');
        }
        jQuery("#frmsearch #Not_PropertyType").val('');*/
    });

});

function stopPropagationMenu()
{
    // setTimeout(function () {
        jQuery('.dropdown-menu').on('click', function(e) {
            if(jQuery(this).hasClass('dropdown-menu')) {
                e.stopPropagation();
            }
        });
    // }, 500);

}

function doAdditionalBinding() {


    /*if(jQuery('.lg-device-bedbath').length > 0)
    {
        setTimeout(function(){
            jQuery('.lg-device-bed').remove();
        },100);
    }*/
    jQuery('#modal-sm-popup').on('shown.bs.modal', function (event) {

        jQuery('#main-header').css({'z-index' : 'unset'});

        /* if(jQuery(window).width() < 760)
         {
             setTimeout(function () {
                 jQuery('.modal-backdrop').remove();
             }, 300);
         }*/

        //jQuery('#main-header').css({'opacity' : '0', 'z-index' : '99'});
        /*jQuery('.et_builder_inner_content').css({"position": "unset", "z-index": "unset"});
        jQuery('.et_pb_fullwidth_code.et_pb_module').css({"position": "unset", "z-index": "unset"});*/
    });
    jQuery('#exampleModalScrollable, #te-map-modal').on('shown.bs.modal', function (event) {

        jQuery('#main-header').css({'z-index' : 'unset'});
        setTimeout(function () {
            jQuery('.modal-backdrop').remove();
             jQuery('body').removeClass('modal-open');
        }, 300);

    });

    jQuery('.modal').on('hidden.bs.modal', function (event) {

        jQuery('#main-header').css({'z-index' : '9999999'});

    });

    jQuery('.responsive-filters-tab').on('click', function(){

        jQuery('#exampleModalScrollable').modal('show');
    });

    setTimeout(function () {
        jQuery('.te-more-filter-close').unbind('click');
        jQuery('.te-more-filter-close').click(function() {
            //console.log(jQuery(this).parents('.dropdown').find('a.dropdown-toggle').dropdown('toggle'));
            jQuery(this).parents('.dropdown').find('a.dropdown-toggle').dropdown('toggle');
            // jQuery(this).parents('dropdown-menu').parents('.dropdown').find('a.dropdown-toggle').dropdown('toggle')
        });
    }, 800);

    jQuery('.fprice, .fbed, .fbath, .fstype, .fstatus, .fsqft, .fwf, .fpetsa, .fyear').on('change', function(){
        SubmitSearchForm('#frmlistingsearch');
    });
    jQuery('.btn-search-filter').on('click', function(){
        SubmitSearchForm('#frmlistingsearch');
    });
    jQuery('.btn-search-reset').on('click', function(){

        if(jQuery(window).width() < 900)
        {
            jQuery('.mbl-searchfrm [data-dismiss="modal"]').trigger('click');
            jQuery("#mbfrmsearch input[type='text']").val('');
            jQuery("#mbfrmsearch select").val('');
            jQuery("#mbfrmsearch input[type='checkbox']").val('');
            jQuery("#mbfrmsearch input[type='radio']").val('');
            SubmitSearchForm('#mbfrmsearch');

        }else{

            jQuery(".te-more-filter input[type='text']").val('');
            jQuery(".te-more-filter select").val('');
            jQuery(".te-more-filter input[type='checkbox']").val('');
            SubmitSearchForm('#frmlistingsearch');
        }


    });

    jQuery('.btn-mbl-search').off('click');
    jQuery('.btn-mbl-search').on('click', function(){

        jQuery('.mbl-searchfrm [data-dismiss="modal"]').trigger('click');
        SubmitSearchForm('#mbfrmsearch');
    });
}
function SubmitSearchForm(frmid){
    if(jQuery('.pms-map-listing').length > 0)
    {
        getPage('1', frmid, '');
    }else{
        jQuery(frmid).submit();
    }
}
function rl(){
    var s = 'data-reload';
    jQuery('a[data-reload]').on('click',function(){
        var t = jQuery(this).attr(s),fg = false;if(t=='cc'){fg = true;}location.reload(fg);
    });
}
function loading(s,b_s,l_in,s_name,icon){
    if(s == true){
        if(!l_in){l_in = '.loading-area';}if(!s_name){s_name = 'Loading';}if(!icon){icon = '<i class="fa fa-spinner fa-pulse fa-2x text-primary"></i>&nbsp;';}
        if(b_s !== '' && b_s !==null && b_s !== false){
            jQuery(b_s).attr('disabled', 'disabled');
        }
        jQuery(l_in).append('<div class="processing"><p>'+icon+s_name+'</p></div>');
    }
    else
    {
        if(b_s !== '' && b_s !== null && b_s !== false)
        {
            jQuery(b_s).removeAttr('disabled');
        }
        jQuery('.processing').remove();
    }
}
function msgNotify(m,mt,l_in)
{
    if(!m || !mt) return false;
    if(mt == 'error'){mt='danger';}
    var malert= '<div class="alert alert-message alert-dismissible alert-'+mt+' " role="alert"><button type="button" id="close_alert" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong  class="fa"></strong>'+m+'</div>';
    jQuery(l_in).html(malert);
    rl();
}
function bind_address_autosuggest() {

    if (jQuery("#AddressName").length > 0) {
        jQuery.widget("custom.catAutocomplete", jQuery.ui.autocomplete, {
            _create: function () {
                this._super();
                this.widget().menu("option", "items", "> :not(.ui-autocomplete-type)");
            },
            _renderMenu: function (ul, items) {
                var that = this,
                    currentCategory = "";
                // var i = {label: 'Add ' + this.term + '...', value: that.term, category: ''};
                //items.splice(0, 0, i);

                jQuery.each(items, function (index, item) {
                    var li;
                    if (item.category != currentCategory) {

                        ul.append("<li class='ui-autocomplete-type'>" + item.category + "</li>");
                        currentCategory = item.category;
                    }

                    li = that._renderItemData(ul, item);
                });
            },
           /* options: {
                highlightClass: "ui-state-highlight"
            },*/
            _renderItem: function (ul, item) {
                // Replace the matched text with a custom span. This
                // span uses the class found in the "highlightClass" option.
                var re = new RegExp("(" + this.term + ")", "gi"),
                    cls = this.options.highlightClass,
                    template = "<span class='" + cls + "'>$1</span>",
                    label = item.label.replace(re, template),
                    $li = jQuery("<li/>").appendTo(ul);
                // Create and return the custom menu item content.
                jQuery("<div/>").attr("href", "#")
                    .html(label)
                    .appendTo($li);
                return $li;
            }


        });
        var cache = {};

        jQuery('#AddressName').catAutocomplete({
            minLength:3,
            classes: {
                "ui-autocomplete": "ui-autocomplete-address",
            },
            source: function (request, response) {
                var term = request.term;

                if ( term in cache ) {
                    response(jQuery.map(cache[term], function (item) {
                        if (item.type == 'cs') {
                            $category = "City"
                        }
                        else if (item.type == 'sub') {
                            $category = "Neighborhood";
                        }
                        else if (item.type == 'add') {
                            $category = "Address";
                        }
                        else if (item.type == 'zip') {
                            $category = "Postal Code";
                        }
                        else if (item.type == 'mls') {
                            $category = "MLS#";
                        }
                        else if (item.type == 'all') {
                            $category = "";
                        }
                        return {
                            label: (typeof (item.label) != 'undefined' && (item.label) != undefined && item.label != '')?item.label:item.title,
                            value: item.title,
                            category: $category,
                            type: item.type,
                            mls: (item.ListingID_MLS != '') ? item.ListingID_MLS : '',
                        }
                    }));
                    return;
                }
                jQuery('#autocomplete-close').addClass('d-none');
                jQuery.jAjaxCall({
                    abort_on_new_req: true,
                    send_data: [{name: 'q', value: request['term']},{name: 'agentSysName', value: objLPTAjax.agentSysName}],
                    xhr_area: 'SiteSearch',
                    xhr_module: 'Suggestion',
                    xhr_action: '',

                    xhr_url: objLPTAjax.ajaxurl_as,
                    skip_pr: true,
                    xhr_with_credentials:false,
                    /*fn_alert: function (mt, m) {console.log(m)},*/
                    callbefore_send: function (jqXHR, settings) {
                    },
                    callback_on_success: function (data) {
                        var s_title = request.term;
                        var s_label = 'Add '+request.term+'...';
                        var i = {type:'all',title: s_title,label: s_label};

                        if(data.DATA == undefined || data.DATA == '' || data.DATA == 'undefined')
                        {
                            data.DATA = [i];
                        }
                        else{
                            data.DATA = [i].concat(data.DATA);
                        }
                        cache[term] = data.DATA;
                        response(jQuery.map(data.DATA, function (item) {
                            if (item.type == 'cs') {
                                $category = "City"
                            }
                            else if (item.type == 'sub') {
                                $category = "Neighborhood";
                            }
                            else if (item.type == 'add') {
                                $category = "Address";
                            }
                            else if (item.type == 'zip') {
                                $category = "Postal Code";
                            }
                            else if (item.type == 'mls') {
                                $category = "MLS#";
                            }
                            else if (item.type == 'all') {
                                $category = "";
                            }

                            return {
                                label: (typeof (item.label) != 'undefined' && (item.label) != undefined && item.label != '')?item.label:item.title,
                                value: item.title,
                                category: $category,
                                type: item.type,
                                mls: (item.ListingID_MLS != '') ? item.ListingID_MLS : '',
                            }
                        }));
                        jQuery("#AddressName").removeClass('ui-autocomplete-loading');
                    },
                    callback_on_error: function (jqXHR, textStatus, errorThrown) {
                    },
                    callback_on_complete: function (jqXHR, textStatus) {
                        jQuery("#AddressName").removeClass('ui-autocomplete-loading');
                    }
                }, 'sitesearch');

            },
            appendTo:'.ui-front',
            select: function (event, ui) {
                if (event) {

                    jQuery('#AddressValue').val(ui.item.value);
                    if(ui.item.type == 'add' || ui.item.type == 'mls')
                    {
                        jQuery("#frmlistingsearch, #mbfrmsearch, #frmsearch").append('<input type="hidden" name="ListingID_MLS" value="'+ui.item.mls+'"/>');
                        jQuery('#ListingID_MLS').val(ui.item.mls);
                    }
                    if (ui.item.type == '' || ui.item.type == null) {
                        ui.item.type = 'all'
                    }
                    jQuery('#AddressType').val(ui.item.type);

                    if(jQuery('#frmsearch').length > 0){
                        //SubmitSearchForm('#frmsearch');
                        jQuery('#search-box').trigger('click');
                    }else
                    {
                        if(jQuery(window).width() < 900)
                        {
                            jQuery('#AddressValuembl').val(ui.item.value);
                            jQuery('#AddressTypembl').val(ui.item.type);

                            SubmitSearchForm('#mbfrmsearch');
                        }else{
                            //SubmitSearchForm('#frmlistingsearch');
                            jQuery('#search-box').trigger('click');
                        }
                    }
                    //SubmitSearchForm("#frmlistingsearch");

                    jQuery('#AddressName').blur();

                }
                //return false;
            },
            search:function (event,ui) {

                jQuery('#AddressName').val(event.target.value);
                jQuery('#AddressValue').val(event.target.value);
                jQuery('#AddressType').val('all');

            }

        }).on("focus", function(request){
            jQuery(this).catAutocomplete("search", jQuery(this).val());
        });
        search_autocomplete();
    }
}
function search_autocomplete()
{
    jQuery('#search-box').on('click', function () {
        /*if(jQuery(window).width() < 900)
        {
            var form = '#mbfrmsearch';
        }else{
            var form = '#frmlistingsearch';
        }
        getPage(1, form);*/
        if(jQuery('#frmsearch').length > 0){
            // jQuery('#AddressValuembl').val(ui.item.value);
            // jQuery('#AddressTypembl').val(ui.item.type);
            jQuery('#frmsearch').submit();
            // SubmitSearchForm('#frmsearch');
        }else
        {
            if(jQuery(window).width() < 900)
            {
                jQuery('#AddressValuembl').val(ui.item.value);
                jQuery('#AddressTypembl').val(ui.item.type);

                SubmitSearchForm('#mbfrmsearch');
            }else{
                SubmitSearchForm('#frmlistingsearch');
            }
        }
    });

    jQuery('#AddressName').on('keydown', function(event){
        // Enter key hit form submit
        if(event.keyCode == 13)
        {
            event.preventDefault();
            jQuery('#AddressName').catAutocomplete('close');
            if(jQuery(window).width() < 900)
            {
                var form = '#mbfrmsearch';
            }else{
                var form = '#frmlistingsearch';
            }
            getPage(1, form);
            // jQuery('.ui-autocomplete-input').removeClass('ui-autocomplete-loading');
        }
    });
}
function UpdateFavorites_Click(MLS_No, Action, type,UserId)
{
    var isRedirect = jQuery("#isredirect").val();
    var send_data = [];
    send_data.push({name:'action',value: objMem.action});
    send_data.push({name:'ajax_in_site',value:true});
    send_data.push({name:'mls_no',value:MLS_No});
    send_data.push({name:'isredirect',value:isRedirect});
    send_data.push({name:'page_type',value:type});
    send_data.push({name:'subaction',value:'addremove'});
    send_data.push({name:'favaction',value:Action});
    send_data.push({name:'UserId',value:UserId});

    if(jQuery(window).width() < 730 && type == 'FullView'){
        send_data.push({name:'ismobile',value:true});
    }

    jQuery.jAjaxCall({
        send_data   :   send_data,
        xhr_area    :   'User',
        xhr_module  :   'UserFavourites',
        xhr_action  :   '',
        xhr_url     :   objMem.url,
        callback_on_success: function (data, textStatus, jqXHR) {

        },
    }, 'userfav');
}
function bindModalPopup()
{
    jQuery('.hbn-popup-modal').unbind('click');
    jQuery('.hbn-popup-modal').on('click', function(){

        var url  =   jQuery(this).attr('data-url');
        var type =   jQuery(this).attr('data-target');

        jQuery('#modal-popup .modal-content').html('<p class="text-center"><br>Loading ...</p>');

        jQuery('#modal-popup').modal('show');

        //url = url;//+"&IsPage="+IsPage;
        jQuery('#modal-popup .modal-content').load(url, function(e){

            bindModalPopup();
            if(type === 'Inquiry')
            {
                Inquiry();
            }
        });
        return false;
    });

}
function bindSMPopup()
{
    jQuery('.popup-modal-sm').unbind('click');
    jQuery('.popup-modal-sm').on('click', function(){
        var url  =   jQuery(this).attr('data-url');
        var type =   jQuery(this).attr('data-target');

        jQuery('#modal-sm-popup .modal-content').html('<p class="text-center"><br>Loading ...</p>');

        if(typeof maxViewedExceed != "undefined" && maxViewedExceed == true)
        {
            jQuery('#modal-sm-popup').modal({backdrop: 'static', keyboard: false}, 'show');
        }else{
            jQuery('#modal-sm-popup').modal('show');
        }

        // jQuery('#modal-sm-popup').modal('show');

        //url = url;//+"&IsPage="+IsPage;
        jQuery('#modal-sm-popup .modal-content').load(url, function(e){

     if(typeof maxViewedExceed != "undefined" && maxViewedExceed == true)
            {
                jQuery('.close').hide();
            }

            bindSMPopup();
            if(type == "MemberLogin")
            {

                if(jQuery("#frmLogin").length)
                {
                    jQuery("#frmLogin").validate({
                        submitHandler: function(form) {
                            var send_data = jQuery("#frmLogin").serializeArray();

                            send_data.push({name:'ajax_in_site',value:true});
                            send_data.push({name:'action',value: objMem.action});
                            if (jQuery("input[name='OnPage']").val() != '')
                                send_data.push({name: 'OnPage', value: parent.jQuery("input[name='OnPage']").val()});
                            jQuery.jAjaxCall({
                                send_data: send_data,
                                xhr_area: 'User',
                                xhr_module: 'Login',
                                xhr_action: '',
                                xhr_url: objMem.url,
                                fn_alert: function(mt, m){
                                    msgNotify(m,mt,"#login-error");
                                    loading(false,'.btn-signin');
                                },
                                callbefore_send: function (jqXHR, settings) {
                                    loading(true,'.btn-signin','.loading-area','<span class="text-primary">Please Wait ...</span>');
                                },
                                callback_on_success: function (data, textStatus, jqXHR) {
                                    if (typeof data.SUCCESS != undefined && typeof data.SUCCESS != 'undefined') {
                                        jQuery("#frmLogin").trigger("reset");
                                    }

                                    if (typeof data.DATA != undefined && typeof data.DATA != 'undefined') {

                                        if (typeof data.DATA.ReloadResult != undefined && typeof data.DATA.ReloadResult != 'undefined' && data.DATA.ReloadResult == true) {
                                            // pt.reload_result();
                                            window.parent.location.reload();
                                        }
                                        if (typeof data.DATA.save_search != undefined && typeof data.DATA.save_search != 'undefined' && data.DATA.save_search == true) {
                                            // jQuery("#save_search").trigger("click");
                                            bindSMPopup();
                                            setTimeout(function () {
                                                jQuery("#save_search").trigger("click");
                                            }, 500);
                                        }
                                    }

                                },
                                callback_on_error: function (jqXHR, textStatus, errorThrown) {},
                                callback_on_complete: function (jqXHR, textStatus) {}
                            }, 'login');
                            return false;
                        }
                    });
                }
            }
            else if(type == "MemberRegister")
            {
                if(jQuery("#frmRegister").length)
                {
                    jQuery("#frmRegister").validate({

                        rules : {
                            user_password : {
                                minlength : 10,
                                number: true
                            },
                            user_confirm_password : {
                                minlength : 10,
                                equalTo : "#user_password",
                                number: true
                            }
                        },
                        submitHandler: function(form) {
                            var send_data = jQuery("#frmRegister").serializeArray();
                            send_data.push({name:'action',value: objMem.action});
                            send_data.push({name:'ajax_in_site',value:true});

                            if (jQuery("input[name='OnPage']").val() != '')
                                send_data.push({name: 'OnPage', value: parent.jQuery("input[name='OnPage']").val()});

                            jQuery.jAjaxCall({
                                send_data: send_data,
                                xhr_area: 'User',
                                xhr_module: 'SignUp',
                                xhr_action: '',
                                xhr_url: objMem.url,
                                xhr_timeout :   (1000*12),
                                fn_alert: function(mt, m){
                                    msgNotify(m,mt,"#signup-error");
                                    loading(false,'.btn-signup');
                                },
                                callbefore_send: function (jqXHR, settings) {
                                    loading(true,'.btn-signup','.loading-area','<span class="text-primary">Please Wait...</span>');
                                },
                                callback_on_success: function (data, textStatus, jqXHR) {
                                    if (typeof data.SUCCESS != 'undefined' && data.SUCCESS != undefined)
                                    {
                                        if(typeof objMem.google_conv_code != 'undefined' && objMem.google_conv_code !== '' && objProp.google_conv_code !== null){
                                            // Track conversion
                                            if(typeof gtag_report_conversion === 'function')
                                            {
                                                gtag_report_conversion();
                                            }
                                        }

                                        jQuery("#frmRegister").trigger("reset");
                                    }
                                    else
                                    {
                                        if(typeof grecaptcha != 'undefined')
                                        {
                                            grecaptcha.ready(function () {
                                                grecaptcha.execute(objMem.captcha_site_key, {action: 'user_register'}).then(function (token) {
                                                    var recaptchaResponse = document.getElementById('g-recaptcha-response');
                                                    recaptchaResponse.value = token;
                                                });
                                            });
                                        }
                                    }
                                },
                                callback_on_error: function (jqXHR, textStatus, errorThrown) {},
                                callback_on_complete: function (jqXHR, textStatus) {}
                            }, 'usersingnup');
                            return false;

                        }

                    });
                }
            }
            else if(type == "ForgotPassword")
            {
                if(jQuery("#frmForgetPwd").length)
                {
                    jQuery("#frmForgetPwd").validate({

                        submitHandler: function(form) {

                            //jQuery("#frmForgetPwd button[type=submit]").attr('disabled', 'disabled');
                            var send_data = jQuery("#frmForgetPwd").serializeArray();
                            send_data.push({name:'ajax_in_site',value:true});
                            send_data.push({name:'action',value: objMem.action});
                            if(parent.jQuery("input[name='OnPage']").length)
                                send_data.push({name:'OnPage',value:parent.jQuery("input[name='OnPage']").val()});
                            if(parent.jQuery("input[name='mlsNum']").length) // while we are not getting mls from url, need to fetch from hidden
                                send_data.push({name:'mlsNum',value:parent.jQuery("input[name='mlsNum']").val()});

                            jQuery.jAjaxCall({
                                send_data: send_data,
                                xhr_area: 'User',
                                xhr_module: 'ForgotPassword',
                                xhr_action: '',
                                xhr_url: objMem.url,
                                fn_alert: function(mt, m){
                                    msgNotify(m,mt,"#forgot-error");
                                    loading(false,'.btn-fwd');
                                },
                                callbefore_send: function (jqXHR, settings) {
                                    loading(true,'.btn-fwd','.loading-area','<span class="text-primary">Please Wait ...</span>');
                                },
                                callback_on_success: function (data, textStatus, jqXHR) {
                                    if (typeof data.SUCCESS != 'undefined' && data.SUCCESS != undefined)
                                    {
                                        jQuery("#frmForgetPwd").trigger("reset");
                                    }
                                },
                                callback_on_error: function (jqXHR, textStatus, errorThrown) {},
                                callback_on_complete: function (jqXHR, textStatus) {}
                            }, 'forgetpassword');
                            return false;

                        }

                    });
                }
            }
            else if(type == "savesearch")
            {
                if(jQuery("#frmSaveSearch").length)
                {
                    jQuery("#frmSaveSearch").validate({
                        submitHandler: function(form) {

                            var send_data = jQuery("#frmSaveSearch").serializeArray();
                            send_data.push({name:'ajax_in_site',value:true});
                            send_data.push({name:'action',value: objMem.action});

                            jQuery.jAjaxCall({
                                send_data: send_data,
                                xhr_area: 'User',
                                xhr_module: 'SaveSearch',
                                xhr_action: '',
                                xhr_url: objMem.url,
                                fn_alert: function(mt, m){
                                    msgNotify(m,mt,"#savesearch-error");
                                    loading(false,'.btn-savesearch');
                                },
                                callbefore_send: function (jqXHR, settings) {
                                    loading(true,'.btn-savesearch','.loading-area','<span class="text-primary">Please Wait ...</span>');
                                },
                                callback_on_success: function (data, textStatus, jqXHR) {
                                    if (typeof data.SUCCESS != 'undefined' && data.SUCCESS != undefined)
                                    {
                                        jQuery("#frmSaveSearch").trigger("reset");
                                    }
                                },
                                callback_on_error: function (jqXHR, textStatus, errorThrown) {},
                                callback_on_complete: function (jqXHR, textStatus) {}
                            }, 'frmSaveSearch');
                            return false;

                        }
                    });
                }
            }
        });
        return false;
    });

}
function numberFormat(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1))
    {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }

    return x1 + x2;
}
function PriceFormat(nStr, noOfDecimal)
{
    if(!isNaN(nStr))
    {
        var tmpNo = '';
        var tmpStr = '';

        if(nStr > 1000000000000)
        {
            tmpNo =  (nStr/1000000000000);
            noOfDecimal = (noOfDecimal != 'undefined' && noOfDecimal != undefined) ? noOfDecimal : 2;
            tmpStr = 'T';
        }
        else if(nStr >= 1000000000)
        {
            tmpNo =  (nStr/1000000000);
            noOfDecimal = (noOfDecimal != 'undefined' && noOfDecimal != undefined) ? noOfDecimal : 2;
            tmpStr = 'B';
        }
        else if(nStr >= 1000000)
        {
            tmpNo =  (nStr/1000000);
            noOfDecimal = (noOfDecimal != 'undefined' && noOfDecimal != undefined) ? noOfDecimal : 2;
            tmpStr = 'M';
        }
        else if(nStr >= 1000)
        {
            tmpNo = (nStr/1000);
            tmpStr = 'K';
        }

        if(tmpNo != '')
        {
            if(tmpNo%1 != 0)
            {
                if(noOfDecimal != 'undefined' && noOfDecimal != undefined)
                {
                    return tmpNo.toFixed(noOfDecimal)+tmpStr;
                }
                else
                {
                    return Math.round(tmpNo)+tmpStr;
                }
            }
            else
            {
                return tmpNo+tmpStr;
            }
        }
        else
        {
            return nStr;
        }

    }
}
function popupWindowURL(url, winname, w, h, menu, resize, scroll, toolBar, fullScreen)
{
    var x = (screen.width-w)/2;
    var y = (screen.height-h)/3;

    if (winname == null)
    {
        winname = "newWindow";
    }

    if (w == null)
    {
        w = 800;
    }

    if (h == null)
    {
        h = 600;
    }

    if (resize == null)
    {
        resize = 1;
    }

    menutype   = "nomenubar";
    resizetype = "noresizable";
    scrolltype = "noscrollbars";
    toolbar    = "no";

    if (menu)
    {
        menutype = "menubar";
    }

    if (resize)
    {
        resizetype = "resizable";
    }

    if (scroll)
    {
        scrolltype = "scrollbars";
    }

    if (toolBar)
    {
        toolbar = "yes";
    }

    if(fullScreen)
    {
        cwin = window.open(url,winname,"channelmode=1,fullscreen=1,toolbar=" + toolbar);
    }
    else
    {
        cwin = window.open(url,winname,"top=" + y + ",left=" + x + ",screenX=" + x + ",screenY=" + y + "," + "status," + menutype + "," + scrolltype + "," + resizetype + ",width=" + w + ",height=" + h+ ",toolbar=" + toolbar);
    }

    if (!cwin.opener)
    {
        cwin.opener = self;
    }

    cwin.focus();

    return true;
}




