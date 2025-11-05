var img_h = '';
jQuery(document).ready(function () {

   jQuery('.properties-slider').slick({
  autoplay: true,
       autoplaySpeed: 3000,
   });
});
function getListingBoxHtml(data){

   var infoHtml = '';
    if(isstyle != 'undefined' && isstyle == 7)
    {
        img_h = "slide-img";
    }
   infoHtml += '<div class="properties-slider position-relative">';
      jQuery.each(data, function (index, obj) {

         if (obj.Url_Support == 'Yes') {
            if (typeof obj.Pic.large != 'undefined' && obj.Pic.large.url != null) {
               var url = obj.Pic.large.url;
            }else{
               var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
            }
         }else{
            var url = obj.pic +'/no-photo/0/0/';
         }
         infoHtml += '<div class="slick-slide-img position-relative">' +
             '<img src="'+url+'" alt="'+jQuery.trim(obj.AddressSort)+'-1" class="w-100 max-h-100 '+img_h+'">' +
             '<div class="style1-overlay"></div>' +
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
    infoHtml += '</div>' +
             '<div class="property-info">' +
             '<div class="pb-2">'+obj.Address+'</div>' +
             '<div class="pb-2">'+obj.subdiv+'</div>' +
             '<div class="pb-2">'+obj.Bed+' Beds <span>|</span> '+obj.BathsFull+' Baths <span>|</span> '+numberFormat(obj.Sqft)+' Sq Ft</div>';
         if(obj.status == 'Closed')
         {
            infoHtml += '<div class="te-property-details-price d-inline pb-3">'+ currency + numberFormat(obj.SoldPrice)+'</div>';
         }
         else{
            infoHtml += '<div class="te-property-details-price  d-inline pb-3">'+ currency + numberFormat(obj.Price)+'</div>';
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
         infoHtml += '<a href="'+ Site_Url+obj.SFUrl+'" class="btn btn-style1 text-white text-uppercase">Details</a>';
         infoHtml += '</div></div>';
      });
   infoHtml += '</div>';

   return infoHtml;
}