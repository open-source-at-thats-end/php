var img_h = '';
var view_page_url;
var styleCSS;
jQuery(document).ready(function () {

    jQuery('.p-slider-9').slick({
        autoplay: true,
        autoplaySpeed: 3000,
        speed: 1000,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: false,
        responsive: [
            {
                breakpoint: 1024,
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
function changeAddress()
{
    var next = jQuery('.slick-active').next();
    jQuery('#p_next').html("NEXT: " + jQuery(next).data('address'));
}
function SliderBindings()
{
    /*jQuery('.p-slider-9').on("afterChange", function (){
        changeAddress();
    });
    jQuery('.arrow-next').on('click',function () {
        jQuery('.p-slider-9').slick("slickNext");
    });
    jQuery('.arrow-prev').on('click',function () {
        jQuery('.p-slider-9').slick("slickPrev");
    });*/

    jQuery('.arrow-next').on('click',function () {
        var pid = jQuery(this).attr('data-id');

        jQuery('.p-slider9-'+pid).slick("slickNext");
    });
    jQuery('.arrow-prev').on('click',function () {
        var pid = jQuery(this).attr('data-id');
        jQuery('.p-slider9-'+pid).slick("slickPrev");
    });


}
function getListingBoxHtml(data,pid = ''){

if(pid != ''){
        cust_url = jQuery("#url_"+pid).val();

    }
    else {
         cust_url = ViewURL;

    }

    var infoHtml = '';
    var status = '';
    if(isstyle != 'undefined' && isstyle == 7)
    {
        img_h = "slide-img";
    }

    /*infoHtml += '<div class="p-5" style="'+styleCSS+'">Sold Properties</div>';*/
    infoHtml += '<div class="properties-slider p-slider9-'+pid+' p-slider-9 card bg-transparent border-0 pt-5">';
    jQuery.each(data, function (index, obj) {

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
            //var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
        }

        if (obj.status == 'ActiveUnderContract')
        {
            status = 'Under Contract';
        }
        else
        {
            status = obj.status;
        }

        /*infoHtml += '<div data-address="'+jQuery.trim(obj.Address2)+'"><a class="p-info" href="'+ Site_Url+obj.SFUrl+'" target="_blank">' +
            '<img src="'+url+'" alt="'+jQuery.trim(obj.AddressSort)+'-1" class=" '+img_h+'">' +

            '<div class="property-info-label">';
        if(obj.status == 'ActiveUnderContract')
        {
            infoHtml += '<div class="wedges list-wedge">Under Contract</div>';
        }
        if(obj.status == 'Pending')
        {
            infoHtml += '<div class="wedges list-wedge">Pending</div>';
        }
        if(obj.DOM < 7)
        {
            infoHtml += '<div class="wedges-newListing list-wedge">New Listing</div>';
        }
        if(obj.status == 'Closed')
        {
            infoHtml += '<span class="wedges list-wedge">Closed</span>';
        }
        if(obj.virtual_tour_url !== '' && obj.virtual_tour_url != null && (obj.virtual_tour_url.indexOf("youtube.com/") > -1) || (obj.virtual_tour_url.indexOf("youtu.be/") > -1) || (obj.virtual_tour_url.indexOf("vimeo.com/") > -1) || (obj.virtual_tour_url.indexOf("Matterport.com/") > -1))
        {
            infoHtml += '<span class="wedges list-wedge tour-wedge">Virtual Tour</span>';
        }
        infoHtml += '</div>';
        infoHtml += '</a>';
        /!*infoHtml += '<div class="p-info-item">';*!/
        if(obj.status == 'Closed')
        {
            infoHtml += '<div class="te-property-details-price d-inline"><span class="">'+ currency + numberFormat(obj.SoldPrice)+'</span><span class="angle-right icon-2x bg-black text-white float-right"><i class="fas fa-angle-right"></i></span></div>';
        }
        else {
            infoHtml += '<div class="te-property-details-price d-inline "><span class="">' + currency + numberFormat(obj.Price) + '</span><span class="angle-right icon-2x bg-black text-white float-right"><i class="fas fa-angle-right"></i></span></div>';
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

        }
        infoHtml += '<div class="pb-2 p-address"><span>'+obj.Address2+' - </span>' + '<span>'+obj.CityName+'</span>, ' + '<span>'+obj.State+'</span> ' + '<span>'+obj.ZipCode+'</span></div>';
        infoHtml +=  '<div class="pb-2">'+obj.Bed+' Beds <span>|</span> '+obj.BathsFull+' Baths <span>|</span> '+numberFormat(obj.Sqft)+' Sq Ft</div>';
        infoHtml+= '</div>';

        /!*infoHtml += '</div>';*!/
    });
    infoHtml += '</div>';
    infoHtml += '<div class="p-action"><div class="action-arrow d-flex">';
    infoHtml += '<span class="arrow-prev angle-right icon-2x bg-white text-black border border-dark mr-3"><i class="fas fa-angle-left"></i></span><span class="arrow-next angle-right icon-2x bg-white text-black border border-dark mr-4"><i class="fas fa-angle-right"></i></span>';
    /!*infoHtml += '<span id="p_next"> NEXT: </span>';*!/
    infoHtml += '</div>';
    infoHtml += '<a href="'+view_page_url+'" class="btn lpt-btn lpt-btn-txt action-btn"> View All</a>';
    infoHtml += '</div>';*/
    /* Demo HTML */

        /*var popup = '';
        if (hideAddress != undefined && hideAddress == 'Yes') {
            if (isUserLoggedIn != undefined && isUserLoggedIn != '' && isUserLoggedIn == true) {
                popup = '<a href="'+ Site_Url+obj.SFUrl+'" class="p-info- pb-0 te-property-card te-style-9 te-font-family overflow-hidden">';
            }else{
                popup = '<a href="JavaScript:void(0);" class="popup-modal-sm listings-height d-block te-style-6 te-font-family te-property-gradient position-relative overflow-hidden" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="' + Site_Url + memberDetail + '/?action=member-login&mlsNum=' + obj.Key + '">';
            }
        }else{
            popup = '<a href="'+ Site_Url+obj.SFUrl+'" class="p-info- pb-0 te-property-card te-style-9 te-font-family overflow-hidden">';
        }*/

    infoHtml += '<div id="'+obj.Key+'" data-ref-id="'+obj.Key+'" class="">';

    if (agent_Profile_Id != undefined && agent_Profile_Id != '' ) {
        infoHtml += popup = '<a href="' + Site_Url + obj.SFUrl + "aid-" + agent_Profile_Id + '/" class="p-info- pb-0 te-property-card te-style-9 te-font-family overflow-hidden">';
    }
    else{
        infoHtml += popup = '<a href="' + Site_Url + obj.SFUrl + '" class="p-info- pb-0 te-property-card te-style-9 te-font-family overflow-hidden">';
    }

    infoHtml += '<p class="listing-status position-absolute font-weight-bold">'+status+'</p>';
    if(AgentCryptoValue == true) {
        if (obj.Type == "ResidentialLease") {

        } else {
            infoHtml += '<div class="crypto-data position-absolute">';
            infoHtml += '<ul class="d-flex p-0 te-font-size-9 justify-content-between- py-1 py-xl-1">';

            infoHtml += '<li class="pr-3 px-1 text-center"><img class="d-block mx-auto mb-1" src="' + Site_Url + 'wp-content/plugins/CustomWpPlugin/upload/pictures/bitcoin.png" alt="bitcoin"> APPROX <strong class="d-block">' + numberFormat(Math.round(obj.Price / bitcoin)) + '</strong></li>';

            infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="' + Site_Url + 'wp-content/plugins/CustomWpPlugin/upload/pictures/etherium.png" alt="etherium"> APPROX <strong class="d-block">' + numberFormat(Math.round(obj.Price / etherium)) + '</strong></li>';
            /*if(numberFormat(Math.round(obj.Price / cardano)) != 0){
                infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/cardano.png" alt="cardano"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price * cardano)) +'</strong></li>';
            }*/

            infoHtml += '</ul></div>';
        }
    }
        infoHtml +=  '<img alt="'+jQuery.trim(obj.AddressSort)+'-1" class="property-img te-property-image te-property-fig '+img_h+'" src="'+ url +'">';

        if (agent_Profile_Id != undefined && agent_Profile_Id != '' ) {
            infoHtml += '</a> <a href="' + Site_Url + obj.SFUrl + "aid-" + agent_Profile_Id + '/" class="pb-0" target="_blank"><div class="card-body te-style-9 te-font-family pl-0- px-0 text-dark- style9_text_color">' +
                '<div itemprop="name" class="card-text pb-1- te-font-size-15 te-font-weight-600">' + currency + numberFormat(obj.Price);
        }
        else{
            infoHtml += '</a> <a href="' + Site_Url + obj.SFUrl + '" class="pb-0" target="_blank"><div class="card-body te-style-9 te-font-family pl-0- px-0 text-dark- style9_text_color">' +
                '<div itemprop="name" class="card-text pb-1- te-font-size-15 te-font-weight-600">' + currency + numberFormat(obj.Price);
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
            infoHtml += '<span class=" pl-2 d-inline te-property-details-price-change- text-wrap pb-2- te-font-weight-600 te-font-size-15 ' + text + '">'+ arrow + currency + numberFormat(price)+'</span>';

        }
                        /*'<div class="te-property-details-price d-inline "><span class="">' + currency + numberFormat(obj.Price) + '</span></div>' +*/
                        /*'<h5 itemprop="address" class="card-title pb-0">'+obj.Address+'</h5>' +*/
                        /*'<div class="pb-2 font-size-14 font-weight-bold">'+obj.Address2+'</div>' +
                        '<div class="pb-2 font-size-14 font-weight-bold">'+obj.CityName+', '+ obj.State +' '+obj.ZipCode+'</div>' +*/
        infoHtml +=  '</div> <div class="w-50 float-left float-start-">';
        if (hideAddress != undefined && hideAddress == 'Yes') {
            if (isUserLoggedIn != undefined && isUserLoggedIn != '' && isUserLoggedIn == true) {
                infoHtml +=  '<div class="pb-1- te-font-size-12 font-weight-600">'+obj.Address2+'</div>' ;
            }else{
                infoHtml += '<div class="pb-1- te-font-size-14 font-weight-600">';
                infoHtml += '<span href="JavaScript:void(0);" style="cursor: pointer" class="popup-modal-sm" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="' + Site_Url + memberDetail + '/?action=member-login&mlsNum=' + obj.Key + '">';
                infoHtml += 'Register For Details';
                infoHtml += '</span></div>';
            }
        }else{
            infoHtml +=  '<div class="pb-1- te-font-size-12 font-weight-600">'+obj.Address2+'</div>' ;
        }
        // infoHtml +=  '</div> <div class="w-50 float-left float-start-"><div class="pb-1- te-font-size-12 font-weight-600">'+obj.Address2+'</div>' ;
        infoHtml += '<div class="pb-2- te-font-size-12 font-weight-600">'+obj.CityName+', '+ obj.State +' '+obj.ZipCode+'</div></div>' +
                        /*'<div class="w-50 float-right float-end- text-right"><div class="pb-2- te-font-size-12 font-weight-600">'+obj.Bed+' Beds <span>|</span> '+obj.BathsFull+' Baths <span>|</span> '+numberFormat(obj.Sqft)+' <br>Sq Ft</div></div>' +*/
                        '<div class="w-50 float-right float-end- text-right"><div class="te-property-details-features te-font-size-12"><ul class="d-flex text-center te-font-weight-600 justify-content-end p-0 te-font-size-12 pb-2- ">';

        if(jQuery.inArray(obj.Type, JSON.parse(arrPType)) < 0 && jQuery.inArray(obj.SubType, JSON.parse(arrSType)) < 0)
            infoHtml += '<li class="border-right style9_text_color px-2 px-lg-2 px-xl-2 text-center">'+obj.Bed+' </br> Beds </li>  <li class="border-right style9_text_color px-2 px-lg-2 px-xl-2  text-center">'+obj.BathsFull+' </br> Baths </li>';

        infoHtml += '<li class="pl-2 pl-lg-2 pl-xl-2 text-center"> '+numberFormat(obj.Sqft)+' </br> Sq. Ft.</li></ul></div></div>' +
                    '</div>' +
                '</a></div>' ;
    });
    infoHtml += '</div>';
    infoHtml += '<div class="p9 properties-slider  p-action bg-transparent- pt-3 mx-3- pb-5- d-flex align-items-between"><div class="action-arrow d-flex">';
    infoHtml += '<span data-id='+pid+' class="arrow-prev slick-prev slick-arrow icon-2x bg-transparent- style9_bg_color style9_bg_hvr_color style9_bdr_color style9_bdr_hvr_color style9_text_color- mr-3 text-center"></span><span data-id='+pid+' class="arrow-next slick-next slick-arrow icon-2x bg-transparent- style9_bg_color style9_bg_hvr_color style9_bdr_hvr_color style9_bdr_color style9_text_color- mr-4 text-center"></span>';
    infoHtml += '</div>';
    infoHtml += '<div><a href="'+Site_Url+cust_url+'" class="btn btn-style9 link-color- style9_bdr_color style9_text_color style9_bg_hvr_color bg-transparent- style9_bg_color style9_bdr_hvr_color action-btn text-uppercase text-error font-size-14 px-sm-4 px-3"> View All</a></div>';

    return infoHtml;
}