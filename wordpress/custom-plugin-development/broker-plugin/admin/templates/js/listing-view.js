jQuery(document).ready(function(){

    show_hide('city_sh','city_td li.city_sh');
    show_hide('zip_sh','zip_td li.zip_sh');
    show_hide('bed_sh','bed_td li.bed_sh');
    show_hide('community_sh','community_td li.community_sh');

    bindLGPopup();

    if (jQuery('#carousel').length){
        jQuery('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 100,
            itemMargin: 5,
            asNavFor: '#slider'
        });
        jQuery('#slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel"
        });
    }
});
function show_hide(click_sh,sl_hasc){

    jQuery('#'+click_sh).on('click',function(){
        if(jQuery('#'+sl_hasc).hasClass('d-none')) {
            jQuery('#'+sl_hasc+'.d-none').addClass('s-less');
            jQuery('#'+sl_hasc).removeClass('d-none');
            jQuery(this).html('See Less');
        }
        else if(jQuery('#'+sl_hasc).hasClass('s-less')) {
            jQuery('#'+sl_hasc+'.s-less').addClass('d-none');
            jQuery(this).html('See More');
        }
    });
}
function bindLGPopup()
{
    jQuery('.popup-modal-lg').unbind('click');
    jQuery('.popup-modal-lg').on('click', function(){

        var url  =   jQuery(this).attr('data-url');
        var type =   jQuery(this).attr('data-target');

        jQuery('#modal-lg-popup .modal-content').html('<p class="text-center"><br>Loading ...</p>');

        jQuery('#modal-lg-popup').modal('show');
        jQuery("#modal-lg-popup").removeClass("fade");


        jQuery('#modal-lg-popup .modal-content').load(url, function(e){

        });
    });

}
/*
function loadGoogleMap(mapHolder, lat, long, title, iconPath)
{
    var myLatLng = new google.maps.LatLng(lat, long);

    var myOptions = {
        zoom: 12,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel:false
    };

    map = new google.maps.Map(document.getElementById(mapHolder), myOptions);

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: iconPath,
        title:title
    });
}*/
