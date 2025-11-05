var img_h = '';
var view_page_url;
jQuery(document).ready(function () {

    jQuery('.p-slider-8').slick({
        autoplay: true,
        autoplaySpeed: 3000,
         arrows: false,
    });
    changeAddress();
    SliderBindings();
});
function changeAddress()
{
    var next = jQuery('.slick-active').next();
    jQuery('#p_next').html("NEXT: " + jQuery(next).data('address'));
}
function SliderBindings()
{
    jQuery('.p-slider-8').on("afterChange", function (){
        changeAddress();

    });
    jQuery('.arrow-next').on('click',function () {
        jQuery('.p-slider-8').slick("slickNext");
    });
    jQuery('.arrow-prev').on('click',function () {
        jQuery('.p-slider-8').slick("slickPrev");
    });
}
function getListingBoxHtml(data){

    var infoHtml = '';
    if(isstyle != 'undefined' && isstyle == 7)
    {
        img_h = "slide-img";
    }
    infoHtml += '<div class="properties-slider te-style-8 te-font-family p-slider-8">';
    jQuery.each(data, function (index, obj) {

        if (obj.Url_Support == 'Yes' && obj.TotalPhotos > 0) {
            if (typeof obj.Pic.large != 'undefined' && obj.Pic.large.url != null && obj.Pic.large.url != '') {
                var url = obj.Pic.large.url;
            }else{
                var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
            }
        }else{
            /*if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
                var url = obj.Pic;
               // console.log(obj.Pic);
            }
            else {
                var url = obj.pic +'/no-photo/0/0/';
            }*/
            //var url = obj.PhotoBaseUrl +'/no-photo/0/0/';
            if (typeof obj.Pic != 'undefined' && obj.Pic != null && obj.Pic != ''){
                var url = obj.Pic;
                // console.log(obj.Pic);
            }
            else {
                var url = obj.pic +'/no-photo/0/0/';
            }
        }
        infoHtml += '<div data-address="'+jQuery.trim(obj.Address2)+'"><a class="p-info" href="'+ Site_Url+obj.SFUrl+'">' +
            '<img src="'+url+'" alt="'+jQuery.trim(obj.AddressSort)+'-1" class=" '+img_h+'">' ;



        infoHtml +=  '<div class="property-info-label">';

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
        /*if(obj.Type == "ResidentialLease"){

        }
        else {
            infoHtml += '<div class="crypto-data position-absolute">';
            infoHtml += '<ul class="d-flex p-0 te-font-size-9 justify-content-between- py-1 py-xl-1">';

            infoHtml += '<li class="pr-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/bitcoin.png" alt="bitcoin"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price / bitcoin)) +'</strong></li>';

            infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/etherium.png" alt="etherium"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price / etherium)) +'</strong></li>';
            /!*if(numberFormat(Math.round(obj.Price / cardano)) != 0){
                infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/cardano.png" alt="cardano"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price * cardano)) +'</strong></li>';
            }*!/

            infoHtml += '</ul></div>';
        }*/
        infoHtml += '<div class="p-info-item pt-2 pt-sm-0">';

        if(obj.Type == "ResidentialLease"){

        }
        else {
            infoHtml += '<div class="crypto-data position-absolute">';
            infoHtml += '<ul class="d-flex p-0 te-font-size-9 justify-content-between- py-1 py-xl-1">';

            infoHtml += '<li class="pr-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/bitcoin.png" alt="bitcoin"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price / bitcoin)) +'</strong></li>';

            infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/etherium.png" alt="etherium"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price / etherium)) +'</strong></li>';
            /*if(numberFormat(Math.round(obj.Price / cardano)) != 0){
                infoHtml += '<li class="px-1 text-center"><img class="d-block mx-auto mb-1" src="'+Site_Url+'API/upload/pictures/cardano.png" alt="cardano"> APPROX <strong class="d-block">'+ numberFormat(Math.round(obj.Price * cardano)) +'</strong></li>';
            }*/

            infoHtml += '</ul></div>';
        }

            infoHtml += '<div class="pb-2 pt-4 p-address"><span>'+obj.Address2+' - </span>' + '<span>'+obj.CityName+'</span>, ' + '<span>'+obj.State+'</span> ' + '<span>'+obj.ZipCode+'</span></div>';
            infoHtml +=  '<div class="pb-2">'+obj.Bed+' Beds <span>/</span> '+obj.BathsFull+' Baths <span>/</span> '+numberFormat(obj.Sqft)+' Sq Ft</div>';
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
        infoHtml+= '</div>';

        infoHtml +=     '</div>' +
           '</a>';
    });
    infoHtml += '</div>';
    infoHtml += '<div class="p-action"><div class="action-arrow d-flex">';
    infoHtml += '<span class="arrow-prev angle-right icon-2x bg-white text-black border border-dark mr-3"><i class="fas fa-angle-left"></i></span><span class="arrow-next angle-right icon-2x bg-white text-black border border-dark mr-4"><i class="fas fa-angle-right"></i></span>';
    infoHtml += '<span id="p_next" class="text-dark te-font-family"> NEXT: </span>';
    infoHtml += '</div>';
    infoHtml += '<a href="'+view_page_url+'" class="btn lpt-btn lpt-btn-txt te-font-family style-8-btn action-btn"> View All</a>';
    infoHtml += '</div>';

    return infoHtml;
}
/*
 '<div class="property-info">' +
            '<div class="pb-2">'+obj.Address+'</div>' +
            '<div class="pb-2">'+obj.subdiv+'</div>' +
            '<div class="pb-2">'+obj.Bed+' Beds <span>|</span> '+obj.BathsFull+' Baths <span>|</span> '+numberFormat(obj.Sqft)+' Sq Ft</div>';
        if(obj.status == 'Closed')
        {
            infoHtml += '<div class="te-property-details-price pb-3">'+ currency + numberFormat(obj.SoldPrice)+'</div>';
        }
        else{
            infoHtml += '<div class="te-property-details-price pb-3">'+ currency + numberFormat(obj.Price)+'</div>';
        }
        infoHtml += '<a href="'+ Site_Url+obj.SFUrl+'" class="btn btn-style1 text-white text-uppercase">Details</a>';
        infoHtml += '</div>'
 */