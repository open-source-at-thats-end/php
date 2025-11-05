jQuery(document).ready(function(){

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
