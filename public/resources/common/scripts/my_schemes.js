/*jshint loopfunc: true, quotmark: false */
/* global _, jQuery, akzo, native5, Backbone, moment, createCard, model */
(function ($) {
    "use strict";
	
	createCard($("#active-schemes"), "activeSchemesCard", "Active Schemes", "fa-list-alt");
	createCard($("#schemes-pending-approval"), "schemesPendingApprovalCard", "Schemes Pending Approval", "fa-list-alt");
	createCard($("#draft-schemes"), "draftSchemesCard", "Draft Schemes", "fa-list-alt");
	createCard($("#concluded-schemes"), "concludedSchemesCard", "Concluded Schemes", "fa-list-alt");

	$(".scheme-minimize-button").click(function(){
		if ($("i",$(this)).hasClass("fa-chevron-down")){
		    $(".scheme-minimize-button").parent().parent().find(".granular-info-box").hide();
		    $("i", $(".scheme-minimize-button")).removeClass("fa-chevron-up").addClass("fa-chevron-down");
		    $(this).parent().parent().find(".granular-info-box").show();
		    $("i", $(this)).removeClass("fa-chevron-down").addClass("fa-chevron-up");
		}
		else{
		    $(this).parent().parent().find(".granular-info-box").hide();
		    $("i", $(this)).removeClass("fa-chevron-up").addClass("fa-chevron-down");
		}
	});
	//active schemes chart ends


}(jQuery));