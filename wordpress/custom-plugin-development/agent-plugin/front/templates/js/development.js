var outline = '1px solid '+ OtherConfig.btn_color;
jQuery(document).ready(function(){

    jQuery('et_pb_section').addClass("development_head");

    if(jQuery('body').hasClass("development_head"))
    {
        jQuery('development_head').css("padding", "0%");
    }

    if(jQuery('body').hasClass("single-template-default"))
    {
        jQuery('body').removeClass("et_right_sidebar");
    }

    var selector1 = ['imgsec1','imgsec2','imgsec3'];
    var selector2 = ['infosec1','infosec2','infosec3'];

    jQuery.each( selector1, function( key, value ) {
        jQuery('.'+value).css('border-top',outline);
        jQuery('.'+value).css('border-left',outline);
        jQuery('.'+value).css('border-bottom',outline);
    });
    jQuery.each( selector2, function( key, value ) {
        jQuery('.'+value).css('border-top',outline);
        jQuery('.'+value).css('border-right',outline);
        jQuery('.'+value).css('border-bottom',outline);
    });

    jQuery('.card-header , .card-body').removeClass("px-4");
    jQuery('.card-header , .card-body').addClass("px-5");

    ScheduleShowing();
    bindModalPopup();
    unhover1();
    unhover2();
    unhover3();

});
function ScheduleShowing()
{
    if(jQuery('#frmSchedule').length > 0)
    {
        if(typeof grecaptcha != 'undefined')
        {
            grecaptcha.ready(function () {
                grecaptcha.execute(objProp.captcha_site_key, { action: 'contact_agent' }).then(function (token) {
                    var recaptchaResponse = document.getElementById('recaptchaResponse');
                    recaptchaResponse.value = token;
                });
            });
        }

        jQuery('#frmSchedule').validate({

            submitHandler: function(form) {

                var send_data = jQuery('#frmSchedule').serializeArray();

                send_data.push({name:'ajax_in_site',value:true});
                send_data.push({name:'action',value: objProp.action});
                jQuery.jAjaxCall({
                    abort_on_new_req    :   true,
                    send_data   :   send_data,
                    xhr_area    :   'Listing',
                    xhr_module  :   'Schedule_Showing',
                    xhr_action  :   '',
                    xhr_url     :   objProp.url,
                    xhr_timeout :   (1000*30),
                    fn_alert: function(mt, m){
                        msgNotify(m,mt,"#schedule-message-container");
                        loading(false,'.btn-schedule');
                    },
                    callbefore_send: function (jqXHR, settings) {
                        loading(true,'.btn-schedule','.inquiry-loading-area','<span class="text-primary">Please Wait ...</span>');
                    },
                    callback_on_success: function (data, textStatus, jqXHR) {

                        if (typeof data.SUCCESS != 'undefined')
                        {
                            if(typeof objProp.google_conv_code != 'undefined' && objProp.google_conv_code !== '' && objProp.google_conv_code !== null){
                                // Track conversion
                                if(typeof gtag_report_conversion === 'function')
                                {
                                    gtag_report_conversion();
                                }
                            }

                            jQuery("#frmSchedule").trigger("reset");
                        }

                    },
                    callback_on_error: function (jqXHR, textStatus, errorThrown) {
                    },
                    callback_on_complete: function (jqXHR, textStatus) {}
                }, 'schedule');

                return false;
            }
        });
    }
}

function floor(number)
{
    return Math.floor(number*Math.pow(10,2))/Math.pow(10,2);
}
function FaitLe()
{
    var InterDiv = parseFloat(document.getElementById('loan_interest').value) // tax interet

    if (InterDiv < 0.3)
    {
        InterDiv = InterDiv * 100.0;
    }
    InterDiv2 = InterDiv;
    InterDiv = InterDiv / 1200;

    var radic = 1;
    var moy = 1 + InterDiv;

    var annees = parseFloat(document.getElementById('loan_year').value); // terme en annees

    for (i=0; i<annees * 12; i++)
    {
        radic = radic * moy;
    }

    var LoanPrice = document.getElementById('loan_principal').value.replace('$', '');

    var emprunte = parseFloat(LoanPrice.replace(/,/g,'')); // tax interet

    var PrinEtInt = floor(emprunte * InterDiv / ( 1 - (1/radic)));

    //return PrinEtInt; // princip + int par mois

    // New Filed added for annuam tax,insurrance

    var tmpTax = 0;

    if(parseFloat(jQuery('#annual_tax').val()) > 0)
        tmpTax += parseFloat(jQuery('#annual_tax').val());

    if(parseFloat(jQuery('#annual_ins').val()) > 0)
        tmpTax += parseFloat(jQuery('#annual_ins').val());

    if(tmpTax > 0)
    {
        tmpTax = parseFloat(tmpTax/12);

        PrinEtInt += tmpTax;

    }

    return PrinEtInt;

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
            doInputMasking();
            if(type === 'Inquiry')
            {
                Inquiry();
            }
        });
        return false;
    });

}
function Inquiry()
{
    if(jQuery('#frmInquiry').length > 0)
    {
        jQuery('#frmInquiry').validate({

            submitHandler: function(form) {

                var send_data = jQuery('#frmInquiry').serializeArray();

                send_data.push({name:'ajax_in_site',value:true});
                send_data.push({name:'action',value: objProp.action});
                jQuery.jAjaxCall({
                    abort_on_new_req    :   true,
                    send_data   :   send_data,
                    xhr_area    :   'Listing',
                    xhr_module  :   'Inquiry',
                    xhr_action  :   '',
                    xhr_url     :   objProp.url,
                    fn_alert: function(mt, m){
                         msgNotify(m,mt,"#message-container");
                         loading(false,'.btn-inquiry');
                    },
                    callbefore_send: function (jqXHR, settings) {
                         loading(true,'.btn-inquiry','.inquiry-loading-area','<span class="text-primary">Please Wait ...</span>');
                    },
                    callback_on_success: function (data, textStatus, jqXHR) {

                        if (typeof data.SUCCESS != 'undefined')
                        {
                            jQuery("#frmInquiry").trigger("reset");
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

function hover1(element) {

    var ele = document.getElementById( "img1" );
    ele.setAttribute('src', TPL_images + 'fact-sheet-icon-hover.png');

    jQuery('.head1').css('color',OtherConfig.hover_text_color);
    jQuery('#link1').css('color',OtherConfig.hover_text_color);

    jQuery('.imgsec1').css('background-color',OtherConfig.hover_color);
    jQuery('.infosec1').css('background-color',OtherConfig.hover_color);

}

function unhover1(e) {

    var ele = document.getElementById( "img1" );
    ele.setAttribute('src', TPL_images + 'fact-sheet-icon.png');

    jQuery('.head1').css('color',OtherConfig.btn_txt_color);
    jQuery('#link1').css('color',OtherConfig.btn_txt_color);

    jQuery('.imgsec1').css('background-color',OtherConfig.btn_color);
    jQuery('.infosec1').css('background-color',OtherConfig.btn_color);

}
function hover2(element) {

    var ele = document.getElementById( "img2" );
    ele.setAttribute('src', TPL_images + 'pricing-icon-hover.png');

    jQuery('.head2').css('color',OtherConfig.hover_text_color);
    jQuery('#link2').css('color',OtherConfig.hover_text_color);

    jQuery('.imgsec2').css('background-color',OtherConfig.hover_color);
    jQuery('.infosec2').css('background-color',OtherConfig.hover_color);

}

function unhover2(e) {

    var ele = document.getElementById( "img2" );
    ele.setAttribute('src', TPL_images + 'pricing-icon.png');

    jQuery('.head2').css('color',OtherConfig.btn_txt_color);
    jQuery('#link2').css('color',OtherConfig.btn_txt_color);

    jQuery('.imgsec2').css('background-color',OtherConfig.btn_color);
    jQuery('.infosec2').css('background-color',OtherConfig.btn_color);

}
function hover3(element) {

    var ele = document.getElementById( "img3" );
    ele.setAttribute('src', TPL_images + 'floor-plans-icon-hover.png');

    jQuery('.head3').css('color',OtherConfig.hover_text_color);
    jQuery('#link3').css('color',OtherConfig.hover_text_color);

    jQuery('.imgsec3').css('background-color',OtherConfig.hover_color);
    jQuery('.infosec3').css('background-color',OtherConfig.hover_color);

}

function unhover3(e) {

    var ele = document.getElementById( "img3" );
    ele.setAttribute('src', TPL_images + 'floor-plans-icon.png');

    jQuery('.head3').css('color',OtherConfig.btn_txt_color);
    jQuery('#link3').css('color',OtherConfig.btn_txt_color);

    jQuery('.imgsec3').css('background-color',OtherConfig.btn_color);
    jQuery('.infosec3').css('background-color',OtherConfig.btn_color);
}