/*jshint loopfunc: true, quotmark:false */
/*global app:false, native5: false */
(function () {
    "use strict";
	$(document).ready(function () {
	    var a = "";
	    $(window).resize(function () {
	        $("#responsive-admin-menu #menu").removeAttr("style")
	    });
	    $("#menu a.submenu").click(function () {
	        if (a != "") {
	            $("#" + a).prev("a").removeClass("downarrow");
	            $("#" + a).slideUp()
	        };
	        if (a == $(this).attr("name")) {
	            $("#" + $(this).attr("name")).slideUp();
	            $(this).removeClass("downarrow");
	            a = ""
	        } else {
	            $("#" + $(this).attr("name")).slideDown();
	            a = $(this).attr("name");
	            $(this).addClass("downarrow")
	        };
	        return false
	    });
	});
	$("#trigger").css("cursor", "pointer"); 
	$("#trigger").on("click", function() {
		var width = $("#responsive-admin-menu").width();
		if (width < "50"){
			$("#responsive-admin-menu #menu a span").css("display","inline");
			$("#responsive-admin-menu").css("width","200px");
			$("#content-wrapper").css("margin-left", "200px");
			$('head').append("<style>#responsive-admin-menu #menu a.submenu:before {font-size: 14px; position: absolute; right: 15px}</style>");
		}
		else {
			$("#responsive-admin-menu #menu a span").css("display","none");
			$("#responsive-admin-menu").css("width","40px");
			$("#content-wrapper").css("margin-left", "40px");
			$('head').append("<style>#responsive-admin-menu #menu a.submenu:before {font-size: 6px;right: 5px}</style>");
		}
	});
}());