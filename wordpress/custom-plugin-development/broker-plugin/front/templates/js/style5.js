var h_class = '';
function getListingBoxHtml(data)
{
    var infoHtml = '';
    jQuery.each(data, function (index, obj) {

        var FavList = userFavList.split(',');
        if(isGrid !== 'true'){
            var mainClass = 'listings-box col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 p-2';
        }else{

            if(isstyle != 'undefined' && isstyle == 5)
            {
                var mainClass = '-listings-height listings-box col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 p-2';
                h_class = 'listings-height';
            }
            else{
                var mainClass = 'listings-box col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 p-2';
                 h_class = 'te-property-card';
            }
        }

        infoHtml += '<div id="' + obj.Key + '" class="'+mainClass+'" data-ref-id="' + obj.Key + '">';
        infoHtml += getMainBoxHtml(obj, FavList);
        infoHtml += '</div>';

    });
    return infoHtml;
}
function getMainBoxHtml(obj, fav) {

    var infoHtml = '';
    if(obj.subdiv == '')
        {
            var sclass = 'pt-100'
        }
        else{
            var sclass = 'pt-120'
        }
    // infoHtml += '<div id="' + obj.Key + '" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-0" data-ref-id="' + obj.Key + '">';
    infoHtml += '<a href="'+ Site_Url+obj.SFUrl+'" class="'+h_class+' d-block te-property-gradient te-font-family te-style-5 position-relative overflow-hidden">';

        if (obj.Url_Support == 'Yes' && obj.TotalPhotos > 0) {
        if (typeof obj.Pic.large != 'undefined' && obj.Pic.large.url != null && obj.Pic.large.url != '') {
            infoHtml += '<img data-lzl="'+ obj.Pic.large.url +'" class="te-property-fig te-property-image position-absolute lzl" alt="'+jQuery.trim(obj.AddressSort)+'-1">';
        }else{
            infoHtml += '<img data-lzl="'+ obj.PhotoBaseUrl +'/no-photo/0/0/" class="te-property-fig te-property-image position-absolute lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';
        }
    }else{
        /*if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
            infoHtml += '<img data-lzl="'+ obj.Pic +'" class="te-property-fig te-property-image position-absolute lzl" alt="'+jQuery.trim(obj.AddressSort)+'-1">';

        }
        else {
            infoHtml += '<img data-lzl="'+ obj.pic +'/no-photo/0/0/" class="te-property-fig te-property-image position-absolute lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';
        }*/
        //infoHtml += '<img data-lzl="'+ obj.PhotoBaseUrl +'/no-photo/0/0/" class="te-property-fig te-property-image position-absolute lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';


        if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
            infoHtml += '<img data-lzl="'+ obj.Pic +'" class="te-property-fig te-property-image position-absolute lzl" alt="'+jQuery.trim(obj.AddressSort)+'-1">';

        }
        else {
            infoHtml += '<img data-lzl="'+ obj.pic +'/no-photo/0/0/" class="te-property-fig te-property-image position-absolute lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';
        }

    }

    infoHtml += '<div class="-te-property-gradient position-absolute"></div>';
    infoHtml += '<div class="te-smooth-gradient te-property-details te-animate text-white position-absolute te-z-index-99 '+sclass+ ' te-p-5"><div class="-te-gradient te-trans  te-property-details te-animate px-3 pt-2 pb-3 text-white position-absolute te-z-index-99">';


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



    if(obj.status == 'Closed')
    {
        infoHtml += '<div class="te-property-details-price d-inline  te-font-size-18 pb-1">'+ currency + numberFormat(obj.SoldPrice)+'</div>';
    }
    else{
        infoHtml += '<div class="te-property-details-price d-inline  te-font-size-18 pb-1">'+ currency + numberFormat(obj.Price)+'</div>';
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
        infoHtml += '<div class=" pl-2 d-inline te-property-details-price-change text-wrap  te-font-size-18 ' + text + '">'+ arrow + currency + numberFormat(price)+'</div>';

    }

    infoHtml += '<div class="style4-title text-truncate te-font-size-14 pb-1- te-font-weight-500">'+ obj.Address +'</div>';
        infoHtml += '<div class="style4-title text-truncate te-font-size-14 te-font-weight-600 pb-1-">'+ obj.subdiv +'</div>';
    infoHtml += '<div class="style4-features te-font-size-14 te-font-weight-500">'+obj.Bed+' Beds <span>|</span> '+obj.BathsFull+' Baths <span>|</span> '+numberFormat(obj.Sqft)+' Sq Ft</div>';

    infoHtml += '</div>';
    infoHtml += '</div>';
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
   if(obj.virtual_tour_url !== '' && obj.virtual_tour_url != null && (obj.virtual_tour_url.indexOf("youtube.com/") > -1) || (obj.virtual_tour_url.indexOf("youtu.be/") > -1) || (obj.virtual_tour_url.indexOf("vimeo.com/") > -1) || (obj.virtual_tour_url.indexOf("Matterport.com/") > -1))
    {
        infoHtml += '<span class="wedges list-wedge tour-wedge">Virtual Tour</span>';
    }
    infoHtml += '</div>';
    if (login_enable == 'Yes') {
        infoHtml += '<div class="position-absolute te-property-favourite te-z-index-99 img-fav fav-link-container-' + obj.Key + '">';
        if (isUserLoggedIn == true) {
            if (fav.length > 0 && (jQuery.inArray(obj.Key, fav) != -1 || jQuery.inArray(obj.Key.toLowerCase(), fav) != -1)) {
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
    // infoHtml += '</div>';

    return infoHtml;
}