function getListingBoxHtml(data){

    var infoHtml = '';
    jQuery.each(data, function (index, obj) {
//console.log(obj.AddressSort);
        var fav = userFavList.split(',');

        // var popup = '';
        var listing_address = '';
        if (hideAddress != undefined && hideAddress == 'Yes') {
            if (isUserLoggedIn != undefined && isUserLoggedIn != '' && isUserLoggedIn == true) {
                // popup = '<a href="'+ Site_Url+obj.SFUrl+'" class="style2-property-card te-style-2 position-relative-">';
                listing_address = '<div class="style2-pro-title text-center te-font-size-13 font-weight-500">'+jQuery.trim(obj.Address2)+'</div>';
            }else{
                // popup = '<a href="JavaScript:void(0);" class="popup-modal-sm style2-property-card te-style-2 position-relative-" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="' + Site_Url + memberDetail + '/?action=member-login&mlsNum=' + obj.Key + '">';
                listing_address = '<div class="style2-pro-title text-center te-font-size-13 font-weight-500"><span href="JavaScript:void(0);" class="popup-modal-sm" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="' + Site_Url + memberDetail + '/?action=member-login&mlsNum=' + obj.Key + '"> Register For Details </span></div>';
            }
        }else{
            listing_address = '<div class="style2-pro-title text-center te-font-size-13 font-weight-500">'+jQuery.trim(obj.Address2)+'</div>';
            // popup = '<a href="'+ Site_Url+obj.SFUrl+'" class="style2-property-card te-style-2 position-relative-">';
        }

        infoHtml += '<div class="position-relative">';
        infoHtml += '<div class="style2-property-box te-font-family position-relative p-0">';

        if (agent_Profile_Id != undefined && agent_Profile_Id != '' ) {
            infoHtml += '<a href="' + Site_Url + obj.SFUrl + "aid-" + agent_Profile_Id + '/" class="style2-property-card te-style-2 position-relative-">';
        }
        else{
            infoHtml += '<a href="' + Site_Url + obj.SFUrl + '" class="style2-property-card te-style-2 position-relative-">';
        }


        if (obj.Url_Support == 'Yes' && obj.TotalPhotos > 0) {
            if (typeof obj.Pic.large != 'undefined' && obj.Pic.large.url != null && obj.Pic.large.url != '') {
                //infoHtml += '<img data-lzl="'+ obj.Pic.large.url +'" class="te-property-image te-property-image-style-2 lzl" alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                infoHtml += '<img data-lzl="'+ obj.Pic.large.url +'" class="te-property-image te-property-image-style-2 lzl" alt="'+jQuery.trim(obj.Address2)+'-1">';
            }else{
                //infoHtml += '<img data-lzl="'+ obj.PhotoBaseUrl +'/no-photo/0/0/" class="te-property-image te-property-image-style-2 lzl" src="'+ obj.PhotoBaseUrl +'/no-photo/0/0/" alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                infoHtml += '<img data-lzl="'+ obj.PhotoBaseUrl +'/no-photo/0/0/" class="te-property-image te-property-image-style-2 lzl" src="'+ obj.PhotoBaseUrl +'/no-photo/0/0/" alt="'+jQuery.trim(obj.Address2)+'-1">';
            }
        }
        else{
            /*if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
                infoHtml += '<img data-lzl="'+ obj.Pic +'" class="te-property-image te-property-image-style-2 lzl" alt="'+jQuery.trim(obj.AddressSort)+'-1">';
            }
            else {
                infoHtml += '<img data-lzl="'+ obj.pic +'/no-photo/0/0/" class="te-property-image te-property-image-style-2 lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';
            }*/
            if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
                //infoHtml += '<img data-lzl="'+ obj.Pic +'" class="te-property-image te-property-image-style-2 lzl" alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                infoHtml += '<img data-lzl="'+ obj.Pic +'" class="te-property-image te-property-image-style-2 lzl" alt="'+jQuery.trim(obj.Address2)+'-1">';
            }
            else {
                //infoHtml += '<img data-lzl="'+ obj.pic +'/no-photo/0/0/" class="te-property-image te-property-image-style-2 lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                infoHtml += '<img data-lzl="'+ obj.pic +'/no-photo/0/0/" class="te-property-image te-property-image-style-2 lzl"  alt="'+jQuery.trim(obj.Address2)+'-1">';
            }
            //infoHtml += '<img data-lzl="'+ obj.PhotoBaseUrl +'/no-photo/0/0/" class="te-property-image te-property-image-style-2 lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';
        }
        infoHtml += '<div class="style2-overlay"></div>';
        infoHtml += '<div class="style2-pro-details te-font-size-14">';


        if(AgentCryptoValue == true) {

            if (obj.Type == "ResidentialLease") {

            } else {
                infoHtml += '<div class="crypto-data"><ul class="d-flex p-0 te-font-size-10 justify-content-between- justify-content-center py-1 py-xl-2">';

                infoHtml += '<li class="pr-1 text-center"><img class="d-block mx-auto mb-1" src="' + Site_Url + 'wp-content/plugins/CustomWpPlugin/upload/pictures/bitcoin.png" alt="bitcoin"> APPROX <strong class="d-block">' + numberFormat(Math.round(obj.Price / bitcoin)) + '</strong></li>';

                infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="' + Site_Url + 'wp-content/plugins/CustomWpPlugin/upload/pictures/etherium.png" alt="etherium"> APPROX <strong class="d-block">' + numberFormat(Math.round(obj.Price / etherium)) + '</strong></li>';


                /*infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/cardano.png" alt="cardano"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price * cardano)) +'</strong></li>';*/

                infoHtml += '</ul></div>';
            }
        }
        if(obj.status == 'Closed')
        {
            infoHtml += '<div class="style2-pro-price text-center">'+ currency + numberFormat(obj.SoldPrice)+'</div>';
        }
        else{
            infoHtml += '<div class="style2-pro-price text-center">'+ currency + numberFormat(obj.Price)+'</div>';
        }
       // infoHtml += '<div class="style2-pro-title text-center">'+jQuery.trim(obj.AddressSort)+'</div>';

        infoHtml += listing_address;

        // infoHtml += '<div class="style2-pro-title text-center te-font-size-13 font-weight-500">'+jQuery.trim(obj.Address2)+'</div>';
        infoHtml += '<div class="style2-pro-title text-center text-uppercase te-font-size-12 font-weight-500">'+obj.CityName+'</div>';
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
            infoHtml += '<div class="text-center te-property-details-price-change- price-change text-wrap te-font-size-14- mt-2 font-weight-500 ' + text + '">'+ arrow + currency + numberFormat(price)+'</div>';
        }

        infoHtml += '<div class="text-uppercase mt-2 text-center te-font-size-12 font-weight-500">Details</div>';
        infoHtml += '</div>';

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
        infoHtml += '</a>';
        if (login_enable == 'Yes') {
            infoHtml += '<div class="position-absolute te-property-favourite style2-fav te-z-index-99 fav-link-container-' + obj.Key + '">';

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
        infoHtml += '</div>';

        infoHtml += '</div>';
    });

    return infoHtml;
}