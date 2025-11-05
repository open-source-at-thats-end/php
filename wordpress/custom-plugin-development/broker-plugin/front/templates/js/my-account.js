var objMyAccount;
jQuery(document).ready(function() {

    BindEditProfile();
    ChangePassword();
});
function BindEditProfile()
{
    if(jQuery('#frmAccount').length > 0)
    {
        jQuery('#frmAccount').validate({

            submitHandler: function(form) {

                var send_data = jQuery('#frmAccount').serializeArray();

                send_data.push({name:'ajax_in_site',value:true});
                send_data.push({name:'action',value: objMyAccount.action});
                jQuery.jAjaxCall({
                    abort_on_new_req    :   true,
                    send_data   :   send_data,
                    xhr_area    :   'User',
                    xhr_module  :   'EditProfile',
                    xhr_action  :   '',
                    xhr_url     :   objMyAccount.url,
                    fn_alert: function(mt, m){
                        msgNotify(m,mt,"#message-container");
                        loading(false,'.btn-account');
                    },
                    callbefore_send: function (jqXHR, settings) {
                        loading(true,'.btn-account','.loading-area','<span class="text-primary">Please Wait ...</span>');
                    },
                    callback_on_success: function (data, textStatus, jqXHR) {



                    },
                    callback_on_error: function (jqXHR, textStatus, errorThrown) {

                    },
                    callback_on_complete: function (jqXHR, textStatus) {
                        loading(false,'.btn-account');
                    }
                }, 'schedule');

                return false;
            }
        });
    }
}
function ChangePassword(){
    if(jQuery('#frmPassword').length > 0)
    {
        jQuery('#frmPassword').validate({
            rules : {
                new_password:{
                  required : true,
                },
                confirm_password : {
                    required : true,
                    equalTo : '#new_password'
                }
            },
            submitHandler: function(form) {

                var send_data = jQuery('#frmPassword').serializeArray();

                send_data.push({name:'ajax_in_site',value:true});
                send_data.push({name:'action',value: objMyAccount.action});
                jQuery.jAjaxCall({
                    abort_on_new_req    :   true,
                    send_data   :   send_data,
                    xhr_area    :   'User',
                    xhr_module  :   'ChangePassword',
                    xhr_action  :   '',
                    xhr_url     :   objMyAccount.url,
                    fn_alert: function(mt, m){
                        msgNotify(m,mt,"#cp-message-container");
                        loading(false,'.btn-change-password');
                    },
                    callbefore_send: function (jqXHR, settings) {
                        loading(true,'.btn-change-password','.cp-loading-area','<span class="text-primary">Please Wait ...</span>');
                    },
                    callback_on_success: function (data, textStatus, jqXHR) {

                        if (typeof data.SUCCESS != 'undefined')
                        {
                            jQuery("#frmPassword").trigger("reset");
                        }

                    },
                    callback_on_error: function (jqXHR, textStatus, errorThrown) {},
                    callback_on_complete: function (jqXHR, textStatus) {}
                }, 'schedule');

                return false;
            }
        });
    }
}
function RunSearch_Click(searchId)
{
    SubmitSaveSearch(searchId,'RunSearch');
}
function DeleteSearch_Click(searchId)
{
    SubmitSaveSearch(searchId,'DeleteSearch');
}
function change_email_notification(id, search_id)
{
    jQuery('#save_search_response_'+search_id).hide();
    var send_data = [];
    send_data.push({name:'ajax_in_site',value:true});
    send_data.push({name:'action',value: objMyAccount.action});
    send_data.push({name:'search_id',value: search_id});
    send_data.push({name:'newid',value:id});

    jQuery.jAjaxCall({
        send_data   :   send_data,
        xhr_area    :   'User',
        xhr_module  :   'SearchEmailNotification',
        xhr_action  :   '',
        xhr_url     :   objMyAccount.url,
    }, 'searchnoti');
    //xajax_ListingAjaxCall('Search', 'EmailNotification',{newid:id,newsearchid:search_id});
}
function SubmitSaveSearch(searchId,action)
{

                var send_data = [];

                send_data.push({name:'ajax_in_site',value:true});
                send_data.push({name:'action',value: objMyAccount.action});
                send_data.push({name:'search_id',value: searchId});
                jQuery.jAjaxCall({
                    abort_on_new_req    :   true,
                    send_data   :   send_data,
                    xhr_area    :   'User',
                    xhr_module  :   action,
                    xhr_action  :   '',
                    xhr_url     :   objMyAccount.url,
                    fn_alert: function(mt, m){


                    },
                    callbefore_send: function (jqXHR, settings) {

                    },
                    callback_on_success: function (data, textStatus, jqXHR) {

                        if(typeof data.DATA !== 'undefined' && typeof data.DATA.url !== 'undefined')
                        {
                            window.location.href = data.DATA.url;
                        }
                        else if(typeof data.SUCCESS !== 'undefined')
                        {
                            window.location.reload();
                        }

                    },
                    callback_on_error: function (jqXHR, textStatus, errorThrown) {},
                    callback_on_complete: function (jqXHR, textStatus) {}
                }, 'submit-search');

                return false;
}

