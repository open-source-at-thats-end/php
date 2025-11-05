var img_h = '';
var view_page_url;
var prop_details = '';
var details_box = '';
jQuery(document).ready(function () {
          jQuery('.p-slider-12').slick({
            autoplay: false,
            autoplaySpeed: 3000,
            slidesToShow: 2,
            slidesToScroll: 1,
            arrows: false,
            responsive: [
                {
                    breakpoint: 1060,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
        SliderBindings();
});
function SliderBindings()
{

      jQuery('.arrow-next').on('click',function () {
        var pid = jQuery(this).attr('data-id');

        jQuery('.slider-'+pid).slick("slickNext");
    });
    jQuery('.arrow-prev').on('click',function () {
        var pid = jQuery(this).attr('data-id');
        jQuery('.slider-'+pid).slick("slickPrev");
    });
}
function getListingBoxHtml(data, pid = '') {

    //console.log(pid);


    var infoHtml = '';
    img_h = "slide-img";
    prop_details = "te-property-details";
    details_box = "details-box";


    if(pid != ''){
        cust_css = jQuery("#css_"+pid).val();
        cust_title = jQuery("#title_"+pid).val();
        cust_bg = jQuery("#bg_"+pid).val();
    }
    else {
        cust_css = CustomCSS;
        cust_title = CustomTitle;

    }

    if(cust_bg == 'light'){

        var cust_color = 'style12_text_dark';
        var cust_font = 'style12_font_size_dark style12_font_family_dark';
    }
    else{
        var cust_color = 'style12_text_light';
        var cust_font = 'style12_font_size_light style12_font_family_light';
    }


    infoHtml += '<div class="p12 p-action d-block- d-sm-flex">';
    /*infoHtml += '<div class="ml-md-4 te-font-size-18 text-dark" style="'+cust_css+'">'+cust_title+'</div>';*/
    infoHtml += '<div class="ml-md-4 te-font-size-18 '+cust_color+' '+cust_font+'" style="'+cust_css+'"> '+cust_title+'</div>';
    infoHtml += '<div class="action-arrow d-flex-">';
    infoHtml += '<span data-id='+pid+' class="arrow-prev angle-right- icon-2x bg-transparent te-font-weight-500  '+cust_color+' pr-2">Previous </span><span class="text-dark- '+cust_color+' te-font-weight-500">|</span><span data-id='+pid+' class="arrow-next angle-right- icon-2x bg-transparent '+cust_color+'  text-black- border- border-dark- te-font-weight-500 mr-md-4 pl-2"> Next</span>';
    infoHtml += '</div>';
    infoHtml += '</div>';
    infoHtml += '<div class="properties-slider slider-'+pid+' p-slider-12 style-12 border-0 pt-5 px-md-5">';
    jQuery.each(data, function (index, obj) {

        if(obj.subdiv == '')
        {
            var sclass = 'pt-5'
        }
        else{
            var sclass = 'pt-6'
        }

        if (obj.Url_Support == 'Yes' && obj.TotalPhotos > 0) {
            if (typeof obj.Pic.large != 'undefined' && obj.Pic.large.url != null && obj.Pic.large.url != '') {
                var url = obj.Pic.large.url;
            }else{
                var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
            }
        }else{
            if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
                var url = obj.Pic;
            }
            else {
                var url = obj.pic +'/no-photo/0/0/';
            }
        }
        infoHtml += '<div id="'+obj.Key+'" class="listing-box px-xl-4 px-0" data-ref-id="'+obj.Key+'">';
            infoHtml += '<div class="listings-height d-block te-property-card te-style-12 te-font-family te-property-gradient position-relative overflow-hidden">' +
                            '<img src="'+ url +'" class="te-property-fig te-property-image position-absolute- lzl-" alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                            /*'<div class="-te-property-gradient position-absolute"></div>';*/
        infoHtml +=            '<div class="style12-overlay"></div>';
        /*infoHtml +=         '<div class="te-smooth-gradient te-property-details te-animate- text-white position-absolute te-z-index-99 '+sclass+ ' te-p-5">' +
                                '<div class="-te-gradient te-trans-  te-property-details te-animate- px-3 pt-2 pb-3 text-white position-absolute te-z-index-99">';*/
        //infoHtml +=             '<h3 class="style4-title text-truncate text-white font-weight-light">'+ obj.subdiv +'</h3>';
        /*infoHtml +=             '<div class="style4-features text-uppercase te-font-size-18 pb-3">'+obj.CityName+', '+ obj.State +' '+obj.ZipCode+'</div>';
                                if(obj.status == 'Closed')
                                {
                                    infoHtml += '<div class="te-property-details-price d-inline">'+ currency + numberFormat(obj.SoldPrice)+'</div>';
                                }
                                else{
                                    infoHtml += '<div class="te-property-details-price d-inline">'+ currency + numberFormat(obj.Price)+'</div>';
                                }
                                if(obj.PriceDiffValue !== 0)
                                {
                                    if(obj.PriceDiffValue < 0)
                                    {
                                        var price = obj.PriceDiffValue;

                                        var price = price.toString().replace('-','');

                                        var text = 'text-danger';
                                        var arrow = '<i class="fas fa-arrow-down"></i>';

                                    }
                                    else if(obj.PriceDiffValue > 0)
                                    {
                                        var text = 'text-success';
                                        var arrow = '<i class="fas fa-arrow-up"></i>';
                                        var price = obj.PriceDiffValue;
                                    }
                                    infoHtml += '<div class=" pl-2 d-inline te-property-details-price-change text-wrap ' + text + '">'+ arrow + currency + numberFormat(price)+'</div>';
                                    infoHtml += '<a href="'+ Site_Url+obj.SFUrl+'" class="btn-style4 text-uppercase float-right text-white border border-white action-btn te-font-size-11 font-weight-light">VIEW DETAILS</a>';
                                }*/
                                /*infoHtml += '<div class="style4-title text-truncate te-font-size-14">'+ obj.subdiv +'</div>';*/
                                    /*infoHtml += '<div class="style4-features te-font-size-14"><span class="float-right"><a href="'+ Site_Url+obj.SFUrl+'" class="btn-style4 text-uppercase">Details</a></span></div>';*/
                /*infoHtml += '</div>';
            infoHtml += '</div>';*/
        infoHtml += '<div class="property-info te-style-12 te-smooth-gradient">';
        if(obj.Type == "ResidentialLease"){

        }
        else {
            infoHtml += '<div class="crypto-data">';
            infoHtml += '<ul class="d-flex p-0 te-font-size-9 justify-content-between- py-1 py-xl-1">';

            infoHtml += '<li class="pr-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/bitcoin.png" alt="bitcoin"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price / bitcoin)) +'</strong></li>';

            infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/etherium.png" alt="etherium"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price / etherium)) +'</strong></li>';
            /*if(numberFormat(Math.round(obj.Price / cardano)) != 0){
                infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/cardano.png" alt="cardano"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price * cardano)) +'</strong></li>';
            }*/

            infoHtml += '</ul></div>';
        }

        infoHtml += '<div class="pb-0"><h5 class="text-white pb-0 text-capitalize te-font-weight-500">'+obj.Address2+'</h5></div>';
        infoHtml += '<div class="te-property-details-features te-font-size-12 pb-2- text-capitalize te-font-weight-500">'+obj.CityName+', '+ obj.State +' '+obj.ZipCode+'</div>';
                        if (obj.PriceDiffValue !== 0) {
                            if (obj.PriceDiffValue < 0) {
                                var price = obj.PriceDiffValue;

                                var price = price.toString().replace('-', '');

                                var text = 'text-danger';
                                var arrow = '<i class="fas fa-arrow-down"></i>';

                            } else if (obj.PriceDiffValue > 0) {
                                var text = 'text-success';
                                var arrow = '<i class="fas fa-arrow-up"></i>';
                                var price = obj.PriceDiffValue;
                            }

                            var price_difference = '<div class=" pl-2 d-inline te-property-details-price-change text-wrap te-font-size-12 te-font-weight-500 ' + text + '">' + arrow + currency + numberFormat(price) + '</div>';
                        }

                        if(price_difference == undefined)
                        {
                            var price_diff = "";
                        }
                        else
                        {
                            var price_diff = price_difference;
                        }

                        if(obj.status == 'Closed')
                        {
                            infoHtml += '<div class="te-property-details-price- d-md-inline pb-sm-3 w-50 w-md-100 te-font-size-12  '+ prop_details +' te-font-weight-500">'+ currency + numberFormat(obj.SoldPrice) + price_diff +'</div>';
                        }
                        else{
                            infoHtml += '<div class="te-property-details-price- d-md-inline pb-sm-3 w-50 w-md-100 te-font-size-12 '+ prop_details +' te-font-weight-500">'+ currency + numberFormat(obj.Price)+ price_diff +'</div>';
                        }

                        infoHtml += '<div class="property-info"><div class="text-right pb-sm-3 pb-md-0"><a href="'+ Site_Url+obj.SFUrl+'" class="btn btn-style1 text-white text-uppercase mt-3 px-sm-5 py-sm-2- py-lg-3- cust-padding '+ details_box +'"><span class="te-font-size-11">VIEW DETAILS</span></a></div></div>';
                        infoHtml += '</div>';
        infoHtml += '</div>';
        infoHtml += '</div>';
    });
    infoHtml += '</div>';
    return infoHtml;
}