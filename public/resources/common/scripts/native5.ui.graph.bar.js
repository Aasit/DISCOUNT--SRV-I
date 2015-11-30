/* globals jQuery: false */
var native5 = (function ($) {
    "use strict";

    native5.ui = native5.ui || {};
    native5.ui.graph = native5.ui.graph || {};

    native5.ui.graph.bar = function(containerId, dataSeries, options) {
	  	this.containerId  = containerId || alert("no content Id");
	  	this.dataseries     = dataSeries || alert("enter dataSeries");
	  	this.plotBar = $.jqplot(this.containerId, this.dataseries, options);
	  	$('#'+this.containerId).bind('resize', function(event, ui) {
	  		this.plotBar.replot( { resetAxes: true } );
	  	});
	 };
	return native5;
}(jQuery, native5 || {}));