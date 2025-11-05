var img_h = '';
var style_1_7 = '';
var slide_img_h = '';
var prop_details = '';
var details_box = '';

var header_height= jQuery("#main-header").outerHeight();

var img_height = 100 - ( header_height * 0.10471204188481675);

jQuery(document).ready(function () {

   jQuery('.properties-slider').slick({
       autoplay: false,
       autoplaySpeed: 3000,
       speed: 1000,
       fade: true,
   });
    jQuery(".properties-slider .slick-slide img").css('height',img_height + 'vh');
});
function getListingBoxHtml(data){

    var infoHtml = '';
    style_1_7 = "style-1-7";
    prop_details = "te-property-details";
    details_box = "details-box";

    if(isstyle != 'undefined' && isstyle == 7)
    {
        img_h = "slide-img";
    }
    if(isstyle != 'undefined' && isstyle == 1)
    {
        slide_img_h = "slide-img-height";
    }
   infoHtml += '<div class="properties-slider te-font-family position-relative '+ style_1_7 +'">';
      jQuery.each(data, function (index, obj) {

         if (obj.Url_Support == 'Yes' && obj.TotalPhotos > 0) {
            if (typeof obj.Pic.large != 'undefined' && obj.Pic.large.url != null && obj.Pic.large.url != '') {
               var url = obj.Pic.large.url;
            }
            else{
               var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
            }
         }
         else{
             /*if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != '') {

                 var url = obj.Pic;
            }
            else
             {
                 var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
             }*/
             if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != '') {

                 var url = obj.Pic;
             }
             else
             {
                 var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
             }

             //var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
         }
         infoHtml += '<div class="slick-slide-img position-relative te-style-1">' +
             '<img src="'+url+'" alt="'+jQuery.trim(obj.AddressSort)+'-1" class="w-100 max-h-100 '+ slide_img_h + img_h +'">' +
             '<div class="style1-overlay"></div>';
             /*'<div class="property-info-label">';*/
              /*if(obj.status == 'ActiveUnderContract')
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
    if(obj.virtual_tour_url !== '' && (obj.virtual_tour_url.indexOf("youtube.com/") > -1) || (obj.virtual_tour_url.indexOf("youtu.be/") > -1) || (obj.virtual_tour_url.indexOf("vimeo.com/") > -1) || (obj.virtual_tour_url.indexOf("Matterport.com/") > -1))
    {
        infoHtml += '<span class="wedges list-wedge tour-wedge">Virtual Tour</span>';
    }*/
    /*infoHtml += '</div>' +*/
          infoHtml +=       '<div class="property-info ">';
              /*if(obj.status == 'ActiveUnderContract')
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
              if(obj.virtual_tour_url !== '' && obj.virtual_tour_url != null  && (obj.virtual_tour_url.indexOf("youtube.com/") > -1) || (obj.virtual_tour_url.indexOf("youtu.be/") > -1) || (obj.virtual_tour_url.indexOf("vimeo.com/") > -1) || (obj.virtual_tour_url.indexOf("Matterport.com/") > -1))
              {
                  infoHtml += '<span class="wedges list-wedge tour-wedge">Virtual Tour</span>';
              }*/


          if(obj.Type == "ResidentialLease"){

          }
          else {
              infoHtml += '<div class="crypto-data pb-1"><ul class="d-flex p-0 te-font-size-10 justify-content-between- py-1 py-xl-2">' +
                  '<li class="pr-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/bitcoin.png" alt="bitcoin"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price / bitcoin)) +'</strong></li>' +
                  '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/etherium.png" alt="etherium"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price / etherium)) +'</strong></li>' +
                  //'<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/cardano.png" alt="cardano"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price * cardano)) +'</strong></li>' +
                  '</ul></div>';

          }
              infoHtml +=   '<div class="pb-1-"><h3 class="text-white pb-2 pb-0 text-uppercase te-font-size-28 te-address">'+obj.Address2+'</h3></div>';

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

                  var price_difference = '<div class=" pl-2- pt-1 d-inline- te-property-details-price-change te-font-size-21 text-wrap ' + text + '"><i>' + arrow + currency + numberFormat(price) + '</i></div>';
              }

              if(price_difference == undefined)
              {
                  var price_diff = "";
              }
              else
              {
                  var price_diff = price_difference;
              }

             /*if(obj.status == 'Closed')
             {
                infoHtml += '<div class="te-property-details-price- d-md-inline pb-sm-3 w-50 w-md-100 '+ prop_details +'">'+ currency + numberFormat(obj.SoldPrice) + price_diff +' / '+obj.Bed+' Beds / '+obj.BathsFull+' Baths / '+numberFormat(obj.Sqft)+' Sq Ft</div>';
             }
             else{
                infoHtml += '<div class="te-property-details-price- d-md-inline pb-sm-3 w-50 w-md-100 '+ prop_details +'">'+ currency + numberFormat(obj.Price)+ price_diff +' / '+obj.Bed+' Beds / '+obj.BathsFull+' Baths / '+numberFormat(obj.Sqft)+' Sq Ft</div>';
             }*/
          if(obj.status == 'Closed')
          {
              infoHtml += '<div class="te-property-details-price- d-md-inline pb-sm-3 te-font-size-21 w-50 w-md-100 '+ prop_details +'">'+ currency + numberFormat(obj.SoldPrice) +'  &nbsp;|&nbsp; '+obj.Bed+' Beds  &nbsp;|&nbsp; '+obj.BathsFull+' Baths  &nbsp;|&nbsp; '+numberFormat(obj.Sqft)+' Sq Ft</div>';
          }
          else{
              infoHtml += '<div class="te-property-details-price- d-md-inline te-font-size-21 pb-sm-3 w-50 w-md-100 '+ prop_details +'"><i>'+ currency + numberFormat(obj.Price) +' </i>&nbsp; | &nbsp;<i>'+obj.Bed+' Beds  </i>&nbsp;|&nbsp; <i>'+obj.BathsFull+' Baths  </i>&nbsp;|&nbsp; <i>'+numberFormat(obj.Sqft)+' Sq Ft</i></div>';
          }
          infoHtml += price_diff;
          infoHtml += '<div class="property-info"><div class="text-right pb-sm-3 pb-md-0"><a href="'+ Site_Url+obj.SFUrl+'" class="btn btn-style1 text-white text-uppercase mt-3 px-sm-5 py-sm-2- py-lg-3- cust-padding '+ details_box +'"><span class="te-font-size-12">Details</span></a></div></div>';
          infoHtml += '</div></div>';
      });
   infoHtml += '</div>';

   return infoHtml;
}