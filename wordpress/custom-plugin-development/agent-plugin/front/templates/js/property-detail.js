var init_input_name = 'down_payment_percent';
jQuery(document).ready(function(){

    jQuery('.expand_details').click(function(e) {
        if(jQuery('.expand_details').hasClass("active") == false) {
            e.preventDefault();
            jQuery('.expand_details').addClass('active');
            jQuery('.expandDiv').removeClass('d-none');
            jQuery('.expandDiv').addClass('d-block');
            e.preventDefault();
        }else {
            e.preventDefault();
            jQuery('.expand_details').removeClass('active');
            jQuery('.expandDiv').addClass('d-none');
            jQuery('.expandDiv').removeClass('d-block');
            e.preventDefault();
        }

    });

    if (user_log_in == 'No') {
        if (login_enable == 'Yes') {
            if (isloginReq == 'Yes') {

                var user_view_count = getCookie('user_view_details_count');

                if (user_view_count != null && user_view_count != '') {
                    var count = (Number(user_view_count) + 1);
                    document.cookie = "user_view_details_count=" + count + "; path=/";

                    if (count >= maxViewedExceedCount && (maxViewedExceed == false || maxViewedExceed == 'false')) {
                        maxViewedExceed = true;
                    }
                } else {
                    document.cookie = "user_view_details_count=1; path=/";
                }
            }
        }

        if (maxViewedExceed == true) {
            setTimeout(function () {
                //jQuery('.popup-modal-sm').trigger('click');
                jQuery('.member-register-modal').trigger('click');
            }, 200);
            jQuery('#page-container').addClass('blurDetailPage');
        }
        else if(maxViewedExceed == false || maxViewedExceed == 'false'){
            jQuery('#page-container').removeClass('blurDetailPage');
        }
    }

    if(jQuery('body').hasClass("single-template-default"))
    {
        jQuery('body').removeClass("et_right_sidebar");
    }
    ScheduleShowing();

    Simple_Calculator();
    bindModalPopup();
    if(jQuery('#frmCalculator').length)
    {
        /* Do Calulation Automatically, so bing onblur/change event of all inputs */
       /* jQuery("#frmCalculator input#down_payment_percent, #frmCalculator input#down_payment_amount").on("change", function(){init_input_name = jQuery(this).attr('name');});
        jQuery("#frmCalculator input").on("blur", function(){Simple_Calculator();});
        jQuery("#frmCalculator select").on("change", function(){Simple_Calculator();});*/
        jQuery('#cal_now').on('click',function () {
            Simple_Calculator();
        });
        Simple_Calculator();

        /* Bind Form Validation */
        var validator = jQuery('#frmCalculator').validate({

            submitHandler: function(frm) {

                Simple_Calculator();

                return false;
            }
        });
    }

    /*if (jQuery(window).width() < 390){
        jQuery('.360pb').removeClass('pr-3');
        jQuery('.360pb').addClass('pr-0');
        jQuery('.360ps').removeClass('pl-2');
        jQuery('.360ps').addClass('pl-0');
    }
    if (jQuery(window).width() > 405 && jQuery(window).width() < 512){
        jQuery('.400bd').removeClass('px-2');
        jQuery('.400bd').addClass('px-4');
    }*/

    if(jQuery(window).width() < 512){
        jQuery('.text-micro, .seo-text, #location-hash p, .txt-heading, #overview-hash p').addClass('px-3');
        jQuery('.leftbar').removeClass('pr-5');
        jQuery('.aside').removeClass('pl-0');
    }

    if((jQuery(window).width() > 992) && (jQuery(window).width() < 1300)){
        jQuery('.formpx').removeClass('px-5');
        jQuery('.formpx').addClass('px-4');
        if(jQuery(".formpx").hasClass("pb-5")){
            jQuery('.formpx').removeClass('pb-5');
            jQuery('.formpx').addClass('pb-4');
        }
        if(jQuery(".formpx").hasClass("pt-5")){
            jQuery('.formpx').removeClass('pt-5');
            jQuery('.formpx').addClass('pt-4');
        }
    }


});
function getCookie(name) {
    var cookieArr = document.cookie.split(";");

    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        if(name == cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
    return null;
}
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

function Simple_Calculator()
{
    var LoanBalance  =jQuery('#loan_balance').val();

    LoanBalance = LoanBalance.replace(/[^0-9]+/g, '');
    // By default Calculate all,  based on percentage value
    //var DownPayment  = document.getElementById('down_payment_percent').value;
    //if(typeof(strInput) == 'undefined')
    // strInput = init_input_name;

    // Calculate all, based on value changed in percentage Or amount, we will get name of input as strInput
    if(init_input_name == 'down_payment_amount')
    {
        var DownPayment  =jQuery('#down_payment_amount').val();

        //DownPayment  = DownPayment.replace('$','');
        //DownPayment  = DownPayment.replace(/,/g,'');

        DownPayment = DownPayment.replace(/[^0-9]+/g, '');

        if(DownPayment == '')
            DownPayment = 0;
        else if(parseInt(DownPayment) > parseInt(LoanBalance))//else if(DownPayment > LoanBalance)
            DownPayment = LoanBalance;

        // display Proper values
       jQuery('#down_payment_amount').val('$'+numberFormat(DownPayment));
       jQuery('#down_payment_percent').val(Math.round(DownPayment * 100 / LoanBalance) + '%');
    }
    else
    {
        DownPayment  =jQuery('#down_payment_percent').val();
        DownPayment  = DownPayment.replace(/[^0-9.]+/g, '');

        if(DownPayment == '')
            DownPayment = 0;
        else if(DownPayment > 100)
            DownPayment = 100;

        DownPayment  = Math.round(parseFloat(DownPayment));
        //console.log(DownPayment);


       jQuery('#down_payment_percent').val(DownPayment+'%');

        DownPayment  = (LoanBalance * DownPayment / 100);

        // display Proper values
       jQuery('#down_payment_amount').val('$'+numberFormat(DownPayment));

    }

    /*if(DownPayment.indexOf('%') != -1)
     {
     DownPayment  = parseFloat(document.getElementById('down_payment_percent').value);
     DownPayment  = (LoanBalance * DownPayment / 100);
     }
     else
     {
     DownPayment  = DownPayment.replace('$','');
     DownPayment  = DownPayment.replace(/,/g,'');
     }
     */

   jQuery('#loan_principal').val('$'+numberFormat(LoanBalance-DownPayment));
    //jQuery('#monthly_payment').html('$'+numberFormat(Math.round(FaitLe())));
    var PrinEtInt = numberFormat(Math.round(FaitLe()));

    jQuery(".monthly_payment").html('$' + PrinEtInt + ' /mo');

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