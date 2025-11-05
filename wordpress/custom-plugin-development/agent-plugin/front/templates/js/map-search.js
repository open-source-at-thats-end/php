var map;
var markers = [];
var arrMapData = [];
var objmarkers = [];
var objMapZmEvnt = '';
var objIB_Small;
var drawingManager;
var isMapSearch = false;
var isBackSearch = false;
var mapZoomLevel;
var isMap;
var isGrid;
jQuery(document).ready(function(){

    if(typeof isGrid !== 'undefined' && isGrid !== 'true'){
        jQuery('body').css('overflow', 'hidden');
    }
    //jQuery('#toggle-trigger-grid').prop('checked','checked');

    jQuery(document).on('click', function() {
        if(objIB_Small)
        {
            objIB_Small.hide();
        }
    });

    jQuery('#btn_draw').on('click', function(){

        drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
        drawingManager.setMap(map);

    });
    jQuery('#btn_cir').click(function(){
        drawingManager.setDrawingMode(google.maps.drawing.OverlayType.CIRCLE);
        drawingManager.setMap(map);
    });


    if(window.history)
    {
        jQuery(window).on('popstate', function () {
            isBackSearch = true;

            getPage();
        });

    }
/*    if(jQuery('#toggle-trigger-grid').prop('checked') == true){
        console.log('hello');
        jQuery('#toggle-trigger-grid').attr('checked','checked');
    }*/

    if(jQuery('#pms-map').length > 0)
    {
        BindMap();
        setMapHeight();
        removePolygon();
        jQuery('footer').hide();
    }else{
        var json = jQuery('.json');

        if(json.length > 0)
        {
            jQuery.each(json, function (index, obj) {
                var pid = jQuery(obj).attr('data-pid');
                BindPropertiesInGrid(jQuery(obj).val(), pid);
            });
        }
        else
        {
            BindPropertiesInGrid(jsonMapData);
        }
    }

    /* Check persisted property of the onpageshow instead onload */
    jQuery(window).bind("pageshow", function(event) {
        if (event.originalEvent.persisted) {
            if(login_enable == 'Yes') {
                if (isloginReq == 'Yes' ) {
                    var user_view_count = getCookie('user_view_details_count');
                    if (user_view_count >= maxViewedExceedCount) {
                        isBackSearch = true;
                        getPage();
                    }
                }
            }else {
                window.stop();
            }

            // window.location.reload();
        }
    });

    bindSort();
    additionalBinding();
    stopPropagationMenu();
    /*    setMapHeight();
        setListingHeight()*/
});
function BindPropertiesInGrid(strData, pid = '')
{
    if(typeof strData != "undefined" && typeof strData != undefined  && strData != '') {
        var data = eval(JXG.decompress(strData));
        arrMapData = [];
        for (var obj in data) {
            arrMapData.push(data[obj]);
        }
    }
    getMapResultData(jQuery('#cur-page').val(), pid);
}
function additionalBinding()
{
    if(jQuery('.xl-beds').is(":visible") == true)
    {
        jQuery('.lg-device-bedbath').html('');
    }
    else{
        jQuery('.xl-beds').html('');
    }
    //console.log(jQuery('#toggle-trigger-grid').prop());
    jQuery('.te-map-switch-grid').unbind('change');
    jQuery('.te-map-switch-grid').on('change', function(){
        //jQuery('#pms-area-map').addClass('d-none');
       /* jQuery('#pms-area-map').removeClass('d-xl-block');
        jQuery('#pms-area-listing').removeClass('col-xl-6');
        jQuery('.pms-listing-result .listings-box').removeClass('col-xl-6');
        jQuery('#pms-area-listing').addClass('col-xl-12');
        jQuery('.pms-listing-result .listings-box').addClass('col-xl-4');*/

        if( jQuery('#is_map').val() == 'true'){
            jQuery('#is_map').val('false');
            }
            else {
                jQuery('#is_map').val('true');
            }

        if(jQuery('#toggle-trigger-grid').prop('checked') == true){
                jQuery('#pms-area-map').removeClass('d-none');
                jQuery('#pms-area-map').addClass('d-xl-block');
                jQuery('#pms-area-listing').removeClass('col-xl-12');
                jQuery('#pms-area-listing').addClass('col-xl-6');
                jQuery('.pms-listing-result .listings-box').addClass('col-xl-6');

                /*if (jQuery(window).width() > 1360)
                    jQuery('.pms-listing-result .listings-box').removeClass('col-xl-3');
                else*/
                    jQuery('.pms-listing-result .listings-box').removeClass('col-xl-4');

         }
        else
        {
            jQuery('#pms-area-map').removeClass('d-xl-block');
            jQuery('#pms-area-listing').removeClass('col-xl-6');
            jQuery('#pms-area-listing').addClass('col-xl-12');
            jQuery('.pms-listing-result .listings-box').removeClass('col-xl-6');
            jQuery('#pms-area-map').addClass('d-none');

            /*if (jQuery(window).width() > 1280)
                jQuery('.pms-listing-result .listings-box').addClass('col-xl-3');
            else*/
                jQuery('.pms-listing-result .listings-box').addClass('col-xl-4');

            // jQuery('#toggle-trigger-grid').prop('checked');
        }

    });
    jQuery('.te-map-switch').on('click', function(){

       /* if(jQuery('#toggle-trigger').prop('checked') == true)
        {

            jQuery('#te-map-modal').modal('show');
            jQuery('#te-map-modal').removeClass('map-hidden');
            jQuery('.modal-backdrop').css('opacity', '0');


            jQuery('#main-header').css({'z-index' : '99', 'opacity' : '0'});
            jQuery('.et_builder_inner_content').css({"position": "unset", "z-index": "unset"});
            jQuery('.et_pb_fullwidth_code.et_pb_module').css({"position": "unset", "z-index": "unset"});

            BindMap();
        }else{
            jQuery('#te-map-modal').addClass('map-hidden');
            jQuery('#te-map-modal').modal('hide');
        }*/

        if(jQuery('#toggle-trigger').prop('checked') == true)
        {

            setTimeout(function () {
                jQuery('#te-map-modal').modal();
            }, 100);


            //jQuery('#te-map-modal').css({'display':'block', 'opacity':'unset'});
            jQuery('#te-map-modal').removeClass('map-hidden');
            jQuery('.modal-backdrop').remove();

            //jQuery('.modal-backdrop').css('opacity', '0');
            jQuery('#main-header').css({'z-index' : 'unset'});

            BindMap();
        }else{

            jQuery('#te-map-modal').addClass('map-hidden');
            jQuery('#te-map-modal').modal('hide');
        }
    });

    jQuery('#te-map-modal').on('hidden.bs.modal', function (event) {

        jQuery('#main-header').css({'z-index' : '99999'});
        //jQuery('#main-header').css({'z-index' : '9999999', 'opacity' : 'unset'});

    });

    jQuery('#closeMap').click(function(){
        jQuery('#toggle-trigger').prop('checked', false);
    });
    if(jQuery('#pms-map').length > 0)
    {

        jQuery('#pms-area-listing div.listings-box').unbind('mouseenter');
        jQuery('#pms-area-listing div.listings-box').bind('mouseenter', function(e){

            var tmp = jQuery(this).attr('id');
            if(typeof(objmarkers[tmp]) === 'object')
            {
                //jQuery(objmarkers[tmp].div_).addClass('hover');
                google.maps.event.trigger(objmarkers[tmp], 'click','extCall');

            }

        });

        jQuery('#pms-area-listing div.listings-box').on('mouseleave', function(){
            var tmp = jQuery(this).attr('id');
            if(typeof(objmarkers[tmp]) == 'object')
            {
                jQuery(objmarkers[tmp].div_).removeClass('d-none');
                if(objIB_Small)
                    objIB_Small.hide();

            }
        });

    }

}
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
        /*mapTypeControlOptions: {
         style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
         position: google.maps.ControlPosition.RIGHT_BOTTOM
         },*/
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
    google.maps.event.addListener(drawingManager, 'circlecomplete', function (circle) {

        var radius          = circle.getRadius();
        var cenLatLng       = circle.getCenter();

        var cirParam = [];
        cirParam['radius'] = radius;
        cirParam['cenLat'] = cenLatLng.lat();
        cirParam['cenLng'] = cenLatLng.lng();

        EventObj= circle;
        drawingManager.setDrawingMode(null);

        // drawing tool visible and hide
        drawingManager.setOptions ({
            drawingControl: false
        });

        showButton();
        Do_CircleSearch(cirParam);
    });
    var overlay = new google.maps.OverlayView();
    overlay.draw = function() {};
    overlay.setMap(map);
    var polygonString = jQuery("input[name='poly']").val();
    var circleString  = jQuery("input[name='cir']").val();

    if(polygonString != '') {
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
    if(circleString != '')
    {
        var circleArray = circleString.split('~');

        var radius = circleArray[0] * 1;
        var center = new google.maps.LatLng(circleArray[1], circleArray[2]);

        // circle draw
        EventObj = new google.maps.Circle ({
            map: map,
            center: center,
            radius: radius,
        });

        drawingManager.setOptions ({
            drawingControl: false
        });

        EventObj.setMap(map);
        showButton();
    }
    setMapHeight();
    setListingHeight();
    setMarker();
    mapZoom();
    mapdrag();
}
function Do_PolygonSearch(contentString, encodeString)
{
    jQuery("input[name='poly']").val(contentString);
    jQuery("input[name='cir']").val('');
    isMapSearch = 0;

    // Get Listing available in Map Boundary
    if(jQuery(window).width() < 900)
    {
        SubmitSearchForm('#mbfrmsearch');
    }else{
        SubmitSearchForm('#frmlistingsearch');
    }

}
function Do_CircleSearch(cirParam)
{
    var circle_param = cirParam['radius']+'~'+cirParam['cenLat']+'~'+cirParam['cenLng'];

    jQuery("input[name='cir']").val(circle_param);
    jQuery("input[name='poly']").val('');
    isMapSearch = 0;
    // Get Listing available in Map Boundary
    if(jQuery(window).width() < 900)
    {
        SubmitSearchForm('#mbfrmsearch');
    }else{
        SubmitSearchForm('#frmlistingsearch');
    }
}
function removePolygon()
{
    jQuery('#btn_remove').click(function(){
        /*if(polyObj)
         polyObj.setMap(null);*/

        EventObj.setMap(null);
        drawingManager.setDrawingMode(null);
        jQuery('#btn_remove').fadeOut(1000);
        jQuery('.map-control-btn').fadeIn(1000);

        /*isPolygonSearch = 0;
        isCircleSearch  = 0;*/

        isMapSearch = 0 ;
        jQuery("input[name='poly']").val('');
        jQuery("input[name='cir']").val('');
        jQuery("input[name='map']").val('');

        drawingManager.setOptions ({
            drawingControl: false
        });

        /*if(polyObj)
            polyObj.setMap(null);*/
        var bounds = map.getBounds();

        var sw = bounds.getSouthWest();
        var ne = bounds.getNorthEast();
        drawingManager.setDrawingMode(null);

        jQuery("#btn_remove").addClass('d-none');
        jQuery("#btn_remove").removeClass('d-block');
        jQuery("#btn_draw").addClass('d-block');
        jQuery("#btn_cir").addClass('d-block');

        jQuery("#btn_draw").removeClass('d-none');
        jQuery("#btn_cir").removeClass('d-none');
        /* if(jQuery(window).width() < 900)
         {
             SubmitSearchForm('#mbfrmsearch');
         }else{
             SubmitSearchForm('#frmlistingsearch');
         }*/
        Do_MapSearch(sw.lat(), sw.lng(), ne.lat(), ne.lng());

    });
}

function showButton()
{
    jQuery("#btn_remove").addClass('d-block');

    jQuery("#btn_draw").addClass('d-none');
    jQuery("#btn_cir").addClass('d-none');

    jQuery("#btn_draw").removeClass('d-block');
    jQuery("#btn_cir").removeClass('d-block');
}
function setMapHeight(){

    var wHeight 		= jQuery(window).height();
    var headHeight      = jQuery('header').height();
    var F_Height = '';
    setTimeout(function(){
        jQuery('#m-loader').css('left', ((jQuery('#pms-area-map').width() - jQuery('#m-loader').width() )/2));
    }, 700);
    if(jQuery(window).width() > 1200){
        if(jQuery('#frmlistingsearch').length > 0)
        {
            F_Height        =   jQuery('#frmlistingsearch').outerHeight();
        }
        jQuery('#pms-map').css('height', (wHeight - headHeight - F_Height) + 'px');
        /*if(jQuery('#pms-map').length > 0 && jQuery('.pre-search').length > 0)
        {
            jQuery('#pms-map').css('height', (wHeight - headHeight - F_Height) + 'px');
        }
        else
        {
            jQuery('#pms-map').css('height', (wHeight - headHeight - F_Height) + 'px');
        }*/

    }else{
        jQuery('#pms-map').css('height', (wHeight) + 'px');

    }



}
function setListingHeight() {
    var wHeight 		= jQuery(window).height();

    var width           = jQuery(window).width();
    var headHeight      = jQuery('header').height();


    var F_Height = '';

    if(jQuery('#frmlistingsearch').length > 0)
    {
        F_Height        =   jQuery('#frmlistingsearch').outerHeight();
    }

    if(jQuery('#pms-area-listing').length > 0)
    {
        //jQuery('#pms-area-listing').css('height', (wHeight - headHeight - F_Height) + 'px');
        //jQuery(_t._o.div_s_height).css('max-height', (wHeight - headHeight + jQuery('.map-footer').height()) + 'px');
        jQuery('#pms-area-listing').css('height', (wHeight - headHeight - F_Height) + 'px');
       /* if(jQuery('#pms-map').length > 0 && jQuery('.pre-search').length > 0)
        {
            jQuery('#pms-area-listing').css('height', (wHeight - headHeight - F_Height) + 'px');
        }
        else
        {
            jQuery('#pms-area-listing').css('height', (wHeight - headHeight - F_Height) + 'px');
        }*/
        //jQuery(_t._o.div_s_height).css('max-height', (wHeight - headHeight + jQuery('.map-footer').height()) + 'px');
    }
    // jQuery(_t._o.map.s_loader).css("left", ((jQuery().width(_t._o.div_s_map) )/2));

}
function setMarker(){
    if(jsonMapData != '')
    {
        ShowHide_Loader('show');
        if(mapCenterLat == '25.761681' && mapCenterLng == '-80.191788')
        {
            setTimeout(function () {
                ShowHide_Loader('hide');
                ploatMarkers(jsonMapData, '1');
            },3000)
        }
        else
        {
            setTimeout(function () {
                ShowHide_Loader('hide');
                ploatMarkers(jsonMapData);
            },3000)
        }
    }else{
        ShowHide_Loader('hide');
        getMapResultData(jQuery('#cur-page').val());
    }
    setMapInfoBox();
}
function ploatMarkers(strData, isNewSearch) {
    clearOverlays();

    if(typeof(map) == 'object')
    {

        if(strData != '')
        {
            var data = eval(JXG.decompress(strData));
            var arrPoints = [];
            arrMapData = [];

            for(var obj in data)
            {   arrMapData.push(data[obj]);

                if(data[obj].Lat > 0)
                {
                    var point = new google.maps.LatLng(data[obj].Lat, data[obj].Long);

                    arrPoints.push(point);

                    var marker = createMarker(point, data[obj]);
                    markers.push(marker);
                }
            }

            /* Bounds logic start */
            if(arrPoints.length > 0 && isNewSearch == '1' && (jQuery('#te-map-modal').length == 0 || (jQuery('#te-map-modal').length >= 1 && jQuery('#te-map-modal').is(":visible") == true)))
            {
                /* Unbind Zoom Change Event if binded before*/
                if(objMapZmEvnt)
                {
                    google.maps.event.removeListener(objMapZmEvnt);
                    //google.maps.event.clearListeners(map, 'zoom_changed');
                    objMapZmEvnt = '';
                }

                /* Bounds logic start */
                var bounds = new google.maps.LatLngBounds();

                for(var j=0; j<arrPoints.length; j++)
                {
                    bounds.extend(arrPoints[j]);
                }

                map.fitBounds(bounds);
                /*var mapZoomLevel = map.getZoom();
                jQuery('#MapZoomLevel').val(mapZoomLevel);*/
            }

            /* Bind Map Zoom Change Event*/
            mapZoom();

        }
        getMapResultData(jQuery('#cur-page').val());
        map.setOptions({draggable: true});
    }
    lzl();
}
function createMarker(location, obj) {
    var marker = objmarkers[obj.Key] = new OEMarker({
        position: location,
        map: map,
        content: '$'+ PriceFormat(obj.Price),
        boxClass: 'oeMarkerBlack',
    });

    /* Marker Mouseclick*/
    google.maps.event.addListener(marker, "click", function(e) {

        jQuery('.listings-box').removeClass('border-black');

        var detHtml = '';
        detHtml = getMapListingBoxHtml(obj);

        if(detHtml != '' && marker.div_ !== '' && marker.div_ !== null)
        {
            // Detailed Html [For Click]
            var width = jQuery(window).width();
            if(width < '768')
                objIB_Small = new OE_MapInfoBox({marker:marker, ib_holder:'map-infobox-small', posCenter:true});
            else
                objIB_Small = new OE_MapInfoBox({marker:marker, ib_holder:'map-infobox-small', ibOffset:[-(marker.div_.offsetWidth+64),10], mapOffset:[-80,50]});

            objIB_Small.setContent(detHtml);
            objIB_Small.show(map, this);

            marker_lzl();

        /*    lzl();*/
        }
        jQuery('#map-infobox-small').on('click', function() {
            if(objIB_Small)
                objIB_Small.hide();

        });

        if(e != 'extCall')
        {
            jQuery('#pms-area-listing').scrollTo('#'+obj.Key, {axis:"y"});
            jQuery('.listings-box#'+obj.Key+'').addClass('border-black');
        }
        bindSMPopup();

    });

    return marker;

}
function clearOverlays() {
    //console.log(markers.length);
    // Remove old Markers From Map, If any
    if (markers) {
        for (i in markers) {
            markers[i].setMap(null);
        }

        markers.length = 0;
    }
}
function setMapInfoBox(){
    OE_MapInfoBox = function (options) {

        this.overlayView = new google.maps.OverlayView();
        this.overlayView.draw = function () {};
        this.overlayView.setMap(map);
        this.overlayView = this.overlayView.getProjection();

        if(options.marker.position_)
        {
            this.pixPosition = this.overlayView.fromLatLngToContainerPixel(options.marker.position_);
            this.markerSize 	= {
                width: options.marker.div_.offsetWidth,
                height: options.marker.div_.offsetHeight
            };
        }
        else
        {
            this.pixPosition = this.overlayView.fromLatLngToPoint(options.marker.getPosition());

            this.markerSize 	= {
                width: options.marker.icon.size.width, //20
                height: options.marker.icon.size.height //20
            };
        }

        this.mapSize 	= {width : map.getDiv().offsetWidth, height : map.getDiv().offsetHeight};
        this.markerPos 	= [this.pixPosition.x, this.pixPosition.y];

        this.A = [];
        this.F = {};

        this.eleIB = jQuery('#' + options.ib_holder).css({top:'0px', left:'0px'});

        this.hide = function(){
            this.eleIB.hide();
        };

        this.ibOffset = options.ibOffset || [0,0];
        this.mapOffset = options.mapOffset || [50,50];

        this.setContent = function(html){
            this.eleIB.find('div.ibContent').html(html);
        };

        this.posCenter = options.posCenter || false;

        this.show = function(){

            this.ibSize = {
                width: this.eleIB.outerWidth(),
                height: this.eleIB.outerHeight()
            };

            if(this.posCenter)
            {
                jQuery('#'+options.ib_holder).css("left", ( jQuery('#pms-map').width() - jQuery('#'+options.ib_holder).width() ) / 2+jQuery('#pms-map').scrollLeft() + "px");
                jQuery('#'+options.ib_holder).css("top", (jQuery('#pms-map').height() - (jQuery('#'+options.ib_holder).outerHeight(true) * 2)) - 350 + "px");
                // jQuery('#'+options.ib_holder).css("top", ( jQuery("#"+_t._o.map.div_s).height() - jQuery('#'+options.ib_holder).height() ) +jQuery("#"+_t._o.map.div_s).scrollTop() - 20 + "px");
            }
            else
            {
                // PERFECT SET
                if (this.markerPos[0] + this.ibOffset[0] + this.ibSize.width + this.mapOffset[0] < this.mapSize.width) {

                    this.F.left = String(this.markerPos[0] + this.ibOffset[0]) + "px";
                    this.A[0] = "l";
                } else {

                    this.F.left = String(this.markerPos[0] - this.ibOffset[0] - this.ibSize.width + this.markerSize.width /*- this.mapOffset[0]*/) + "px";
                    this.A[0] = "r";
                }

                if (this.markerPos[1] - (this.ibOffset[1] + this.mapOffset[1] + this.ibSize.height + this.markerSize.height) < 0) {
                    this.F.top = String(this.markerPos[1] + this.ibOffset[1]) + "px";
                    this.A[1] = "b";

                } else {


                    this.F.top = String(this.markerPos[1] - (this.ibOffset[1] + this.ibSize.height + this.markerSize.height)) + "px";
                    this.A[1] = "t";
                }
                this.eleIB.find('div.ibArrow').attr('class','').addClass('ibArrow ibArrow-' + (this.A[1] + this.A[0]));
            }
            this.eleIB.css(this.F);
            this.eleIB.show();
        };
    };
}
function getMapListingBoxHtml(obj) {

    //var FavList = userFavList.split(',');
    /*var infoHtml = '<div class="row te-featured-properties h-auto mw-100 m-0 te-infobox">';
    //infoHtml += getMainBoxHtml(obj, FavList);
    infoHtml += getMainBoxHtml(obj);
    infoHtml += '</div>';*/

    if(isstyle == '')
    {
        var infoHtml = '<div class="row te-featured-properties h-auto mw-100 m-0 te-infobox">';
        infoHtml += getMainBoxHtmlInfo(obj);
        //infoHtml += getMainBoxHtml(obj);
        infoHtml += '</div>';
    }
    else
    {
        var infoHtml = '<div class="row te-featured-properties h-auto mw-100 m-0 te-infobox">';
        infoHtml += getMainBoxHtml(obj);
        infoHtml += '</div>';
    }

    return infoHtml;
}
function bindSort() {
    if(jQuery('.fsort').length > 0){
        jQuery('.fsort').on('click', function(){
            var value = jQuery(this).attr('data-value').split('|');
            var so = value[0];
            var sd = value[1];

            if(jQuery('#so').length > 0)
            {
                jQuery('#so').val(so);
                jQuery('#sd').val(sd);
                if(jQuery(window).width() < 900)
                {
                    var form = '#mbfrmsearch';
                }else{
                    var form = '#frmlistingsearch';
                }
                getPage('1', form);
            }

        });
    }

    if(jQuery('.preqsort').length > 0){
        jQuery('.preqsort').on('click', function() {
            var value = jQuery(this).attr('data-value').split('|');
            var so = value[0];
            var sd = value[1];

            if(jQuery('#so').length > 0)
            {
                jQuery('#so').val(so);
                jQuery('#sd').val(sd);
                if(jQuery(window).width() < 900)
                {
                    var form = '#mbfrmsearch';
                }else{
                    var form = '#frmlistingsearch';
                }
                getPage('1', form);
            }

        });
    }
}
function getMapResultData(P_No, PId = '') {
    var data = arrMapData;

    var listing_html = getListingHtml(data,P_No,PId);

    if (PId != '')
    {
        jQuery(".pms-listing-result-"+PId).html(listing_html);
    }
    else if(jQuery('.pms-listing-result').length > 0)
    {
        jQuery('.pms-listing-result').html(listing_html);
    }

    if(total_record > 0) {
        var page_string = _pager(Math.ceil(total_record/page_size),P_No);

        jQuery('#pms-area-pager').html(page_string);
    }
    //jQuery('#disclaimer-section').removeClass('d-none');

    lzl();
    bindSMPopup();
    bindPaginationsLinks();
    additionalBinding();


}
function getListingHtml(data,P_No,pid='') {

    var dataHtml = [];
    var infoHtml = '';

    if(total_record > 0 ) {

        infoHtml += getListingBoxHtml(data,pid);
    }
    else{

        if(typeof isPredefined != "undefined" && (isPredefined == 'true' || isPredefined == true)){
            infoHtml += '<div class="col-12 no-data-msg text-center- text-danger n-result d-flex pt-3- mt-3 px-0">';
            //infoHtml += '0 Results';
            infoHtml += '<div class="no-result py-2 px-2">No listings were found matching your search criteria. Contact us for off-market listings that may be available or coming soon.</div>';
            infoHtml += '</div>';
        }else{
            infoHtml += '<div class="col-12 no-data-msg text-center text-danger pt-3">';
            infoHtml += 'Please modify your search criteria and try again.';
            infoHtml += '</div>';
        }

    }

    dataHtml.push(infoHtml);

    return dataHtml.join('');
}
function ShowHide_Loader(str)
{
    if(str == 'show')
    {
        setTimeout(function(){
            if(jQuery('#pms-area-map').is(":visible"))
            {
                jQuery('#m-loader').show();
            }

            var containerHeight = jQuery('#pms-area-listing').height();

            if(containerHeight == 0){
                var containerHeight = jQuery('#pms-area-map').height();
            }
            jQuery('#pms-area-listing').prepend('<div class="l-loader"><div style="height:'+(containerHeight + 30)+'px"></div><label style="height:'+(containerHeight + 30)+'px">&nbsp;</label></div>');

        },500);


    }
    else
    {
        setTimeout(function(){jQuery('#m-loader').hide();},1000);
        setTimeout(function(){jQuery('.l-loader').remove();},1000);
    }
}
/*function _pager(total_page, cur_page){

    var total_limit = 5;
    var before_page_limit = 3;
    var after_page_limit = 1;

    var initial_page   = parseInt(cur_page) - parseInt(before_page_limit);
    var end_page       = parseInt(cur_page) + parseInt(after_page_limit);

    var page_string = "";

    var url      = window.location.href;

    if(initial_page > 0)
    {
        initial_page = (cur_page === total_page && total_page > 5)?parseInt(initial_page)-1:initial_page;

        for(i = initial_page; i<cur_page; i++)
        {
            if(url.indexOf('?') < 0){
                var mainURL = url.replace(url.substring( url.indexOf('spage')+0), '?spage='+i+'');
            }else{
                var mainURL = url.replace(url.substring( url.indexOf('spage')+0), 'spage='+i+'');
            }
            page_string += '<li class="page-item"><a href="'+mainURL+'" class="page-link text-dark border-0 px-3" data-page="'+i+'">' + i + '</a></li>';
        }
    }
    else if(cur_page > 1 && cur_page <= before_page_limit)
    {
        var from = parseInt(before_page_limit) - parseInt(cur_page);
        from = (from == 0)?1:from;

        for(i = from; i<cur_page; i++)
        {
            if(url.indexOf('?') < 0){
                var mainURL = url.replace(url.substring( url.indexOf('spage')+0), '?spage='+i+'');
            }else{
                var mainURL = url.replace(url.substring( url.indexOf('spage')+0), 'spage='+i+'');
            }
            page_string += '<li class="page-item"><a href="'+ mainURL +'" class="page-link text-dark border-0 px-3" data-page="'+i+'">' + i + '</a></li>';
        }
    }
    /!* Current page*!/
    page_string += '<li class="active page-item"><a class="page-link text-dark shadow-none">'+cur_page+'</a></li>';

    if(cur_page >= total_limit && (end_page < total_page || end_page == total_page))
    {
        if(url.indexOf('?') < 0){
            var mainURL = url.replace(url.substring( url.indexOf('spage')+0), '?spage='+end_page+'');
        }else{
            var mainURL = url.replace(url.substring( url.indexOf('spage')+0), 'spage='+end_page+'');
        }
        page_string += '<li class="page-item"><a href="'+mainURL+'" class="page-link text-dark border-0 px-3" data-page="'+end_page+'">' + end_page + '</a> </li>';
    }
    else if(cur_page < total_limit)
    {
        var a = parseInt(total_limit) - parseInt(cur_page);
        var from = parseInt(cur_page) + 1;
        var to =  parseInt(cur_page) + a;

        to = (to <= total_page)?to:total_page;
        for(i=from; i<= to; i++)
        {
            if(url.indexOf('?') < 0){
                var mainURL = url.replace(url.substring( url.indexOf('spage')+0), '?spage='+i+'');
            }else{
                var mainURL = url.replace(url.substring( url.indexOf('spage')+0), 'spage='+i+'');
            }

            page_string += '<li class="page-item" ><a href="'+ mainURL +'" class="page-link text-dark border-0 px-3" data-page="'+i+'">' + i + '</a></li>';
        }
    }
    var pager_string = '';
    if( cur_page > 1 )
    {
        if(url.indexOf('?') < 0){
            var mainURL = url.replace(url.substring( url.indexOf('spage')+0), '?spage='+(parseInt(cur_page) - 1)+'');
        }else{
            var mainURL = url.replace(url.substring( url.indexOf('spage')+0), 'spage='+(parseInt(cur_page) - 1)+'');
        }
        pager_string += '<li class="page-item"><a href="'+mainURL+'" class="page-link border-0" aria-label="Previous" data-page="'+ (parseInt(cur_page) - 1) +'"><span aria-hidden="true">«</span></a></li>'+ page_string;
    }
    else
    {
        pager_string += '<li class="disabled page-item"><a class="page-link border-0" aria-label="Previous" href="JavaScript: void(0);"><span aria-hidden="true">«</span></a></li>'+ page_string;
    }
    if( parseInt(cur_page) < parseInt(total_page) )
    {
        if(url.indexOf('?') < 0){
            var mainURL = url.replace(url.substring( url.indexOf('spage')+0), '?spage='+(parseInt(cur_page) + 1)+'');
        }else{
            var mainURL = url.replace(url.substring( url.indexOf('spage')+0), 'spage='+(parseInt(cur_page) + 1)+'');
        }
        pager_string += '<li class="page-item"><a href="'+mainURL+'" class="page-link border-0" aria-label="Next" data-page="'+ (parseInt(cur_page) + 1)+'"><span aria-hidden="true">»</span></a></li>';
    }
    else
    {
        pager_string += '<li class="disabled page-item"><a class="page-link border-0" aria-label="Next" href="JavaScript: void(0);"><span aria-hidden="true">»</span></a></li>';
    }
    return pager_string;

}*/
function _pager(total_page, cur_page){

    var total_limit = 5;
    var before_page_limit = 3;
    var after_page_limit = 1;

    var pre   = parseInt(cur_page) - parseInt(1);
    var next       = parseInt(cur_page) + parseInt(1);
    var base_url = '';
    var page_string = "";
    if(total_page > 5)
    {
        var min_range = 3;
        if(cur_page <= min_range)
        {
           var j = min_range;
            if(cur_page == min_range)
            {
                j = j+1;
            }
            for(i=1; i<=j; i++)
            {
                if(i == cur_page)
                {
                    page_string += '<li class="page-item active"><span class="page-link text-dark border-0 px-3 rounded-0">' + i + '</span></li>';
                }
                else{
                    page_string +='<li class="page-item"><a class="page-link text-dark border-0 px-3 rounded-0" href="' + base_url+ "page="+ i + '" data-page="'+i+'">' + i + '</a></li>';
                }

            }
            page_string += '<li class="page-item disabled"><span>..</span></li>';
            page_string += '<li class="page-item"><a class="page-link text-dark border-0 px-3 rounded-0" href="' + base_url+ 'page='+ total_page + '" data-page="'+total_page+'">' + total_page + '</a></li>';
        }
        else if(cur_page == total_page || cur_page >= (total_page-min_range))
        {
            min_range--;

            page_string += '<li class="page-item"><a class="page-link text-dark border-0 px-3 rounded-0" href="'+base_url+'" page="1" data-page="1">1</a></li>';
            page_string += '<li class="page-item disabled"><span>..</span></li>';

            j=total_page-min_range;

            if(cur_page == (total_page-min_range))
            {
                j--;
            }
            for(i=j; i<=total_page; i++)
            {

                if(i == cur_page)
                {
                    page_string += '<li class="page-item active"><span class="page-link text-dark border-0 px-3 rounded-0">' + i + '</span></li>';
                }
                else{
                    page_string +=  '<li class="page-item"><a class="page-link text-dark border-0 px-3 rounded-0" href="' + base_url+ "page="+ i + '" data-page="'+i+'">' + i + '</a></li>';
                }
            }

        }
        else
        {
            page_string += '<li class="page-item"><a class="page-link text-dark border-0 px-3 rounded-0" href="'+ base_url+'"page="1" data-page="1">1</a></li>';
            page_string += '<li class="page-item disabled"><span>..</span></li>';

            for(i=pre; i<=next; i++)
            {

                if(i == cur_page)
                {
                    page_string += '<li class="page-item active"><span class="page-link text-dark border-0 px-3 rounded-0">' + i + '</span></li>';
                }
                else{
                    page_string +=  '<li class="page-item"><a class="page-link text-dark border-0 px-3 rounded-0" href="' + base_url+ " page="+ i + '" data-page="'+i+'">' + i + '</a></li>';

                }
            }
            page_string += '<li class="page-item disabled"><span>..</span></li>';
            page_string += '<li class="page-item"><a class="page-link text-dark border-0 px-3 rounded-0" href="' + base_url+ 'page='+ total_page + '" data-page="'+total_page+'">' + total_page + '</a></li>';
        }
    }
    else
    {
        for(i = 1; i < total_page + 1; i++)
        {

            if(i == cur_page)
            {
                page_string += '<li class="page-item active"><span class="page-link text-dark border-0 px-3 rounded-0">' + i + '</span></li>';
            }
            else{
                page_string +=  '<li class="page-item"><a class="page-link text-dark border-0 px-3 rounded-0" href="' + base_url+ "page="+ i + '" data-page="'+i+'">' + i + '</a></li>';

            }
        }
    }
   /* if(initial_page > 0)
    {
        initial_page = (cur_page === total_page && total_page > 5)?parseInt(initial_page)-1:initial_page;

        for(i = initial_page; i<cur_page; i++)
        {
            page_string += '<li class="page-item"><a class="page-link text-dark border-0 px-3" data-page="'+i+'">' + i + '</a></li>';
        }
    }
    else if(cur_page > 1 && cur_page <= before_page_limit)
    {
        var from = parseInt(before_page_limit) - parseInt(cur_page);
        from = (from == 0)?1:from;
        for(i = from; i<cur_page; i++)
        {
            page_string += '<li class="page-item"><a class="page-link text-dark border-0 px-3" data-page="'+i+'">' + i + '</a></li>';
        }
    }
    /* Current page*/
   /* page_string += '<li class="active page-item"><a class="page-link text-dark border-0 px-3">'+cur_page+'</a></li>';

    if(cur_page >= total_limit && (end_page < total_page || end_page == total_page))
    {
        page_string += '<li class="page-item"><a class="page-link text-dark border-0 px-3" data-page="'+end_page+'">' + end_page + '</a></li>';
    }
    else if(cur_page < total_limit)
    {
        var a = parseInt(total_limit) - parseInt(cur_page);
        var from = parseInt(cur_page) + 1;
        var to =  parseInt(cur_page) + a;

        to = (to <= total_page)?to:total_page;
        for(i=from; i<= to; i++)
        {
            page_string += '<li class="page-item" ><a class="page-link text-dark border-0 px-3" data-page="'+i+'">' + i + '</a></li>';
        }
    }
    var pager_string = '';
    if( cur_page > 1 )
    {
        pager_string += '<li class="page-item"><a class="page-link border-0 text-dark px-3" aria-label="Previous" data-page="'+ (parseInt(cur_page) - 1) +'"><span aria-hidden="true">«</span></a></li>'+ page_string;
    }
    else
    {
        pager_string += '<li class="disabled page-item"><a class="page-link text-dark border-0 px-3" aria-label="Previous" href="JavaScript: void(0);"><span aria-hidden="true">«</span></a></li>'+ page_string;
    }
    if( parseInt(cur_page) < parseInt(total_page) )
    {
        pager_string += '<li class="page-item"><a class="page-link text-dark border-0 px-3" aria-label="Next" data-page="'+ (parseInt(cur_page) + 1)+'"><span aria-hidden="true">»</span></a></li>';
    }
    else
    {
        pager_string += '<li class="disabled page-item"><a class="page-link text-dark border-0 px-3" aria-label="Next" href="JavaScript: void(0);"><span aria-hidden="true">»</span></a></li>';
    }*/
    return page_string;

}
function bindPaginationsLinks() {
    jQuery('#pms-area-pager li a').each(function() {
        jQuery(this).attr('href','JavaScript: void(0);');
        jQuery(this).bind("click", function(e){
            var P_No = jQuery(this).attr('data-page');
            if(jQuery(window).width() < 900)
            {
                var form = '#mbfrmsearch';
            }else{
                var form = '#frmlistingsearch';
            }

            if(isGrid !== 'true')
            {
               // jQuery('#pms-area-listing').scrollTop(0);
                jQuery(window).scrollTop( jQuery("#pms-area-listing").offset().top );
            }
            else if(isGrid == 'true' &&  isstyle ==10) {
                //jQuery('#pms-area-listing').scrollTop(0);
                jQuery(window).scrollTop( jQuery("#pms-area-listing").offset().top );
            }
            else{
                if(jQuery("#pms-area-listing").length>0) {
                    jQuery(window).scrollTop(jQuery("#pms-area-listing").offset().top);
                }
                else{
                    jQuery(window).scrollTop(0);
                }
            }

            getPage(P_No, form);
        });
    });
}
function mapdrag(){
    google.maps.event.addListener(map, 'dragend', function() {

        var mapZoomLevel = map.getZoom();

        var mapCenter = map.getCenter();

        jQuery('#MapZoomLevel').val(mapZoomLevel);
        jQuery('#MapCenterLat').val(mapCenter.lat());
        jQuery('#MapCenterLng').val(mapCenter.lng());

        // Disable Map Dragging
        map.setOptions({draggable: false});

        var bounds = map.getBounds();
        var sw = bounds.getSouthWest();
        var ne = bounds.getNorthEast();

        //jQuery('#map').val(sw.lat()+','+ sw.lng()+','+ ne.lat()+','+ ne.lng());
        isMapSearch =true;
        /* Do_MapSearch()*/
        Do_MapSearch(sw.lat(), sw.lng(), ne.lat(), ne.lng());

    });
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
        /* Do_MapSearch()*/
        Do_MapSearch(sw.lat(), sw.lng(), ne.lat(), ne.lng());
    });
}
function getPage(pageNo, searchForm, mapBoundary) {

    var send_data = [];
    var search_param = [];

    filter_param = jQuery('#pms-form-filter').serializeArray();
    predefinedId = jQuery('#pid').val();
    if (jQuery(searchForm).length > 0) {
        search_param = jQuery(searchForm).serializeArray();
    }

    send_data = jQuery.merge(jQuery.merge(send_data, search_param), filter_param);

    if(isGrid !== 'true')
    {
        if (jQuery('#AddressName').val() == '') {
            jQuery('#AddressValue').val('');
            jQuery('#AddressType').val('');
            if (searchForm == '#mbfrmsearch') {
                jQuery('#AddressValuembl').val('');
                jQuery('#AddressTypembl').val('');
            }

        }

        send_data.push({name: 'isBackSearch', value: isBackSearch});

        if(typeof(mapBoundary) == 'object')
            send_data.push({name:"map",value:mapBoundary});
    }

    send_data.push({name: 'pid', value: predefinedId});
    send_data.push({name: 'isAgentPre', value: isAgentPre});

    if(sys_name != '')
    {
        send_data.push({name: 'sys_name', value: sys_name});
    }
    if (typeof issorting !== 'undefined' && typeof issavesearch !== 'undefined'){
        //pass this two parametres because after ajax call we need to set again issorting or issavesearch button
        send_data.push({name: 'issorting', value: issorting});
        send_data.push({name: 'issavesearch', value: issavesearch});
    }
    /*if (typeof disclaimer !== 'undefined'){
        send_data.push({name: 'disclaimer', value: disclaimer});
    }*/
    if (predefinedId > 0 && typeof tabs !== 'undefined'){
        send_data.push({name: 'tabs', value: tabs});
    }
    if(isGrid === 'true')
    {
        send_data.push({name: 'isgrid', value: isGrid});
    }
    if (typeof isFilter !== 'undefined'){
        send_data.push({name: 'isFilter', value: isFilter});

    }
    if (typeof isRental !== 'undefined'){
        send_data.push({name: 'isRental', value: isRental});

    }
    if (typeof isHeading !== 'undefined'){
        send_data.push({name: 'isHeading', value: isHeading});

    }
    if (typeof isstyle !== 'undefined'){
        send_data.push({name: 'isstyle', value: isstyle});

    }
    send_data.push({name: 'spage', value: pageNo});
    send_data.push({name: 'ajax_in_site', value: true});
    send_data.push({name: 'action', value: objMapSearch.action});

    jQuery.jAjaxCall({
        send_data: send_data,
        xhr_area: 'LResult',
        xhr_module: 'MS_LP',
        xhr_action: '',
        xhr_timeout :   (1000*30),
        xhr_url: objMapSearch.url,
        callbefore_send: function (jqXHR, settings) {
            ShowHide_Loader('show');
        },
        callback_on_success: function (data, textStatus, jqXHR) {
            if(jQuery('#pms-map').length > 0)
            {
                if(isMapSearch == true){
                    ploatMarkers(jsonMapData);
                }else {
                    ploatMarkers(jsonMapData, 1);
                }
            }else{
                bindPaginationsLinks();
                var json = jQuery('.json');

                if(json.length > 0)
                {
                    jQuery.each(json, function (index, obj) {
                        var pid = jQuery(obj).attr('data-pid');
                        BindPropertiesInGrid(jQuery(obj).val(), pid);
                    });
                }
                else
                {
                    BindPropertiesInGrid(jsonMapData);
                }
            }

            if(data.DATA.weburl && isBackSearch == false)
            {
                window.history.pushState(null, null, data.DATA.weburl);
            }
            isBackSearch = false;
            stopPropagationMenu();
            doAdditionalBinding();
            bind_address_autosuggest();
            bindSort();
            setTimeout(function () {
                additionalBinding();
            }, 3000);

            lzl();
        },
        callback_on_error: function (jqXHR, textStatus, errorThrown) {},
        callback_on_complete: function (jqXHR, textStatus) {
            ShowHide_Loader('hide');
        }
    }, 'mapSearch');

}
function Do_MapSearch(swLat, swLng, neLat, neLng)
{
    if(jQuery(window).width() < 900)
    {
        var form = '#mbfrmsearch';
    }else{
        var form = '#frmlistingsearch';
    }

    getPage('1', form, [swLat, swLng, neLat, neLng]);
}
function lzl(){
    var container = window;


    if(jQuery('#pms-area-map').length > 0)
    {
           container = jQuery('#pms-area-listing');

    }
    jQuery('img.lzl').show().lazyload({
        data_attribute:'lzl',
        failure_limit:20,
        threshold : 1000,
        effect:"fadeIn",
        skip_invisible:true,
        container:container
    });
}
function marker_lzl(){
    var container = window;


    if(jQuery('#pms-area-map').length > 0)
    {
        container = jQuery('#pms-area-listing');

    }
    jQuery('.te-infobox img.lzl').show().lazyload({
        data_attribute:'lzl',
        failure_limit:20,
        threshold : 1000,
        effect:"fadeIn",
        skip_invisible:true,
        container:container
    });
}
