/*jshint loopfunc: true, quotmark:false */
/* global jQuery, native5 */
var app = (function ($, app) {
    "use strict";

    var schemeState = $("#modelDetails").data("state");
    if (schemeState == defaultStates.staged) {
        $("#sendTemplateData").hide();
        $("#checkTemplateData").text("Save Updated Scheme").data("target", "update");
        $("#updateTemplateData").text("Initiate Scheme").data("target", "initiate");
    }
    else if (schemeState == defaultStates.updateRequested) {
        $("#sendTemplateData").hide();
        $("#checkTemplateData").text("Update Scheme").data("target", "update");
        $("#updateTemplateData").text("Initiate Scheme").data("target", "initiate");
    }
    else if (schemeState == defaultStates.initiated) {
        $("#sendTemplateData").hide();
        $("#checkTemplateData").text("Send for Approval").data("target", "review");
        $("#updateTemplateData").text("Request Update").data("target", "requestUpdate");
    }
    else if (schemeState == defaultStates.reviewed) {
        $("#checkTemplateData").text("Approve Scheme").data("target", "approve");
        $("#updateTemplateData").text("Request Update").data("target", "requestUpdate");
        $("#sendTemplateData").text("Request Review").data("target", "requestReview");
    }
    else {
        $("#sendTemplateData").hide();
        $("#checkTemplateData").text("Save as Draft").data("target", "stage");
        $("#updateTemplateData").text("Initiate Scheme").data("target", "initiate");
    }
    $(".page-footer.page-buttons").css("display","block");

    var schemeModal = new native5.ui.modal({"top":50}); 
    schemeModal.render({"modalElm":"#n5-scheme-popup"});
    app.slabQCModal = new native5.ui.modal({"top":50}); 
    app.slabQCModal.render({"modalElm":"#n5-slab-qc-popup"});

    $("#scheme-from-existing").click(function(){
        schemeModal.showModal();
    });

    var timelineModal = new native5.ui.modal({"top":50}); 
    timelineModal.render({"modalElm":"#n5-timeline-popup"});

    $("#show-transitions").click(function(){
        timelineModal.showModal();
    });

    app.loader = new native5.ui.Loader({style: "gif"});
    app.loader.render();

    return app;
}(jQuery, app || {}));


$(document).ready(function() {
    Modernizr.load({
        test: Modernizr.input.placeholder,
        nope: '//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js',
        complete: function() {
            if (typeof Placeholders !== "undefined" && Placeholders !== null) {
                return Placeholders.enable();
            }
        }
    });
    createCard($("#active-schemes"), "activeSchemesCard", "Active Schemes", "fa-list-alt", "100%");
    createCard($("#schemes-pending-approval"), "schemesPendingApprovalCard", "Schemes Pending Approval", "fa-list-alt", "100%");
    createCard($("#draft-schemes"), "draftSchemesCard", "Draft Schemes", "fa-list-alt", "100%");

    window.prodExclusionModal = new native5.ui.modal();
    prodExclusionModal.render({"modalElm":"#n5-product-select-popup"});
    // akzo.ui.exclusionSelect();
});


