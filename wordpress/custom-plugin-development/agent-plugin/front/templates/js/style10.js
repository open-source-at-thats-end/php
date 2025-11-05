function getListingBoxHtml(data)
{
   var infoHtml = '';
   jQuery.each(data, function (index, obj) {

      var FavList = userFavList.split(',');
      if(isGrid !== 'true'){
         var mainClass = 'listings-box col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 p-2';
      }else{
         var mainClass = 'listings-box col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 p-2 s10';
         h_class = '';
      }

      infoHtml += '<div id="' + obj.Key + '" class="'+mainClass+'" data-ref-id="' + obj.Key + '">';
      infoHtml += getMainBoxHtml(obj, FavList);
      infoHtml += '</div>';

   });
   return infoHtml;
}
function getMainBoxHtml(obj, fav) {

   var infoHtml = '';
   var status = '';

   if (obj.status == 'ActiveUnderContract')
   {
      status = 'Under Contract';
   }
   else
   {
      status = obj.status;
   }
   /*infoHtml += '<div  class="'+h_class+' d-block position-relative overflow-hidden pt-5">';
   infoHtml += '<a href="'+ Site_Url+obj.SFUrl+'" class="p-info- pb-0" target="_blank">' +
                   '<span class="status position-absolute font-weight-bold">'+obj.status+'</span>' ;
                     if (obj.Url_Support == 'Yes' && obj.TotalPhotos > 0) {
                        if (typeof obj.Pic.large != 'undefined' && obj.Pic.large.url != null && obj.Pic.large.url != '') {
                           infoHtml += '<img data-lzl="'+ obj.Pic.large.url +'" class="te-property-fig te-property-image position-absolute lzl" alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                        }else{
                           infoHtml += '<img data-lzl="'+ obj.PhotoBaseUrl +'/no-photo/0/0/" class="te-property-fig te-property-image position-absolute lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                        }
                     }else{
                        if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
                            infoHtml += '<img data-lzl="'+ obj.Pic +'" class="te-property-fig te-property-image position-absolute lzl" alt="'+jQuery.trim(obj.AddressSort)+'-1">';

                        }
                        else {
                            infoHtml += '<img data-lzl="'+ obj.pic +'/no-photo/0/0/" class="te-property-fig te-property-image position-absolute lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                        }
                     }
   infoHtml += '</a></div>' ;
   infoHtml += '<a href="'+ Site_Url+obj.SFUrl+'" class="pb-0 te-property-details" target="_blank"><div class="card-body pl-0- px-0 text-dark">' +
       '<p itemprop="name" class="card-text pb-2">' + currency + numberFormat(obj.Price) + '</p>' +
       '<div class="pb-2 font-size-14 font-weight-bold">'+obj.Address+'</div>' +
       '<div class="pb-2 font-size-14">'+obj.Bed+' Beds <span>|</span> '+obj.BathsFull+' Baths <span>|</span> '+numberFormat(obj.Sqft)+' Sq Ft</div>' +
       '</div>' +
       '</a>' ;*/

  /* var popup = '';
   if (hideAddress != undefined && hideAddress == 'Yes') {
      if (isUserLoggedIn != undefined && isUserLoggedIn != '' && isUserLoggedIn == true) {
         popup = '<a href="'+ Site_Url+obj.SFUrl+'" class="'+h_class+' p10 card  te-font-family te-style-10 position-relative overflow-hidden border-0 rounded-0">\n' ;
      }else{
         popup = '<a href="JavaScript:void(0);" class="popup-modal-sm '+h_class+' p10 card  te-font-family te-style-10 position-relative overflow-hidden border-0 rounded-0" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="' + Site_Url + memberDetail + '/?action=member-login&mlsNum=' + obj.Key + '">';
      }
   }else{
      popup = '<a href="'+ Site_Url+obj.SFUrl+'" class="'+h_class+' p10 card  te-font-family te-style-10 position-relative overflow-hidden border-0 rounded-0">\n' ;
   }*/

   if (agent_Profile_Id != undefined && agent_Profile_Id != '' ) {
      infoHtml += '<a href="' + Site_Url + obj.SFUrl + "aid-" + agent_Profile_Id + '/" class="' + h_class + ' p10 card  te-font-family te-style-10 position-relative overflow-hidden border-0 rounded-0">\n';
   }
   else{
      infoHtml += '<a href="' + Site_Url + obj.SFUrl + '" class="' + h_class + ' p10 card  te-font-family te-style-10 position-relative overflow-hidden border-0 rounded-0">\n';
   }

   infoHtml += '<span class="listing-status position-absolute font-weight-bold">'+status+'</span>' ;

   infoHtml +=   '<div class="figure">\n' ;
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
                        if (obj.Url_Support == 'Yes' && obj.TotalPhotos > 0) {
                           if (typeof obj.Pic.large != 'undefined' && obj.Pic.large.url != null && obj.Pic.large.url != '') {
                              infoHtml += '<img data-lzl="'+ obj.Pic.large.url +'" class="te-property-fig te-property-image lzl" alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                           }else{
                              infoHtml += '<img data-lzl="'+ obj.PhotoBaseUrl +'/no-photo/0/0/" class="te-property-fig te-property-image lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                           }
                        }else{
                           if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
                              infoHtml += '<img data-lzl="'+ obj.Pic +'" class="te-property-fig te-property-image lzl" alt="'+jQuery.trim(obj.AddressSort)+'-1">';

                           }
                           else {
                              infoHtml += '<img data-lzl="'+ obj.pic +'/no-photo/0/0/" class="te-property-fig te-property-image lzl"  alt="'+jQuery.trim(obj.AddressSort)+'-1">';
                           }
                        }
   infoHtml +=  '</div>\n' +
                  '<div class="card-body te-style-10 pl-0- px-0 text-dark">' +
                  '<div itemprop="name" class="card-text pb-2- te-font-size-15 te-font-weight-600">' + currency + numberFormat(obj.Price) ;

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
                     infoHtml +=  '</div> <div class="w-50 float-left text-truncate float-start-">';
                     if (hideAddress != undefined && hideAddress == 'Yes') {
                        if (isUserLoggedIn != undefined && isUserLoggedIn != '' && isUserLoggedIn == true) {
                           infoHtml +=  '<div class="pb-1- te-font-size-12 font-weight-600">'+obj.Address2+'</div>' ;
                        }else{
                           infoHtml += '<div class="pb-1- te-font-size-13 font-weight-600">';
                           infoHtml += '<span href="JavaScript:void(0);" style="cursor: pointer" class="popup-modal-sm" aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="' + Site_Url + memberDetail + '/?action=member-login&mlsNum=' + obj.Key + '">';
                           infoHtml += 'Register For Details';
                           infoHtml += '</span></div>';
                        }
                     }else{
                        infoHtml +=  '<div class="pb-1- te-font-size-12 font-weight-600">'+obj.Address2+'</div>' ;
                     }
                     // infoHtml += '<div class="pb-1- te-font-size-12 te-font-weight-600">'+obj.Address2+'</div>' ;
                     infoHtml += '<div class="pb-2- te-font-size-12 text-truncate te-font-weight-600">'+obj.CityName+', '+ obj.State +' '+obj.ZipCode+'</div></div>' +
                         /*'<div class="w-50 float-right float-end- text-right"><div class="pb-2- te-font-size-12 font-weight-600">'+obj.Bed+' Beds <span>|</span> '+obj.BathsFull+' Baths <span>|</span> '+numberFormat(obj.Sqft)+' <br>Sq Ft</div></div>' +*/
                         '<div class="w-50 float-right float-end- text-right"><div class="te-property-details-features te-font-size-12"><ul class="d-flex text-center te-font-weight-600 justify-content-end p-0 te-font-size-12 pb-2- ">';
                     if(jQuery.inArray(obj.Type, JSON.parse(arrPType)) < 0 && jQuery.inArray(obj.SubType, JSON.parse(arrSType)) < 0)
                        infoHtml += '<li class="border-right px-2 px-lg-2 px-xl-2 text-center">'+obj.Bed+' </br> Beds </li>  <li class="border-right px-2 px-lg-2 px-xl-2  text-center">'+obj.BathsFull+' </br> Baths </li>';

                     infoHtml += '<li class="pl-2 pl-lg-2 pl-xl-2 text-center"> '+numberFormat(obj.Sqft)+' </br> Sq. Ft.</li></ul></div></div>' +
                         '</div>' +
                         '</a></div>' ;

   return infoHtml;
}