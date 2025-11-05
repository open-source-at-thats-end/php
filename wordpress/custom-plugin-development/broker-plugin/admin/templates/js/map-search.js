var mapZoomLevel;
var map;
var objMapZmEvnt = "";

jQuery(document).ready(function(){

//console.log('lkladklkdl');
/*jQuery('#')*/
/*
BindMap();*/
   jQuery('.bindMap').unbind('click');
    jQuery('.bindMap').on('click', function(e){
        e.preventDefault();
        if(jQuery('#pms-map').length > 0)
        {
           BindMap();
           setMapHeight();
           removePolygon();
        }

    });

    jQuery('#btn_draw').on('click', function(){
        jQuery("#btn_draw").addClass('d-none').removeClass('d-block');
        jQuery("#btn_cancel").addClass('d-block').removeClass('d-none');
        drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
        drawingManager.setMap(map);

    });

    jQuery('#btn_cancel').on('click', function() {
        drawingManager.setDrawingMode(null);
        EventObj.setMap(null);
        map.setZoom(13);

        jQuery('.map-control-btn').fadeOut(1000);
        jQuery("#btn_draw").removeClass('d-none').addClass('d-block');
        jQuery("#btn_remove").addClass('d-none').removeClass('d-block');
    });



});


function BindMap()
{
    if(jQuery(window).width() > 900){
        var MapControlsPosition = google.maps.ControlPosition.RIGHT_TOP;
        var MapZoomControlsPosition = google.maps.ControlPosition.LEFT_BOTTOM;
    }else{
        var MapControlsPosition = google.maps.ControlPosition.LEFT_TOP;
        var MapZoomControlsPosition = google.maps.ControlPosition.LEFT_BOTTOM;
    }


    var myOptions = {
        zoom: mapZoomLevel,
        center: new google.maps.LatLng(mapCenterLat,mapCenterLng),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
        disableDefaultUI: true,
        scrollwheel:false,
        panControl: false,
        zoomControl: true,
        fullscreenControl:  true,
        fullscreenControlOptions: {
            position: MapControlsPosition
            //position:  google.maps.ControlPosition.RIGHT_TOP;
        },

        zoomControlOptions: {
         style: google.maps.ZoomControlStyle.SMALL,
         position: MapZoomControlsPosition,
        //position: google.maps.ControlPosition.LEFT_BOTTOM
         },
        //styles: mapStyles
    };

    map = new google.maps.Map(document.getElementById('pms-map'), myOptions);
    drawingManager = new google.maps.drawing.DrawingManager({
        //drawing tool visible and hide
        drawingControl: false,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [
                google.maps.drawing.OverlayType.POLYGON,
                google.maps.drawing.OverlayType.CIRCLE,
            ]
        },
        polygonOptions: {
            editable: false,
        },
        circleOptions: {
            editable: false,
        },
    });
    google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {

        //polygon has path, we can call getPath()
        //to return the MVCarray LatLngs.
        var encodeString = google.maps.geometry.encoding.encodePath(polygon.getPath());
        var string = polygon.getPath();

        // polygon array Coordinates
        var contentString = '';
        for (var i=0; i< string.getLength(); i++)
        {
            var xy = string.getAt(i);
            contentString +=  xy.lat() + ' ' + xy.lng() + '~';
        }

        EventObj = polygon;

        // Switch back to non-drawing mode after drawing a shape.
        drawingManager.setDrawingMode(null);

        // drawing tool visible and hide
        drawingManager.setOptions ({
            drawingControl: false
        });

        showButton();
        Do_PolygonSearch(contentString);
    });

    var overlay = new google.maps.OverlayView();
    overlay.draw = function() {};
    overlay.setMap(map);
    var polygonString = jQuery("input[name='poly']").val();

    if(polygonString != '') {

        getPropertyCount(jQuery("input[name='poly']"))
        //last value remove
        var polygonString = polygonString.slice(0, -1);

        var polygonArray = polygonString.split('~');

        // array value base LatLng coordinate generated
        var coordinate = [];
        for (var i = 0; i < polygonArray.length; i++) {
            var point = polygonArray[i].split(" ");
            var LatLng = new google.maps.LatLng(point[0], point[1]);

            coordinate.push(LatLng);
        }
        // polygon draw
        EventObj = new google.maps.Polygon({
            paths: coordinate,
            editable: false,
            draggable: false,
        });
        drawingManager.setOptions({
            drawingControl: false
        });
        EventObj.setMap(map);
        showButton();
    }
    else{
        jQuery("#btn_remove").addClass('d-none');
        jQuery("#btn_draw").addClass('d-block').removeClass('d-none');
    }
    mapZoom();
}

function mapZoom(){

    objMapZmEvnt = google.maps.event.addListener(map, 'zoom_changed', function(){

        /* map zoom level get*/
        mapZoomLevel = map.getZoom();
        /* map center lat lng value get*/
        var mapCenter = map.getCenter();

        jQuery('#MapZoomLevel').val(mapZoomLevel);
        jQuery('#MapCenterLat').val(mapCenter.lat());
        jQuery('#MapCenterLng').val(mapCenter.lng());

        var bounds = map.getBounds();

        var sw = bounds.getSouthWest();
        var ne = bounds.getNorthEast();

        //jQuery('#map').val(sw.lat()+','+ sw.lng()+','+ ne.lat()+','+ ne.lng());
        isMapSearch =true;
    });
}


function showButton()
{
    jQuery("#btn_remove").addClass('d-block');
    jQuery("#btn_cancel").addClass('d-none').removeClass('d-block');
    jQuery("#btn_draw").addClass('d-none').removeClass('d-block');
}

function Do_PolygonSearch(contentString, encodeString)
{
    jQuery("input[name='poly']").val(contentString);
    getPropertyCount(jQuery("input[name='poly']"))
    /* Bounds logic start */
    var bounds = new google.maps.LatLngBounds();

    var polygonString = contentString.slice(0, -1);

    var polygonArray = polygonString.split('~');

    // array value base LatLng coordinate generated
    var coordinate = [];
    for (var i = 0; i < polygonArray.length; i++) {
        var point = polygonArray[i].split(" ");
        var LatLng = new google.maps.LatLng(point[0], point[1]);

        coordinate.push(LatLng);
    }

    for(var j=0; j<coordinate.length; j++)
    {
        bounds.extend(coordinate[j]);
    }

    map.fitBounds(bounds);
    mapZoom();
}

function removePolygon()
{
    jQuery('#btn_remove').click(function(){
        EventObj.setMap(null);
        drawingManager.setDrawingMode(null);
        jQuery('#btn_remove').fadeOut(1000);
        jQuery('.map-control-btn').fadeIn(1000);

        jQuery("input[name='poly']").val('');
        map.setZoom(13);

        //jQuery("input[name='map']").val('');

        drawingManager.setOptions ({
            drawingControl: false
        });

        var bounds = map.getBounds();

        var sw = bounds.getSouthWest();
        var ne = bounds.getNorthEast();
        drawingManager.setDrawingMode(null);

        jQuery("#btn_remove").addClass('d-none');
        jQuery("#btn_remove").removeClass('d-block');
        jQuery("#btn_draw").removeClass('d-none').addClass('d-block');

        getPropertyCount(jQuery("input[name='poly']"))

    });
}

function setMapHeight(){

    var wHeight 		= jQuery(window).height();
    var headHeight      = jQuery('#myTab').height();
    var headHeight2      = jQuery('#strong-testimonials-strong-testimonials-review-notice').height();
    var headHeight3      = jQuery('#wpadminbar').height();

    jQuery('#pms-map').css('height', (wHeight-headHeight -headHeight2 - headHeight3 -200 ) + 'px');
}