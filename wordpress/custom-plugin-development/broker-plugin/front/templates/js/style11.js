var view_page_url;
jQuery(document).ready(function () {

    jQuery('.p-slider-11').slick({
        autoplay: true,
        autoplaySpeed: 3000,
        speed: 1000,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: false,
        responsive: [
            {
                breakpoint: 1060,
                settings: {
                    slidesToShow: 2,
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
});
function getListingBoxHtml(data) {

    var infoHtml = '';

    infoHtml += '<div class="properties-slider p-slider-11 card border-0 pt-5 bg-transparent">';
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
            } else {
                var url = obj.PhotoBaseUrl + '/no-photo/0/0/';
            }
        } else {
            if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != '') {
                var url = obj.Pic;
            } else {
                var url = obj.pic + '/no-photo/0/0/';
            }
        }

        if(obj.PriceDiffValue == 0)
        {
            var cus_pt = 'cus-pt';
        }
        else
        {
            var cus_pt = '';
        }

        if(obj.PriceDiffValue !== 0)
        {
            var cus_prc_pt = 'pt-2';
        }
        else
        {
            var cus_prc_pt = '';
        }

    infoHtml += '<div id="'+obj.Key+'" class="listing-box position-relative" data-ref-id="'+obj.Key+'">';
        if (login_enable == 'Yes') {
            infoHtml += '<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-' + obj.Key + '">';
            if (isUserLoggedIn == true) {
                if (typeof obj.fav != 'undefined' && fav.length > 0 && (jQuery.inArray(obj.Key, fav) != -1 || jQuery.inArray(obj.Key.toLowerCase(), fav) != -1)) {
                    infoHtml += '<a href="JavaScript:void(0);" aria-label="button" onclick="JavaScript:UpdateFavorites_Click(\'' + obj.Key + '\', \'Remove\',\'SearchResult\',\'' + user_id + '\');">';
                    infoHtml += '<i class="fas fa-heart fav-icon"></i>';
                    infoHtml += '</a>';
                } else {
                    infoHtml += '<a href="JavaScript:void(0);" aria-label="button" onclick="JavaScript:UpdateFavorites_Click(\'' + obj.Key + '\', \'Add\',\'SearchResult\',\'' + user_id + '\');">';
                    infoHtml += '<i class="far fa-heart fav-icon"></i>';
                    infoHtml += '</a>';
                }
            } else {
                infoHtml += '<a href="JavaScript:void(0);" class="popup-modal-sm" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="' + Site_Url + memberDetail + '/?action=member-login&ReqType=AddFav&mlsNum=' + obj.Key + '">';
                infoHtml += '<i class="far fa-heart fav-icon"></i>';
                infoHtml += '</a>';
            }
            infoHtml += '</div>';
        }

        infoHtml += '<a href="' + Site_Url + obj.SFUrl + '" class="te-property-card te-font-family te-style-11 d-block te-property-gradient position-relative overflow-hidden">' +
                        '<img src="'+ url +'" class="te-property-fig te-property-image position-absolute lzl-" alt="'+jQuery.trim(obj.AddressSort)+'-1">' +
                        '<div class="te-property-gradient position-absolute"></div>' +
                        '<div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 '+sclass+' te-p-5">' +
                            '<div class="-te-gradient te-trans  te-property-details te-animate px-3 py-2 text-white position-absolute te-z-index-99 crypto-data">';

        if(obj.Type == "ResidentialLease"){

        }
        else {
            infoHtml += '<ul class="d-flex p-0 te-font-size-9 justify-content-between- py-1 py-xl-2">';

            infoHtml += '<li class="pr-1 text-center"><img class="d-block mx-auto mb-1 te-font-weight-500 " src="'+Site_Url+'API/upload/pictures/bitcoin.png" alt="bitcoin"> APPROX <span class="d-block">'+ numberFormat(Math.round(obj.Price / bitcoin)) +'</span></li>';

            infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1 te-font-weight-500 " src="'+Site_Url+'API/upload/pictures/etherium.png" alt="etherium"> APPROX <span class="d-block">'+ numberFormat(Math.round(obj.Price / etherium)) +'</span></li>';
            /*if(numberFormat(Math.round(obj.Price / cardano)) != 0){
                infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/cardano.png" alt="cardano"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price * cardano)) +'</strong></li>';
            }*/

            infoHtml += '</ul>';
        }
        infoHtml += '<div class="w-50 float-left">';
        if(obj.status == 'Closed')
        {
            infoHtml += '<div class="te-property-details-price d-inline te-font-size-15 te-font-weight-600 ">'+ currency + numberFormat(obj.SoldPrice)+'</div>';
        }
        else{
            infoHtml += '<div class="te-property-details-price d-inline te-font-size-15 te-font-weight-600 ">'+ currency + numberFormat(obj.Price)+'</div>';
        }


        infoHtml += '<div class="te-property-title text-truncate te-font-size-11 te-font-weight-400">'+ obj.Address +'</div>';
        infoHtml += '<div class="te-property-title text-truncate te-font-size-11 te-font-weight-400">'+ obj.CityName +' '+ obj.State +', '+ obj.ZipCode +'</div>';
       /* infoHtml += '<div class="te-property-title  text-truncate te-font-size-14">'+ obj.subdiv +'</div>';*/
        infoHtml += '</div>';

        infoHtml += '<div class="w-50 float-right float-end- text-right">';
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
            infoHtml += '<div class=" pl-2 d-inline te-property-details-price-change text-wrap te-font-size-15 te-font-weight-600 ' + text + '">'+ arrow + currency + numberFormat(price)+'</div>';

        }
        //infoHtml += '<div class="te-property-details-features te-font-size-12">'+obj.Bed+' Beds <span>|</span> '+obj.BathsFull+' Baths <span>|</span> '+numberFormat(obj.Sqft)+' Sq Ft</div>';
        infoHtml += '<div class="te-property-details-features te-font-size-10"><ul class="d-flex text-center te-font-weight-400 justify-content-end p-0 te-font-size-11 pb-2 '+ cus_pt +' "><li class="border-right px-2 px-lg-2 px-xl-2 text-center">'+obj.Bed+' </br> Beds </li>  <li class="border-right px-2 px-lg-2 px-xl-2  text-center">'+obj.BathsFull+' </br> Baths </li> <li class="pl-2 pl-lg-2 pl-xl-2 text-center"> '+numberFormat(obj.Sqft)+' </br> Sq. Ft.</li></ul></div>';
        infoHtml += '</div>';

        infoHtml += '</div>';
        infoHtml += '<div class="te-property-details-cta te-animate text-uppercase  font-weight-bold px-3 py-3">View Details</div></div>';
        infoHtml += '</a>';
        infoHtml += '<div class="top-left">';
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

        if(obj.virtual_tour_url !== '' && obj.virtual_tour_url != null && ((obj.virtual_tour_url.indexOf("youtube.com/") > -1) || (obj.virtual_tour_url.indexOf("youtu.be/") > -1) || (obj.virtual_tour_url.indexOf("vimeo.com/") > -1) || (obj.virtual_tour_url.indexOf("Matterport.com/") > -1)))
        {
            infoHtml += '<span class="wedges list-wedge tour-wedge">Virtual Tour</span>';
        }
        infoHtml += '</div>';

        /*infoHtml += '<div class="position-absolute te-property-favourite te-z-index-99 fav-link-container-'+obj.Key+'">';
        if (isUserLoggedIn == true)
        {
            if(typeof obj.fav != 'undefined' && fav.length > 0  &&(jQuery.inArray(obj.Key,fav) != -1 || jQuery.inArray(obj.Key.toLowerCase(),fav) != -1 ))
            {
                infoHtml += '<a href="JavaScript:void(0);" aria-label="button" onclick="JavaScript:UpdateFavorites_Click(\'' + obj.Key + '\', \'Remove\',\'SearchResult\',\'' + user_id + '\');">';
                infoHtml += '<i class="fas fa-heart fav-icon"></i>';
                infoHtml += '</a>';
            }else{
                infoHtml += '<a href="JavaScript:void(0);" aria-label="button" onclick="JavaScript:UpdateFavorites_Click(\'' + obj.Key + '\', \'Add\',\'SearchResult\',\'' + user_id + '\');">';
                infoHtml += '<i class="far fa-heart fav-icon"></i>';
                infoHtml += '</a>';
            }
        }else{
            infoHtml += '<a href="JavaScript:void(0);" class="popup-modal-sm" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="'+ Site_Url + memberDetail + '/?action=member-login&ReqType=AddFav&mlsNum='+obj.Key+'">';
            infoHtml += '<i class="far fa-heart fav-icon"></i>';
            infoHtml += '</a>';
        }
        infoHtml += '</div>';*/
        infoHtml += '</div>';

    });
    infoHtml += '</div>';
    return infoHtml;
}