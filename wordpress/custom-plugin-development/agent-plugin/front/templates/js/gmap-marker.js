/**
 * @name OEMarker
 * @version 1.0 [April 19, 2012]
 * @author Oequal
 * @fileoverview OEMarker extends the Google Maps JavaScript API V3 <tt>OverlayView</tt> class.
 *  <p>
 *  Used to generate labeled marker
 *  <p>
 *  An OEMarker also fires the same events as a <tt>google.maps.Marker</tt>.
 */
 
 /**
 * Creates an OEMarker with the options specified.
 *  Call <tt>oeInfoBox.show</tt> to display the box to the map.
 * @constructor
 * @param {InfoBoxOptions} [opt_opts]
 */
function OEMarker(opt_opts) {
	
	opt_opts = opt_opts || {};
	
    // Now initialize all properties.
    this.content_ = opt_opts.content;
    this.map_ = opt_opts.map;
	this.position_ = opt_opts.position;
	this.boxClass_ = opt_opts.boxClass || "oeMarker"; // CSS Class Name For InfoBox

    // We define a property to hold the image's div. We'll 
    // actually create this div upon receipt of the onAdd() 
    // method so we'll leave it null for now.
    this.div_ = null;

    // Explicitly call setMap on this overlay
    this.setMap(map);
	//google.maps.OverlayView.apply(this, arguments);  
  }

/* OEMarker extends OverlayView in the Google Maps API v3.
 */
OEMarker.prototype = new google.maps.OverlayView();

/* You should create DOM objects and append them as children of the panes.
*/
OEMarker.prototype.onAdd = function() {

	// console.log('onAdd Called');
    // Note: an overlay's receipt of onAdd() indicates that
    // the map's panes are now available for attaching
    // the overlay to the map via the DOM.

    // Create the DIV and set some basic attributes.
    this.div_ = document.createElement('div');
  	this.div_.className = this.boxClass_;	
	this.div_.style.position = "absolute";

    // Create an IMG element and attach it to the DIV.
    var tmpEle = document.createElement("span");
	tmpEle.className = 'pricetag';
    tmpEle.innerHTML = this.content_;
    this.div_.appendChild(tmpEle);   
	
	// Set Arrow
	//var tmpEle = document.createElement("span");
	//tmpEle.className = 'point_border';
	//this.div_.appendChild(tmpEle);
	
	var tmpEle = document.createElement("span");
	tmpEle.className = 'pricetag_arrow';
	this.div_.appendChild(tmpEle);
	
    // We add an overlay to a map via one of the map's panes.	
	this.getPanes()["floatPane"].appendChild(this.div_);
			
	var me = this;	
	google.maps.event.addDomListener(this.div_, 'mouseover', function(){
		google.maps.event.trigger(me, 'mouseover');				
	});
	google.maps.event.addDomListener(this.div_, 'mouseout', function(){
		google.maps.event.trigger(me, 'mouseout');				
	});
	google.maps.event.addDomListener(this.div_, 'click', function(){
		google.maps.event.trigger(me, 'click');				
	});
	
	var cancelHandler = function (e) {
		e.cancelBubble = true;
		if (e.stopPropagation) {
		  e.stopPropagation();
		}
	};
	
	this.eventListeners_ = [];
	
		// Cancel event propagation.
		//
		events = ["mousedown", "mousemove", "mouseover", "mouseout", "mouseup",
		"click", "dblclick", "touchstart", "touchend", "touchmove"];
		
		for (i = 0; i < events.length; i++) {
		
		this.eventListeners_.push(google.maps.event.addDomListener(this.div_, events[i], cancelHandler));
	}
};

/* You should position these elements, which you have created in onAdd method.
*/
OEMarker.prototype.draw = function() {

	//console.log('draw Called');

	var pixPosition = this.getProjection().fromLatLngToDivPixel(this.position_);
	
	w = jQuery(this.div_).outerWidth();
	h = jQuery(this.div_).outerHeight();
	
	this.div_.style.left = (pixPosition.x - (w/2)) + "px";
	
	this.div_.style.top = (pixPosition.y - h) + "px";
};
  
/* You should remove the objects from the DOM.
*/
OEMarker.prototype.onRemove = function() {
	 
	 //console.log('onRemove Called');
    this.div_.parentNode.removeChild(this.div_);
    this.div_ = null;
};

/* Set Style
*/
OEMarker.prototype.setStyle = function(styleName, styleValue) {

	jQuery(this.div_).css(styleName, styleValue);
  //  this.div_.style.styleName = styleValue;   
};