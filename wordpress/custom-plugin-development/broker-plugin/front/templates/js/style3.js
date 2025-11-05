jQuery(document).ready(function () {
    jQuery('.properties-slider-3').slick({
        autoplay: true,
        autoplaySpeed: 9000,

    });
    jQuery('.properties-slider-3').on("beforeChange", function (event, slick, currentSlide, nextSlide){

        jQuery(this).find('.style3-overlay').removeClass("animation");
        jQuery(this).find('.property-info-3').removeClass("animation");
        jQuery(this).find('.style3-overlay').addClass("d-none");
        jQuery(this).find('.property-info-3').addClass("d-none");

    });
    jQuery('.properties-slider-3').on("afterChange", function (){

        jQuery(this).find('.style3-overlay').addClass("animation");
        jQuery(this).find('.property-info-3').addClass("animation");
        jQuery(this).find('.style3-overlay').removeClass("d-none");
        jQuery(this).find('.property-info-3').removeClass("d-none");
    });
});
function getListingBoxHtml(data){

    var infoHtml = '';

    infoHtml += '<div class="properties-slider-3 te-font-family position-relative">';
    jQuery.each(data, function (index, obj) {

        if(obj.Desc == !null)
        {
            var desc = truncate(obj.Desc,325);
        }

        if (obj.Url_Support == 'Yes' && obj.TotalPhotos > 0) {
            if (typeof obj.Pic.large != 'undefined' && obj.Pic.large.url != null && obj.Pic.large.url != '') {
                var url = obj.Pic.large.url;
            }else{
                var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
            }
        }
       else{
            /*if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
                var url = obj.Pic;
            }
            else {
                var url = obj.pic +'/no-photo/0/0/';
            }*/
            //var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
            if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
                var url = obj.Pic;
            }
            else {
                var url = obj.pic +'/no-photo/0/0/';
            }

        }
        infoHtml += '<div class="slick-slide-img position-relative te-style-3">' +
            '<img src="'+url+'" alt="'+jQuery.trim(obj.AddressSort)+'-1" class="w-100 max-h-100">' +
            '<div class="style3-overlay animation"></div>' +
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
            '<div class="property-info-3 animation">' ;
        if(obj.status == 'Closed')
        {
            infoHtml += '<div class="te-property-details-price d-inline pb-3">'+ currency + numberFormat(obj.SoldPrice)+'</div>';
        }
        else{
            infoHtml += '<div class="te-property-details-price d-inline pb-3">'+ currency + numberFormat(obj.Price)+'</div>';
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
        infoHtml +=    '<div class="pb-2 style-3-address">'+obj.Address+'</div>' +
         '<div class="pb-2 style-3-address">'+obj.subdiv+'</div>' +
            '<div class="pb-4 style-3-address">'+obj.Bed+' Beds <span>|</span> '+obj.BathsFull+' Baths <span>|</span> '+numberFormat(obj.Sqft)+' Sq Ft</div>' +
            '<div class="font-size-14 pb-5 style-3-desc">'+desc+'</div>';

        infoHtml += '<a href="'+ Site_Url+obj.SFUrl+'" class="btn btn-style3 text-uppercase">Details</a>';
        infoHtml += '</div></div>';
    });
    infoHtml += '</div>';

    return infoHtml;
}
function truncate(str, n){

    const index = str.indexOf(" ", n);

    if(index == -1)
    {
        return str;
    }
    else{
        return (str.length > index) ? str.substr(0, index) + '&hellip;' : str;
    }

}